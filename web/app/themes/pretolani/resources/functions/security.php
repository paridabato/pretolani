<?php

/**
 * Remove WordPress Meta Generator
 */
remove_action('wp_head', 'wp_generator');

/**
 * Hide WordPress Version Info
 */
add_filter('the_generator', 'hide_wordpress_version');
function hide_wordpress_version()
{
    return '';
}

/**
 * Remove WordPress Version Number In URL Parameters From JS/CSS
 */
if (!is_admin()) {
    add_filter('style_loader_src', 'hide_wordpress_version_in_script', 10, 2);
    add_filter('script_loader_src', 'hide_wordpress_version_in_script', 10, 2);
}
function hide_wordpress_version_in_script($src, $handle)
{
    $src = remove_query_arg('ver', $src);
    return $src;
}

/**
 * Remove WPML Meta Generator
 */
global $sitepress;
remove_action('wp_head', array($sitepress, 'meta_generator_tag'));

/**
 * Hide Yoast version
 */
add_action('template_redirect', 'remove_yoast_seo_comments', 9999);
function remove_yoast_seo_comments()
{
    if (!class_exists('WPSEO_Frontend')) {
        return;
    }
    $instance = WPSEO_Frontend::get_instance();
    if (!method_exists($instance, 'debug_mark')) {
        return;
    }

    remove_action('wpseo_head', array( $instance, 'debug_mark'), 2);
}

/**
 * Disable embed alternate URLs
 * @see: https://wordpress.org/plugins/disable-embeds/
 */
add_action('init', 'disable_embeds_init', 9999);
function disable_embeds_init()
{
    global $wp;

    $wp->public_query_vars = array_diff($wp->public_query_vars, array(
        'embed',
    ));

    add_filter('rest_endpoints', function ($endpoints) {
        unset($endpoints['/oembed/1.0/embed']);
        return $endpoints;
    });

    add_filter('oembed_response_data', function ($data) {
        if (defined('REST_REQUEST') && REST_REQUEST) {
            return false;
        }
        return $data;
    });

    add_filter('embed_oembed_discover', '__return_false');

    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');

    add_filter('tiny_mce_plugins', function ($plugins) {
        return array_diff($plugins, array('wpembed'));
    });

    add_filter('rewrite_rules_array', function ($rules) {
        foreach ($rules as $rule => $rewrite) {
            if (false !== strpos($rewrite, 'embed=true')) {
                unset($rules[ $rule ]);
            }
        }
        return $rules;
    });

    remove_filter('pre_oembed_result', 'wp_filter_pre_oembed_result', 10);

    add_action('enqueue_block_editor_assets', function () {
        wp_enqueue_script(
            'disable-embeds',
            plugins_url('js/editor.js', __FILE__),
            array(
                'wp-edit-post',
                'wp-editor',
                'wp-dom',
            ),
            '20181202',
            true
        );
    });

    add_action('wp_default_scripts', function ($scripts) {
        if (!empty($scripts->registered['wp-edit-post'])) {
            $scripts->registered['wp-edit-post']->deps = array_diff(
                $scripts->registered['wp-edit-post']->deps,
                array( 'wp-embed' )
            );
        }
    });
}
