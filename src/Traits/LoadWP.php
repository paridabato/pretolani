<?php

namespace App\Traits;

trait LoadWP
{
    public static function load()
    {
        // Set up host, because we are in command line (for WP)
        if (!isset($_SERVER['HTTP_HOST'])) {
            $_SERVER['HTTP_HOST'] = "http://localhost";
        }

        // Set up ABSPATH
        if (!defined('ABSPATH')) {
            define('ABSPATH', dirname(__DIR__) . '/../web/wp/');
        }

        // Load WP
        require_once ABSPATH . 'wp-load.php';
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    }
}
