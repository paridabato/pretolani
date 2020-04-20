<?php

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('parida', get_template_directory_uri().'styles/parida.css', false, null);
}, 200);
