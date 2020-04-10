<?php

namespace App\CustomPostTypes;

use App\CustomPostTypes\Abstracts\CustomPostType;

class EtudeDeCas extends CustomPostType
{
    protected static $domain;

    protected static $cpt = 'etude-de-cas';

    /**
     * Singular and plural names of CPT
     */
    public static $singular = 'Étude de cas';
    public static $plural   = 'Études de cas';

    /**
     * Icon to be displayed in back-office menu
     */
    public static $menu_icon = 'dashicons-nametag';

    /**
     * Used to display 'un' or 'une'
     */
    public static $is_female = true;

    /**
     * Enable graphql
     */
    public static $graphql_enabled = false;



    /**
     * Register CTP to wordpress
     */
    public function init($domain)
    {
        static::$domain = $domain;

        $args_override   = [];
        $labels_override = [];

        static::register($args_override, $labels_override);
    }
}
