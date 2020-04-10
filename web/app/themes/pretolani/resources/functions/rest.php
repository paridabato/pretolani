<?php

/**
 * This is an example to enable REST Endpoints
 * Uncomment lines below if you want if to work
 */
// use App\Api\ContactApi;

/**
 * Enable REST Endpoints
 */
add_action('rest_api_init', function () {
//     ContactApi::init();
});

/**
 * Only allow same origin for REST endpoints
 * TODO: enable on production
 */
remove_filter('rest_pre_serve_request', 'rest_send_cors_headers');
add_filter('rest_pre_serve_request', function ($value) {
    header('Access-Control-Allow-Origin: ' . esc_url_raw(site_url()));
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Credentials: true');
    return $value;
});
