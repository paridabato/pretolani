<?php

namespace Tools\FakerPosts\Generate;

use OP\Framework\Helpers\PostHelper;
use OP\Framework\Helpers\AcfJsonHelper;
use OP\Framework\Utils\Media;

class Acf
{
    private static $_instance = null;

    private $faker;
    private $groups;
    private $user = null;

    /**
     * Init class with faker instance
     */
    private function __construct($faker)
    {
        $acf_json   = new AcfJsonHelper();

        $this->faker  = $faker;
        $this->groups = $acf_json->getGroups();
    }


    /**
     * Returns instance, creates one if needed
     *
     * @param  void
     * @return Acf
     */
    public static function getInstance($faker): Acf
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Acf($faker);
        }

        return self::$_instance;
    }

    /**
     * Set up faker user
     */
    public function setUserAs($user)
    {
        $this->user = $user;
    }


    /**
     * Choose which Dummy data generation methods to call for each field type
     *
     * @param array $fields
     */
    private function readFields($fields, string $prefix = ''): array
    {
        $metas = [];

        foreach ($fields as &$field) {
            $data = null;

            // Randomly don't feed a not required field
            if ($field->required === 0) {
                if (random_int(1, 5) === 1) {
                    unset($field);
                    continue;
                }
            }

            // Select action depending on field type
            switch ($field->type) {
                case 'textarea':
                    $data = $this->shortText($field);
                    break;
                case 'text':
                    $data = $this->text($field);
                    break;
                case 'wysiwyg':
                    $data = $this->wysiwyg($field);
                    break;
                case 'image':
                    $data = $this->img($field);
                    break;
                case 'email':
                    $data = $this->faker->safeEmail;
                    break;
                case 'url':
                    $data = $this->faker->url;
                    break;
                case 'link':
                    $data = $this->link();
                    break;
                case 'number':
                    $data = $this->int($field);
                    break;
                case 'true_false':
                    $data = 1;
                    break;
                case 'flexible_content':
                    $flex = $this->flexibleContent($field->layouts, $field->name);
                    break;
            }

            // Merge results into meta array
            if ($data) {
                $metas[implode('', [$prefix, $field->name])] = $data;
                $metas[implode('', ['_', $prefix, $field->name])] = $field->key;
            } elseif (isset($flex)) {
                $metas = $flex + $metas;
                unset($flex);
            }

            // TODO: conditionnal

            unset($data);
            unset($field);
        }

        return $metas;
    }


    /******************************************/
    /*                                        */
    /*              Entry point               */
    /*                                        */
    /******************************************/


    /**
     * Read ACF Json fields, get groups and format into metas
     *
     * @param  Faker   $faker Faker instance
     * @return Array_A Metas to be saved on post
     */
    public function getMetas()
    {
        $metas = [];

        $this->groups = array_filter($this->groups, function ($e) {
            return in_array($e->key, ['group_5e46b1033f730', 'group_5e4e93c71b981']);
        });


        foreach ($this->groups as $group) {
            $metas += $this->readFields($group->fields);
        }

        return $metas;
    }



    /******************************************/
    /*                                        */
    /*        Dummy data Generation           */
    /*                                        */
    /******************************************/



    private function shortText($field)
    {
        return $this->faker->text($field->maxlength ?: 60);
    }

    private function text($field)
    {
        return $this->faker->text($field->maxlength ?: 600);
    }

    private function wysiwyg($field)
    {
        return sprintf(
            "<h1>%s</h1><br><br>%s<br><br><br><h1>%s</h1><br><br>%s<br><br>",
            $this->faker->text(30),
            $this->faker->text(750),
            $this->faker->text(45),
            $this->faker->text(750)
        );
    }

    private function img($field)
    {
        $media = new Media();

        $width  = 1920;
        $height = 1080;

        if ($field->max_width && $field->max_height) {
            $width  = $field->max_width;
            $height = $field->max_height;
        } elseif ($field->min_width && $field->min_height) {
            $width  = $field->min_width;
            $height = $field->min_height;
        }

        $attach_id = $media->insertImageFromUrl(
            Image::getImageUrl(intval($width), intval($height)),
            sprintf("dummy__%s.jpg", wp_generate_password(25, false))
        );

        // Associate media with user, in order to allow mass deletion
        if ($this->user != null) {
            PostHelper::setPostPoperties($attach_id, [
                'post_author' => $this->user->id(),
            ]);
        }

        return $attach_id;
    }

    private function int($field)
    {
        $min = $field->min ?: 0;
        $max = $field->max ?: 999999999;

        return random_int($min, $max);
    }

    private function link()
    {
        return [
            'title' => trim($this->faker->text(35), '.'),
            'url' => $this->faker->url,
            'target' => '',
        ];
    }

    public function flexibleContent($layouts, $name)
    {
        $data = $blocs_order = [];

        $layouts = array_values((array) $layouts);

        for ($i = 0; $i < count($layouts); $i++) {
            $blocs_order[] = $layouts[$i]->name;
            $data += $this->readFields($layouts[$i]->sub_fields, "{$name}_{$i}_");
        }

        return $data + [$name => $blocs_order];
    }
}
