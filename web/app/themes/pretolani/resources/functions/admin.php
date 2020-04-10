<?php

/**
 * Admin CSS
 */
add_action('admin_enqueue_scripts', 'admin_custom_css');
function admin_custom_css()
{
    wp_register_style('custom-style', get_template_directory_uri() . '/admin.css');
    wp_enqueue_style('custom-style');
}

/**
 * Add Custom JS to Admin Back Office
 * Only on post.php & post-new.php
 */
add_action('admin_enqueue_scripts', 'admin_custom_js');
function admin_custom_js($hook)
{
    if ($hook == 'post.php' || $hook == 'post-new.php') {
        wp_register_script('custom-js', get_template_directory_uri() . '/admin.js');
        wp_enqueue_script('custom-js');
    } else {
        return;
    }
}

/**
 * Change Jquery Source to CDN
 */
add_action('init', 'cdn_jquery');
function cdn_jquery()
{
    $wp_jquery_ver = $GLOBALS['wp_scripts']->registered['jquery-core']->ver;
    $wp_jquery_ver = str_replace("-wp", "", $wp_jquery_ver);
    wp_register_script('jquery', ('https://cdnjs.cloudflare.com/ajax/libs/jquery/'. $wp_jquery_ver .'/jquery.min.js'), false, null, true);
    wp_enqueue_script('jquery');
}

/**
 * Remove ACF menu from back-office if not in development env
 */
add_action('init', 'remove_acf_from_backoffice_menu');
function remove_acf_from_backoffice_menu()
{
    if ($_ENV['WP_ENV'] !== 'development') {
        add_filter('acf/settings/show_admin', '__return_false');
    }
}
