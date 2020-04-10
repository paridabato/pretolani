<?php

/**
 * ACF Save JSON Folder
 */
add_filter('acf/settings/save_json', 'acf_json_save_point');
function acf_json_save_point($path)
{
    $path = __DIR__ . '/acf-json';
    return $path;
}

/**
 * ACF Load JSON Folder
 */
add_filter('acf/settings/load_json', 'acf_json_load_point');
function acf_json_load_point($paths)
{
    // remove original path (optional)
    unset($paths[0]);

    // append path
    $paths[] = __DIR__ . '/acf-json';

    // return
    return $paths;
}

/**
 * Change Flexible Content Thumbnail
 *
 * @see https://wordpress.org/plugins/acf-extended/#how%20to%20change%20the%20flexible%20content%3A%20thumbnails%20url%20in%20php%3F
 */

// By field name
// add_filter('acfe/flexible/thumbnail/name=my_flexible', 'acf_flexible_layout_thumbnail', 10, 3);
// function acf_flexible_layout_thumbnail($thumbnail, $field, $layout)
// {
//     // Must return an URL or Attachment ID
//     return '/app/themes/{theme_name}/resources/assets/images/thumbnails/{thumbnail_name}.jpg';
// }

// By field id
// add_filter('acfe/flexible/thumbnail/key=field_xxxxxx', 'acf_flexible_layout_thumbnail', 10, 3);
// function acf_flexible_layout_thumbnail($thumbnail, $field, $layout)
// {
//     // Must return an URL or Attachment ID
//     return '/app/themes/{theme_name}/resources/assets/images/thumbnails/{thumbnail_name}.jpg';
// }

/**
 * Change Flexible Content Layout Thumbnails
 *
 * @see https://wordpress.org/plugins/acf-extended/#how%20to%20change%20the%20flexible%20content%3A%20thumbnails%20url%20in%20php%3F
 */

// By field name & layout name
// add_filter('acfe/flexible/layout/thumbnail/name=my_flexible&layout=my_layout', 'acf_flexible_layout_thumbnail', 10, 3);
// function acf_flexible_layout_thumbnail($thumbnail, $field, $layout)
// {
//     // Must return an URL or Attachment ID
//     return '/app/themes/{theme_name}/resources/assets/images/thumbnails/{thumbnail_name}.jpg';
// }

// By field id & layout name
// add_filter('acfe/flexible/layout/thumbnail/key=field_xxxxxx&layout=my_layout', 'acf_flexible_layout_thumbnail', 10, 3);
// function acf_flexible_layout_thumbnail($thumbnail, $field, $layout)
// {
//     // Must return an URL or Attachment ID
//     return '/app/themes/{theme_name}/resources/assets/images/thumbnails/{thumbnail_name}.jpg';
// }
