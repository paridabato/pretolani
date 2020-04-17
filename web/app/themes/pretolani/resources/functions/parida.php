<?php

namespace App;

use Roots\Sage\Container;

add_action( 'wp_enqueue_scripts', 'wp_enqueue_scripts_parida' );
function wp_enqueue_scripts_parida() {
    wp_enqueue_style('sage/parida.css', asset_path('styles/parida.css'), false, null);
}
