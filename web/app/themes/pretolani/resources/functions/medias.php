<?php

/**
 * Get the theme directory name
 * @return String
 */
if (!function_exists('get_theme_dir_name')) {
    function get_theme_dir_name(): string
    {
        return explode(DIRECTORY_SEPARATOR, get_stylesheet())[0];
    }
}

/**
 * Get file path from a directory and subdirectories
 *
 * @return array
 */
function glob_recursive($pattern, $flags = 0): array
{
    $files = glob($pattern, $flags);

    foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
        $files = array_merge($files, glob_recursive($dir.'/'.basename($pattern), $flags));
    }

    return $files;
}

/**
 * Add SVG to media
 */
add_filter('upload_mimes', 'cc_mime_types');
function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
