<?php

/**
 * Overwrite meta title
 */
add_filter('wpseo_title', 'seo_title', -1000, 1);
function seo_title(string $title)
{
    return $title;
}

/**
 * Overwrite meta description
 */
add_filter('wpseo_metadesc', 'seo_metadesc', 10, 1);
function seo_metadesc(string $metadesc)
{
    return $metadesc;
}


/**
 * Additionnal rules for robots.txt
 */
add_filter('robots_txt', 'custom_robots_txt', 10, 2);
function custom_robots_txt($output, $public)
{
    // All environments
    $output = "User-agent: *\n";

    if (!$public) {
        // Staging
        $output .= "Disallow: /\n";
    } else {
        // Production
        $output .= "Sitemap: " . get_site_url() . "/sitemap.xml\n";
        $output .= "Disallow: /cgi-bin\n";
        $output .= "Disallow: /wp/wp-login.php\n";
        $output .= "Disallow: /wp/wp-admin/\n";
        $output .= "Disallow: /wp/wp-includes\n";
        $output .= "Disallow: /wp/wp-content\n";
        $output .= "Disallow: /wp/wp-content/uploads/\n";
        $output .= "Disallow: /wp/wp-content/plugins\n";
        $output .= "Disallow: /wp/wp-content/cache\n";
        $output .= "Disallow: /wp/wp-content/themes\n";
        $output .= "Disallow: /?s=*\n"; // Default search engine
        $output .= "Disallow: /*?s$\n";
        $output .= "Disallow: /*?s=*\n";
        $output .= "Disallow: /*?*&s=*\n";
        $output .= "Disallow: /*?*&s$\n";
        $output .= "Disallow: /?fwp_*\n"; // Custom search engine
        $output .= "Disallow: */feed\n";
        $output .= "Disallow: */comments\n";
        $output .= "Disallow: */trackback\n";
        $output .= "Disallow: /tag*\n";
        $output .= "Disallow: /category*\n";
        $output .= "Disallow: /project-type*\n";
        $output .= "Disallow: /author*\n";
        $output .= "Disallow: /*.pdf$\n";
        $output .= "Disallow: /*.swf$\n";
        $output .= "Disallow: /*.wmv$\n";
        $output .= "Disallow: /*.cgi$\n";
        $output .= "Disallow: /*.xhtml$\n";
        $output .= "Disallow: /*.php$\n";
        $output .= "Disallow: /*.inc$\n";
        $output .= "Disallow: /*.gz\n";
        $output .= "Disallow: /*.cgi\n";
        $output .= "Allow: /*.css$\n";
        $output .= "Allow: /*.js$\n";
        $output .= "Allow: /wp/wp-admin/admin-ajax.php\n";
        $output .= "Allow: /wp/wp-content/plugins/\n";
        $output .= "Allow: /wp/wp-content/themes/\n";
    }

    return $output;
};
