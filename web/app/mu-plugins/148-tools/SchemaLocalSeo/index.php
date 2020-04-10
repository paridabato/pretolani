<?php

/**
 * Add Schema Local SEO on Admin Menu
 */

function add_schema_local_seo()
{
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page([
            'page_title'  => __('Schema Local SEO', '148-options'),
            'menu_title'  => __('Schema Local SEO', '148-options'),
            'menu_slug'  => 'schema-local-seo',
            'icon_url' => 'dashicons-performance',
        ]);
    }
}

add_action('admin_menu', 'add_schema_local_seo');

/**
 * Disable Schema Local SEO SearchAction by Yoast SEO plugin
 */
add_filter('disable_wpseo_json_ld_search', '__return_true');
