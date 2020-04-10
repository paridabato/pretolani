<?php

add_action('init', function () {
    if (function_exists('get_field') && get_field('save_mail_in_db', 'option')) {
        new \Tools\ContactForm\CustomPostTypes\Contact('148-contact');
    }
});

/**
 * Add contact form on Admin Menu
 */

function add_contact_form()
{
    if (!function_exists('acf_add_options_page')) {
        return;
    }

    acf_add_options_page([
        'page_title'  => __('Contact Form', '148-options'),
        'menu_title'  => __('Contact Form', '148-options'),
        'menu_slug'  => 'contact-form-options',
        'show_in_graphql' => true
        // 'icon_url' => 'dashicons-performance',
    ]);
}

add_action('acf/init', 'add_contact_form');
