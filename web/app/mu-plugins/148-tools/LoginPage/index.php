<?php

/**
 * Login CSS
 */

function login_custom_css()
{
    $path = explode('mu-plugins', __DIR__)[1] ?? '';
    wp_register_style('custom-style', WPMU_PLUGIN_URL . $path . '/assets/css/login.css');
    wp_enqueue_style('custom-style');
}
add_action('login_enqueue_scripts', 'login_custom_css');
