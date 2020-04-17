<?php

add_action( 'wp_enqueue_scripts', 'wp_enqueue_scripts_parida' );
function wp_enqueue_scripts_parida() {
    wp_enqueue_style('parida', get_template_directory_uri() . 'styles/parida.css');
}
