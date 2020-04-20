<?php

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('styles-animate', get_template_directory_uri().'/assets/styles/animate.css', false, null);
    wp_enqueue_style('styles-fullpage-min-parida', get_template_directory_uri().'/assets/styles/fullpage.min.css', false, null);
    wp_enqueue_style('styles-media', get_template_directory_uri().'/assets/styles/media.css', false, null);
    wp_enqueue_style('styles-swiper-min', get_template_directory_uri().'/assets/styles/swiper.min.css', false, null);

    wp_enqueue_script( 'script-fullpage-extensions-min', get_template_directory_uri() . '/assets/scripts/fullpage.extensions.min.js' );
    wp_enqueue_script( 'script-fullpage', get_template_directory_uri() . '/assets/scripts/fullpage.js' );
    wp_enqueue_script( 'script-gsap-latest-beta-min', get_template_directory_uri() . '/assets/scripts/gsap-latest-beta.min.js' );
    wp_enqueue_script( 'script-script', get_template_directory_uri() . '/assets/scripts/script.js' );
    wp_enqueue_script( 'script-SplitText3-min', get_template_directory_uri() . '/assets/scripts/SplitText3.min.js' );
    wp_enqueue_script( 'script-swiper-min', get_template_directory_uri() . '/assets/scripts/swiper.min.js' );
    wp_enqueue_script( 'script-wow', get_template_directory_uri() . '/assets/scripts/wow.js' );
}, 200);
