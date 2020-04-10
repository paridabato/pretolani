<?php

/**
 * Prevent Image Size on Upload
 */
if (defined('IMG_MAX_SIZE') && IMG_MAX_SIZE) {
    add_filter('wp_handle_upload_prefilter', 'image_size_prevent');
    function image_size_prevent($file)
    {
        $size = $file['size'];
        $size = $size / 1024; // Calculate down to KB
        $type = $file['type'];
        $is_image = strpos($type, 'image');
        $limit = (int) IMG_MAX_SIZE; // Your Filesize in KB

        if (($size > $limit) && ($is_image !== false)) {
            $file['error'] = 'Image files must be smaller than ' . $limit . 'KB';
        }

        return $file;
    }
}

/**
 * Prevent Image Dimension on Upload
 * Create All version of image
 */
if (defined('IMG_MAX_WIDTH') && IMG_MAX_WIDTH && defined('IMG_MAX_HEIGHT') && IMG_MAX_HEIGHT) {
    add_filter('wp_handle_upload', 'image_upload', 10, 2);
    function image_upload($array, $context)
    {

        $extension = strtolower(pathinfo($array['file'], PATHINFO_EXTENSION));

        # Check if is image
        if (in_array($extension, array('jpg', 'jpeg', 'gif', 'png', 'tif', 'bmp', 'ico', 'webp'))) {
            # Check image dimension
            $file_data = getimagesize($array['file']);

            if (!$file_data) {
                return $array;
            }

            $m_width    = (int) IMG_MAX_WIDTH;
            $m_height   = (int) IMG_MAX_HEIGHT;

            list($width, $height) = $file_data;

            if ($m_width <= $width || $m_height <= $height) {
                $array = wp_handle_upload_error(
                    $file_data,
                    sprintf('Image must be smaller than %sx%spx', $m_width, $m_height)
                );

                return $array;
            }

            if (!wp_next_scheduled('generate_all_images_event')) {
                wp_schedule_single_event(time() + 30, 'generate_all_images_event');
            }


            // Uncomment to create all version on each file upload
            // # Create instance
            // $image = new \Tools\Images\Image($array['file']);

            // # Optimize original image
            // $image->optimize();

            // # Create mobile and retina version
            // $breakpoints = explode(' ', IMG_BREAKPOINTS);

            // # Generate all version
            // $image->generate($breakpoints);
        }

        return $array;
    }
}

/**
 * Add metadata Image Media
 */
// Uncomment to create all meta on each file upload
// add_filter('wp_generate_attachment_metadata', 'generate_responsive_image', 10, 2);
// function generate_responsive_image($metadata, $attachment_id)
// {
//     $upload_dir = wp_upload_dir();
//     $uploaded_image_location = $upload_dir['basedir'] . '/' . $metadata['file'];

//     $extension = strtolower(pathinfo($uploaded_image_location, PATHINFO_EXTENSION));

//     if (in_array($extension, array('jpg', 'jpeg', 'gif', 'png', 'tif', 'bmp', 'ico', 'webp'))) {
//         $image = new \Tools\Images\Image($uploaded_image_location);
//         $breakpoints = explode(' ', IMG_BREAKPOINTS);
//         $image->generateMeta($attachment_id, $breakpoints);
//     }

//     return $metadata;
// }


/**
 * Clean file name
 */
add_filter('sanitize_file_name', 'clean_file_name', 10);
function clean_file_name($filename)
{
    $info = pathinfo($filename);
    $ext  = empty($info['extension']) ? '' : '.' . $info['extension'];
    $name = preg_replace("/[^a-z0-9_.-]/", "", basename($filename, $ext));

    return $name . $ext;
}

/**
 * Delete responsive images
 */
add_filter('delete_attachment', 'delete_responsive_image');
function delete_responsive_image($image_id)
{
    $url = wp_get_attachment_url($image_id);
    $uploads = wp_upload_dir();
    $file_path = str_replace($uploads['baseurl'], $uploads['basedir'], $url);
    $dirname = pathinfo($file_path, PATHINFO_DIRNAME);
    $filename = pathinfo($file_path, PATHINFO_FILENAME);
    $extension = pathinfo($file_path, PATHINFO_EXTENSION);

    # Delete all image
    $images = glob($dirname . '/' . $filename . '@*w.' . $extension);

    foreach ($images as $image) {
        unlink($image);
    }

    # Delete all webp image
    $images = glob($dirname . '/' . $filename . '*.webp');

    foreach ($images as $image) {
        unlink($image);
    }
}

/**
 * Disable Wordpress from creating thumbnails
 */
add_filter('intermediate_image_sizes_advanced', 'add_image_insert_override');
function add_image_insert_override($sizes)
{
    unset($sizes['thumbnail']);
    unset($sizes['medium']);
    unset($sizes['medium_large']);
    unset($sizes['large']);
    unset($sizes['full']);
    return $sizes;
}

/**
 * Create Hook for check & generate all image version
 */
if (defined('IMG_BREAKPOINTS') && IMG_BREAKPOINTS) {
    add_action('generate_all_images_event', 'generate_all_images');
    function generate_all_images()
    {
        $query_images_args = array(
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'post_status'    => 'inherit',
            'posts_per_page' => -1,
        );
    
        $query_images = new WP_Query($query_images_args);
    
        foreach ($query_images->posts as $post) {
            if (json_decode(get_post_meta($post->ID, 'media_version', true), true) == null) {
                $url = wp_get_attachment_url($post->ID);
                $uploads = wp_upload_dir();
                $file_path = str_replace($uploads['baseurl'], $uploads['basedir'], $url);
    
                # Create instance
                $image = new \Tools\Images\Image($file_path);
    
                # Optimize original image
                $image->optimize();
    
                # Create mobile and retina version
                $breakpoints = explode(' ', IMG_BREAKPOINTS);
    
                # Generate all version
                $image->generate($breakpoints);
    
                # Generate Meta Version
                $image->generateMeta($post->ID, $breakpoints);
            }
        }
    }
}

/**
 * Add another schedules cron
 */
// add_filter('cron_schedules', 'add_cron_interval');
// function add_cron_interval($schedules)
// {
//     $schedules['five-minutes'] = array(
//         'interval' => 300,
//         'display'  => esc_html__('Every Five Minutes'),
//     );

//     return $schedules;
// }


/**
 * Hook for WPGraphQL
 * Add Media Version Meta Data in MediaItem Type
 */
if (defined('WP_ECODESIGN') && WP_ECODESIGN && defined('IMG_BREAKPOINTS') && IMG_BREAKPOINTS) {
    add_action('graphql_register_types', 'register_media_version_types');
    function register_media_version_types($type_registry)
    {
        # Create all types for media_version data representation
        $breakpoints = explode(' ', IMG_BREAKPOINTS);

        $fields = [
            'blurred' => [
                'type' => 'String',
                'description' => __('Blurred Version 4px Base64', 'your-textdomain'),
            ],
            'original' => [
                'type' => 'MediaVersionOriginal',
                'description' => __('Original Version', 'your-textdomain'),
            ],
        ];

        foreach ($breakpoints as $breakpoint) {
            $key = sprintf('w%s', $breakpoint);

            $fields[$key] = [
                'type' => 'MediaVersionBreakpoint',
                'description' => __(sprintf('Version %spx', $breakpoint), 'your-textdomain'),
            ];
        }

        register_graphql_object_type('MediaVersion', [
            'description' => __("All Version of one media", 'your-textdomain'),
            'fields' => $fields
        ]);

        register_graphql_object_type('MediaVersionRetina', [
            'description' => __("Version 1x and 2x for retina", 'your-textdomain'),
            'fields' => [
                'x1' => [
                    'type' => 'String',
                    'description' => __('Version 1x', 'your-textdomain'),
                ],
                'x2' => [
                    'type' => 'String',
                    'description' => __('Version 12x', 'your-textdomain'),
                ]
            ]
        ]);

        register_graphql_object_type('MediaVersionBreakpoint', [
            'description' => __("One Size Of Version", 'your-textdomain'),
            'fields' => [
                'size' => [
                    'type' => 'String',
                    'description' => __('Width of Breakpoint', 'your-textdomain'),
                ],
                'normal' => [
                    'type' => 'MediaVersionRetina',
                    'description' => __('Normal Version', 'your-textdomain'),
                ],
                'webp' => [
                    'type' => 'MediaVersionRetina',
                    'description' => __('Webp Version', 'your-textdomain'),
                ]
            ]
        ]);

        register_graphql_object_type('MediaVersionOriginal', [
            'description' => __("One Size Of Version", 'your-textdomain'),
            'fields' => [
                'normal' => [
                    'type' => 'String',
                    'description' => __('Normal Version', 'your-textdomain'),
                ],
                'webp' => [
                    'type' => 'String',
                    'description' => __('Webp Version', 'your-textdomain'),
                ]
            ]
        ]);

        # Add mediaVersionType to mediaItem Field
        register_graphql_field('MediaItem', 'mediaVersion', [
            'description' => __('Get Media Version', 'your-textdomain'),
            'type' => 'MediaVersion',
            'resolve' => function ($post) {
                return json_decode(get_post_meta($post->ID, 'media_version', true), true);
            }
        ]);
    }
}