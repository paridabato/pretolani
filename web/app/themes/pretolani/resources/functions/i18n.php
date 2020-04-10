<?php

/**
 * Allow to search for current language posts only
 * Use `suppress_filters => false` with get_posts() and WP_Query
 */
if (defined('ICL_SITEPRESS_VERSION')) {
    global $sitepress;
    $sitepress->get_current_language();
    $sitepress->switch_lang($sitepress->get_current_language());
}

/**
 * Add widget area to handle language switcher
 */
add_action('widgets_init', 'access_widgets_init');
function access_widgets_init()
{
    register_sidebar(array(
        'name'          => 'Language Switcher',
        'id'            => 'language-switcher',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
    ));
}
