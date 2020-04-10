<?php

namespace App\Taxonomies;

use App\Taxonomies\Abstracts\Taxonomy;

class Sector extends Taxonomy
{
    protected static $domain;

    protected static $taxonomy = 'sector';


    /**
     * Singular and plural names of CPT
     */
    public static $singular = 'Sector';
    public static $plural   = 'Sectors';


    /**
     * Enable graphql
     */
    public static $graphql_enabled = true;

    /**
     * Post types that will have the taxonomy
     */
    protected static $post_types = [
        'formation',
        'etude-de-cas',
    ];


    /**
     * Class constructor, register CTP to wordpress
     */
    public function init($domain)
    {
        static::$domain = $domain;

        $args_override   = [];
        $labels_override = [];

        static::register($args_override, $labels_override);
    }
}
