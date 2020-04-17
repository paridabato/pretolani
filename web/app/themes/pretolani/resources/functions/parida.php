<?php

use function App\asset_path;

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('sage/parida.css', asset_path('styles/parida.css'), false, null);
}, 200);
