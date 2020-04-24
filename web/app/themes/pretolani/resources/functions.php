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
    wp_enqueue_style('fonts', get_template_directory_uri() . '/assets/fonts/stylesheet.css');
    wp_enqueue_style('animate', get_template_directory_uri() . '/assets/styles/animate.css');
    wp_enqueue_style('fullpage', get_template_directory_uri() . '/assets/styles/fullpage.min.css');
    wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/styles/swiper.min.css');

    wp_enqueue_style('styles', get_stylesheet_uri());
    wp_enqueue_style('media-styles', get_template_directory_uri() . '/assets/styles/media.css');


    wp_enqueue_script('jquery-js', get_template_directory_uri() . '/assets/scripts/jquery-1.11.1.min.js', array(), null, false);
    // wp_localize_script('jquery-js', 'ajaxurl', admin_url( 'admin-ajax.php' ) );

    wp_enqueue_script('gsap', get_template_directory_uri() . '/assets/scripts/gsap-latest-beta.min.js', array('jquery'), null, false);
    wp_enqueue_script('splittext', get_template_directory_uri() . '/assets/scripts/SplitText3.min.js', array('jquery'), null, false);
    wp_enqueue_script('fullpage', get_template_directory_uri() . '/assets/scripts/fullpage.js', array('jquery'), null, false);
    wp_enqueue_script('wow', get_template_directory_uri() . '/assets/scripts/wow.js', array('jquery'), null, false);
    wp_enqueue_script('swiper', get_template_directory_uri() . '/assets/scripts/swiper.min.js', array('jquery'), null, false);
    wp_enqueue_script('script', get_template_directory_uri() . '/assets/scripts/script.js', array('jquery'), null, false);
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

function gv($var)
{
    $gv = array();
    $gv['tp'] = get_template_directory_uri();
    $gv['imgp'] = get_template_directory_uri() . '/assets/images';
    $gv['logo'] = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 346.2 47.97"><defs><style>.cls-1{fill:#1d1d1b;}</style></defs><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><g id="Logo"><path class="cls-1" d="M0,0V48H25.06L48.91,24.13V0ZM43.93,24v1.19H24V43.06H4.92V5h39Z"/><polygon class="cls-1" points="139.08 9.99 160.1 9.99 160.1 16.1 145.03 16.1 145.03 21.09 158.19 21.09 158.19 25.93 144.95 25.93 144.95 32.03 160.1 32.03 160.1 37.98 139.08 37.98 139.08 9.99"/><polygon class="cls-1" points="168.09 9.99 191.1 9.99 191.1 16.1 183.01 16.1 183.01 37.98 177.15 37.98 177.15 16.18 168.09 16.18 168.09 9.99"/><path class="cls-1" d="M213.52,9.82A14.17,14.17,0,1,0,227.68,24,14.16,14.16,0,0,0,213.52,9.82Zm0,22.27a8.1,8.1,0,1,1,8.1-8.1A8.11,8.11,0,0,1,213.52,32.09Z"/><polygon class="cls-1" points="238.89 9.99 238.89 37.98 258.24 37.98 258.24 32.12 245.02 32.12 245.02 9.99 238.89 9.99"/><polygon class="cls-1" points="304.33 9.99 310.36 9.99 322.2 25.24 322.2 9.99 329.07 9.99 329.07 37.98 323.37 37.98 311.42 22.05 311.31 37.98 304.33 37.98 304.33 9.99"/><polygon class="cls-1" points="340.18 9.99 346.2 9.99 346.2 37.98 340.18 38.15 340.18 9.99"/><path class="cls-1" d="M88.89,10H74V38h6V29.1h8.88s7-.79,7-9A10,10,0,0,0,88.89,10ZM86.27,23.07H80V16.15h6.23C91.93,20.06,86.27,23.07,86.27,23.07Z"/><path class="cls-1" d="M122.83,27.28s5.15.87,5.15-8.41S121,10,121,10H105.15V38h7v-9h3.81l6,9h7V36.24Zm-4.73-4.21h-5.92V16.15h5.92C125.76,19.85,118.1,23.07,118.1,23.07Z"/><path class="cls-1" d="M283.51,10h-6.24L266,38l6.23.17,3-7.09h10.79L288.69,38H295Zm-6.4,15.94c.11-.21,3.38-8,3.38-8l3.23,8Z"/></g></g></g></svg>';
    return $gv[$var];
}