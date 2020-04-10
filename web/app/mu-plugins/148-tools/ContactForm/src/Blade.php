<?php

namespace Tools\ContactForm;

require_once __DIR__ . '/../vendor/autoload.php';

use Jenssegers\Blade\Blade as BladeCore;

final class Blade extends BladeCore
{
    private static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Blade();
        }

        return self::$instance;
    }

    private function __construct()
    {
        $views_path = __DIR__ . '/../views';
        $cache_path = wp_upload_dir()['basedir'] ?? '.';
        $cache_path = $cache_path . '/cache/contact_form_blade';

        if (!is_dir($cache_path)) {
            mkdir($cache_path, 0770, true);
        }

        parent::__construct($views_path, $cache_path);
    }

    public static function template(string $view, array $data = [], array $mergeData = []): string
    {
        return self::getInstance()->render($view, $data, $mergeData);
    }

    private static function displayFolderPermsNotice()
    {
        $plg_opts = json_decode(readfile('../composer.json'));

        echo '<div class="error notice">
            <p>'.$plg_opts->name.' Plug-in\'s cache folder missing permission, please set at least 0770 on this folder.</p>
        </div>';
    }
}
