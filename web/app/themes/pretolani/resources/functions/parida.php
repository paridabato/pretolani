<?php

namespace App;

use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;

add_action( 'wp_enqueue_scripts', 'wp_enqueue_scripts_parida' );
function wp_enqueue_scripts_parida() {
    wp_enqueue_style('sage/parida.css', asset_path('styles/parida.css'), false, null);
}
