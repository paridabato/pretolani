<?php

/**
 * Excerpt
 *
 * @param $text, $length
 */
function excerpt($text, $length)
{
    if (mb_strlen($text) <= $length) {
        return $text;
    }
    $text = mb_substr($text, 0, $length);
    if (mb_substr($text, $length - 1, 1) !== ' ') {
        $parts = explode(' ', $text);
        array_pop($parts);
        $text = implode(' ', $parts);
    }
    return trim($text). '…';
}

/**
 * getSourceId
 *
 * @param $id, $postType
 */
function getSourceId($id, $postType)
{
    // will return the source lang of the current post
    $defaultLang = apply_filters('wpml_element_language_details', null, array('element_id' => $id, 'element_type' => $postType));

    // will return the source id of the current post. If the translation is missing it will return the original id (like $id)
    $sourceId = apply_filters('wpml_object_id', $id, $postType, true, $defaultLang->source_language_code);

    return $sourceId;
}

/**
 * Add Theme options
 */
if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title' => 'Theme General',
        'menu_title' => 'Theme Options',
        'menu_slug'  => 'theme-options',
        'capability' => 'edit_posts',
        'redirect'   => false
    ]);
    acf_add_options_sub_page([
        'page_title'  => 'Form Contact',
        'menu_title'  => 'Form Contact',
        'parent_slug' => 'theme-options',
    ]);
}
