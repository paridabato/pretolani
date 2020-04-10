<?php
namespace Tools\ContactForm\Api;

use Tools\ContactForm\Helpers\FileUpload;
use Tools\ContactForm\Blade;
use stdClass;
use ZipArchive;

class ContactApi
{
    private const URL = "https://www.google.com/recaptcha/api/siteverify";
    private const INVALIDFROMID = 90;
    private const INVALIDFIELD = 95;
    private const NOTOKEN = 100;
    private const INVALIDTOKEN = 105;
    private const WPMAILERROR = 110;
    private const SUCCESS = 200;

    private static $fail_message;
    private static $success_message;
    private static $save_mail_in_db;
    private static $fields;
    private static $post;
    private static $uploadDir;
    private static $hash;

    public static function init()
    {
        self::$fail_message = get_field('fail_message', 'option') ?: 'Error';
        self::$success_message = get_field('success_message', 'option') ?: 'Success';
        self::$save_mail_in_db = get_field('save_mail_in_db', 'option') ?: false;
        self::$uploadDir = sprintf('%s/148contact-files', wp_upload_dir()['basedir']);
        self::$hash = \uniqid();

        /**
         * Contact form endpoint
         * /contact/v1/contact
         *
         * @method POST
         */
        register_rest_route('contact/v1', '/contact(?:/(?P<id>\d+))', array(
            'methods'  => 'POST',
            'callback' => array(self::class, 'onSubmit'),
            'args' => array(
                'id' => array(
                    'validate_callback' => function ($param) {
                        return is_string($param);
                    }
                ),
            )
        ));

        /**
         * get files endpoint
         * /contact/v1/files
         *
         * @method POST
         */
        register_rest_route('contact/v1', '/files(?:/(?P<id>\w+))', array(
            'methods'  => 'GET',
            'callback' => array(self::class, 'getFiles'),
            'args' => array(
                'id' => array(
                    'validate_callback' => function ($param) {
                        return is_string($param);
                    }
                ),
            )
        ));
    }

    /**
     * Handle on sumbit request
     *
     * @param WP_REST_Request $request
     */
    public static function onSubmit(\WP_REST_Request $request)
    {
        $body = $request->get_body_params();
        $files = $request->get_file_params();
        $ID = $request->get_param('id');
        self::$post = get_post($ID);

        if ((self::$post && !get_field('contact_form', $ID)) || !self::$post) {
            return self::error(self::INVALIDFROMID, self::$fail_message, 404);
        }

        self::$fields = get_field('contact_form', $ID);

        $isFieldValid = self::checkFields($body);
        if (!$isFieldValid) {
            return self::error(self::INVALIDFIELD, self::$fail_message, 404);
        }

        if (!isset($body['captcha-token'])) {
            return self::error(self::NOTOKEN, self::$fail_message, 404);
        }

        $response = self::verifyToken($body['captcha-token']);
        if (!$response->success) {
            return self::error(self::INVALIDTOKEN, self::$fail_message, 404);
        }

        $isMailSended = self::sendEmail($body, $files);
        if (!$isMailSended) {
            return self::error(self::WPMAILERROR, self::$fail_message, 404);
        }

        return self::success(self::SUCCESS, self::$success_message, 200);
    }

    /**
     * Verify the token
     *
     * @param String $token
     * @return stdClass
     */
    private static function verifyToken(string $token)
    {
        $options = [
            CURLOPT_URL            => self::URL,
            CURLOPT_POST           => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POSTFIELDS     => [
                'secret'   => RECAPTCHA_SECRET_KEY,
                'response' => $token
            ]
        ];

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }

    /**
     * Check if fields are valid
     *
     * @param Array $body
     * @return Boolean
     */
    private static function checkFields($body)
    {
        foreach (self::$fields as $key => $property) {
            $name = $property['acf_fc_layout'] . '_' . $key;

            if (!isset($body[$name])) {
                continue;
            }

            if ((isset($property['required']) && $property['required'] && empty($body[$name])) ||
                (isset($property['minlength']) && !empty($property['minlength']) && strlen($body[$name]) < $property['minlength']) ||
                (isset($property['maxlength']) && !empty($property['maxlength']) && strlen($body[$name]) > $property['maxlength']) ||
                (isset($property['min_choice']) && !empty($property['min_choice']) && count($body[$name]) < $property['min_choice']) ||
                (isset($property['max_choice']) && !empty($property['max_choice']) && count($body[$name]) > $property['max_choice']) ||
                (isset($property['min']) && !empty($property['min']) && $body[$name] < $property['min']) ||
                (isset($property['max']) && !empty($property['max']) && $body[$name] > $property['max']) ||
                ($property['acf_fc_layout'] === "email" && !filter_var($body[$name], FILTER_VALIDATE_EMAIL)) ||
                ($property['acf_fc_layout'] === "phone" && !self::isPhoneNumber($body[$name]))
            ) {
                return false;
            }
        }

        return true;
    }

    /**
     * Handle the email sending
     *
     * @param Array $body
     * @return boolean
     */
    private static function sendEmail($body, $files)
    {
        $headers = [
            'Content-Type: text/html; charset=UTF-8'
        ];
        $attachments = [];
        $to = self::getEmailByObject($body) ?: get_field('mail_to', self::$post->ID);
        $from = get_field('mail_from', self::$post->ID);
        $subject = get_field('subject', self::$post->ID);
        $id = self::$post->ID;
        $content = self::generateContent($body)('');
        $information = [
            "type" => get_field('form_type', $id),
            "content" => $content,
            'attachment' => null,
        ];

        if (empty($to)) {
            return false;
        }

        if (!empty($from)) {
            $headers[] = sprintf('From: %s', $from);
        }

        if (!empty($files)) {
            foreach ($files as $file) {
                if (filesize($file['tmp_name']) > 5000000) {
                    return false;
                }
                if (is_uploaded_file($file['tmp_name'])) {
                    $attachments[] = $file['tmp_name'];
                }
            }

            if ($attachments) {
                $information['attachment'] = sprintf('%s/wp-json/contact/v1/files/%s', WP_HOME, self::$hash);
            }
        }

        $isMailSend = wp_mail(
            $to,
            $subject,
            Blade::template('mail/mail', $information),
            $headers,
            $attachments
        );
        
        if (!$isMailSend) {
            return false;
        }

        if (self::$save_mail_in_db) {
            if (!empty($files)) {
                $isFileSaved = self::saveFiles($files);
                if (!$isFileSaved) {
                    return false;
                }
            }

            $isEmailSaved = self::saveEmail(self::getEmail($body), $information);
            if (!$isEmailSaved) {
                return false;
            }
        }

        return true;
    }

    /**
     * Save the Email in DB
     *
     * @param Array $body
     * @return void
     */
    private static function saveEmail($title, $information)
    {
        $id = self::$post->ID;
        $term = get_term_by('name', get_field('form_type', self::$post->ID), 'contactform_type');
        $term_id = $term->term_id;

        $insertedPostID = wp_insert_post([
            'post_type' => 'contact',
            'post_title' => $title,
            'post_status' => 'publish',
            'meta_input' => [
                'information' => $information
            ]
        ]);

        wp_set_object_terms($insertedPostID, array($term_id), 'contactform_type');

        return $insertedPostID;
    }

    private static function generateContent(array $body)
    {
        $array = $body;
        unset($array['captcha-token']);

        return function ($initial) use ($array) {
            $merged = $initial;

            foreach ($array as $key => $value) {
                $field = self::getFieldByKey($key);
                $label = isset($field['label']) ? $field['label'] : $key;

                if (\is_array($value)) {
                    $merged .= "$label : ". implode(", ", $value) . "\n";
                } else {
                    $merged .= "$label : $value \n";
                }
            }

            return $merged;
        };
    }

    /**
     * Upload File to the server
     *
     * @param Array $files
     * @return void
     */
    private static function saveFiles(array $files)
    {
        $fileUpload = new FileUpload(self::$uploadDir);
        foreach ($files as $file) {
            if (is_uploaded_file($file['tmp_name'])) {
                $status = $fileUpload->upload($file, self::$hash);
                if (!$status) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * To get attached File
     *
     * @param \WP_REST_Request $request
     * @return void
     */
    public static function getFiles(\WP_REST_Request $request)
    {
        $ID = $request->get_param('id');
        $files = glob(self::$uploadDir . '/*');
        $matches = \preg_grep('#' . $ID . '#', $files);
        $fileToDownload = null;
        $toUnlink = false;

        if (count($matches) === 1) {
            foreach ($matches as $match) {
                $fileToDownload = $match;
            }
        } elseif (count($matches) > 1) {
            $zip = new ZipArchive();
            $fileToDownload = self::$uploadDir ."/$ID.zip";

            if ($zip->open($fileToDownload, ZipArchive::CREATE) !== true) {
                exit("Impossible d'ouvrir le fichier <$fileToDownload>\n");
            }

            foreach ($matches as $match) {
                $zip->addFile($match, \basename($match));
            }

            $zip->close();
            $toUnlink = true;
        } else {
            return self::error(404, "Not found", 404);
        }

        if ($fileToDownload && \file_exists($fileToDownload)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($fileToDownload).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fileToDownload));
            flush(); // Flush system output buffer
            readfile($fileToDownload);
            if ($toUnlink) {
                unlink($fileToDownload);
            }
            exit;
        }
    }

    /**
     * Error message
     *
     * @param $code
     * @param string $message
     * @param $status
     * @return WP_Error
     */
    private static function error($code, string $message, $status)
    {
        return new \WP_Error($code, $message, array( 'status' => $status ));
    }

    /**
     * Success message
     *
     * @param $code
     * @param string $message
     * @param $status
     */
    private static function success($code, string $message, $status)
    {
        $success = new stdClass();
        $success->code = $code;
        $success->message = $message;
        $success->status = $status;

        return $success;
    }

    /**
     * check phone number
     *
     * @param string $phone
     * @return boolean
     */
    private static function isPhoneNumber($phone)
    {
        $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
        $phone_to_check = str_replace("-", "", $filtered_phone_number);

        if (strlen($phone_to_check) > 14) {
            return false;
        }

        return true;
    }

    private static function getEmail($body)
    {
        foreach ($body as $key => $value) {
            if (\preg_match('/email/', $key)) {
                return $value;
            }
        }
    }

    private static function getEmailByObject($body)
    {
        foreach (self::$fields as $key => $property) {
            $name = $property['acf_fc_layout'] . '_' . $key;

            if ($property['acf_fc_layout'] !== "select" || !isset($body[$name])) {
                continue;
            }

            if ($property['use_mail']) {
                foreach ($property['options'] as $option) {
                    if ($option['value'] === $body[$name]) {
                        return $option['email'];
                    }
                }
            }
        }

        return null;
    }

    private static function getFieldByKey($compareValue)
    {
        foreach (self::$fields as $key => $field) {
            $name = $field['acf_fc_layout'] . '_' . $key;
            if ($name === $compareValue) {
                return $field;
            }
        }
    }
}
