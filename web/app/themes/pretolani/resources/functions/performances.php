<?php

/**
 * Defer Javascript
 */
add_filter('script_loader_tag', 'defer_js_parsing', 10, 2);
function defer_js_parsing($tag, $handle)
{
    if ('sage/main.js' === $handle) {
        return str_replace(' src', ' defer src', $tag);
    }
    return $tag;
}
