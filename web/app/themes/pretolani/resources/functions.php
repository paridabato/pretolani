<?php

/**
 * Do not edit anything in this file unless you know what you're doing
 */

use Roots\Sage\Config;
use Roots\Sage\Container;

/**
 * Helper function for prettying up errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$sage_error = function ($message, $subtitle = '', $title = '') {
    $title = $title ?: __('Sage &rsaquo; Error', 'sage');
    $footer = '<a href="https://roots.io/sage/docs/">roots.io/sage/docs/</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die($message, $title);
};

/**
 * Ensure compatible version of PHP is used
 */
if (version_compare('7.1', phpversion(), '>=')) {
    $sage_error(__('You must be using PHP 7.1 or greater.', 'sage'), __('Invalid PHP version', 'sage'));
}

/**
 * Ensure compatible version of WordPress is used
 */
if (version_compare('4.7.0', get_bloginfo('version'), '>=')) {
    $sage_error(__('You must be using WordPress 4.7.0 or greater.', 'sage'), __('Invalid WordPress version', 'sage'));
}

/**
 * Ensure dependencies are loaded
 */
if (!class_exists('Roots\\Sage\\Container')) {
    if (!file_exists($composer = __DIR__.'/../vendor/autoload.php')) {
        $sage_error(
            __('You must run <code>composer install</code> from the Sage directory.', 'sage'),
            __('Autoloader not found.', 'sage')
        );
    }
    require_once $composer;
}

/**
 * Sage required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map(function ($file) use ($sage_error) {
    $file = "../app/{$file}.php";
    if (!locate_template($file, true, true)) {
        $sage_error(sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file), 'File not found');
    }
}, ['helpers', 'setup', 'filters', 'admin']);

/**
 * Here's what's happening with these hooks:
 * 1. WordPress initially detects theme in themes/sage/resources
 * 2. Upon activation, we tell WordPress that the theme is actually in themes/sage/resources/views
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/sage/resources
 *
 * We do this so that the Template Hierarchy will look in themes/sage/resources/views for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/sage/resources
 *
 * This is not compatible with the WordPress Customizer theme preview prior to theme activation
 *
 * get_template_directory()   -> /srv/www/example.com/current/web/app/themes/sage/resources
 * get_stylesheet_directory() -> /srv/www/example.com/current/web/app/themes/sage/resources
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/current/web/app/themes/sage/resources/views
 * └── TEMPLATEPATH           -> /srv/www/example.com/current/web/app/themes/sage/resources
 */
array_map(
    'add_filter',
    ['theme_file_path', 'theme_file_uri', 'parent_theme_file_path', 'parent_theme_file_uri'],
    array_fill(0, 4, 'dirname')
);
Container::getInstance()
    ->bindIf('config', function () {
        return new Config([
            'assets' => require dirname(__DIR__).'/config/assets.php',
            'theme' => require dirname(__DIR__).'/config/theme.php',
            'view' => require dirname(__DIR__).'/config/view.php',
        ]);
    }, true);

/**
 * Include custom functions PHP files
 */
foreach (glob(__DIR__ .'/functions/*.php') as $filename) {
    include $filename;
}


/* REMOVE EMOJI START */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');
/* REMOVE EMOJI END */

remove_filter('the_content', 'wpautop');

add_filter('excerpt_length', function () {
    return 50;
});

/* REMOVE GUTENBERG STYLES START */

function smartwp_remove_wp_block_library_css()
{
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
}

add_action('wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css');

/* REMOVE GUTENBERG STYLES END */

/* REMOVE ATTRS START */
add_action('wp_loaded', 'prefix_output_buffer_start');
function prefix_output_buffer_start()
{
    ob_start("prefix_output_callback");
}

function prefix_output_callback($buffer)
{
    return preg_replace("%[ ]type=[\'\"]text\/(javascript|css)[\'\"]%", '', $buffer);
}

/* REMOVE ATTRS END */

/* CF7 remove tags START */
add_filter('wpcf7_autop_or_not', '__return_false');
/* CF7 remove tags end */


function load_js_css()
{
    wp_enqueue_style('fonts', get_template_directory_uri() . '/fonts/stylesheet.css');
    wp_enqueue_style('animate', get_template_directory_uri() . '/css/animate.css');
    wp_enqueue_style('fullpage', get_template_directory_uri() . '/css/fullpage.min.css');
    wp_enqueue_style('swiper', get_template_directory_uri() . '/css/swiper.min.css');

    wp_enqueue_style('styles', get_stylesheet_uri());
    wp_enqueue_style('media-styles', get_template_directory_uri() . '/css/media.css');


    wp_enqueue_script('jquery-js', get_template_directory_uri() . '/js/jquery-1.11.1.min.js', array(), null, false);
    // wp_localize_script('jquery-js', 'ajaxurl', admin_url( 'admin-ajax.php' ) );

    wp_enqueue_script('gsap', get_template_directory_uri() . '/js/gsap-latest-beta.min.js', array('jquery'), null, false);
    wp_enqueue_script('splittext', get_template_directory_uri() . '/js/SplitText3.min.js', array('jquery'), null, false);
    wp_enqueue_script('fullpage', get_template_directory_uri() . '/js/fullpage.js', array('jquery'), null, false);
    wp_enqueue_script('wow', get_template_directory_uri() . '/js/wow.js', array('jquery'), null, false);
    wp_enqueue_script('swiper', get_template_directory_uri() . '/js/swiper.min.js', array('jquery'), null, false);
    wp_enqueue_script('script', get_template_directory_uri() . '/js/script.js', array('jquery'), null, false);
}

add_action('wp_enqueue_scripts', 'load_js_css');


/* POST THUMBNAILS START */
/*if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(412, 240);
}*/

/* POST THUMBNAILS END */


add_action('after_setup_theme', function () {
    register_nav_menus(array(
        'main_menu' => 'Main menu',
    ));
});


/* ACF theme options START */
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(
        array(
            'page_title' => 'Theme settings',
            'menu_title' => 'Theme settings',
            'menu_slug' => 'theme-options',
            'capability' => 'edit_posts',
            'parent_slug' => '',
            'position' => false,
        )
    );
    acf_add_options_sub_page(
        array(
            'page_title' => 'Global',
            'menu_title' => 'Global',
            'menu_slug' => 'theme-options-global',
            'capability' => 'edit_posts',
            'parent_slug' => 'theme-options',
            'position' => false,
            'icon_url' => false,
            'redirect' => false,
        )
    );
}
/* ACF theme options END */


/* Fix 404 error for custom post type pages */

flush_rewrite_rules(false);

/* Thumbs START */
/*add_image_size('social-icon', 32, 32, true);
add_image_size('info-icon', 75, 75, true);
add_image_size('expertise-icon', 40, 40, true);*/
/* Thumbs END */


/*

function catName($cat_id) {
    $cat_id = (int) $cat_id;
    $category = get_category($cat_id);
    return $category->name;
}
function catLink($cat_id) {
    $category = get_the_category();
    $category_link = get_category_link($cat_id);
    return $category_link;
}
*/

function language_selector_flags()
{
    $languages = icl_get_languages('skip_missing=0&orderby=code');
    $lc = 1;
    if (!empty($languages)) {
        foreach ($languages as $l) {
            if (!$l['active']) {
                echo '<a class="langs__item" href="' . $l['url'] . '">';
            } else {
                echo '<a class="langs__item active">';
            }
            echo strtoupper($l['code']);
            echo '</a>';
            $lc++;
        }
    }
}
