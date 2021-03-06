<?php

namespace App\CustomPostTypes\Abstracts;

abstract class CustomPostType
{
    protected static $domain;

    protected static $cpt = 'custom-post-type';

    /**
     * Singular and plural names of CPT
     */
    public static $singular = 'custom_p_type';
    public static $plural   = 'custom_p_types';

    /**
     * Icon to be displayed in back-office menu
     */
    public static $menu_icon = 'dashicons-book';

    /**
     * Used to display 'un' or 'une'
     */
    public static $is_female = false;

    /**
     * Enable graphql
     */
    public static $graphql_enabled = false;


    /**
     * Class constructor, protect use of class without initialisation
     */
    public function __construct()
    {
        if (empty(static::$domain)) {
            throw new \Exception("Please init CustomPostType child before using this class methods.");
        }
    }


    /**
     * Class constructor, register CTP to wordpress
     */
    protected static function register(array $args = [], array $labels = [])
    {
        if (post_type_exists(static::$cpt)) {
            return;
        }

        $singular   = static::$singular;
        $plural     = static::$plural;

        $base_labels = array(
            'name'                  => _x("{$plural}", 'Post Type General Name', '148-posttypes'),
            'singular_name'         => _x("{$singular}", 'Post Type Singular Name', '148-posttypes'),
            'menu_name'             => __("{$plural}", '148-posttypes'),
            'name_admin_bar'        => __("{$singular}", '148-posttypes'),
            'archives'              => __("{$singular} Archives", '148-posttypes'),
            'attributes'            => __("{$singular} Attributes", '148-posttypes'),
            'parent_item_colon'     => __("Parent {$singular}:", '148-posttypes'),
            'all_items'             => __("Tous les {$plural}", '148-posttypes'),
            'add_new_item'          => __("Add New {$singular}", '148-posttypes'),
            'add_new'               => __("Ajouter", '148-posttypes'),
            'new_item'              => __("Nouveau {$singular}'", '148-posttypes'),
            'edit_item'             => __("Éditer {$singular}", '148-posttypes'),
            'update_item'           => __("Mettre à jour {$singular}", '148-posttypes'),
            'view_item'             => __("Voir {$singular}", '148-posttypes'),
            'view_items'            => __("Voir {$plural}", '148-posttypes'),
            'search_items'          => __("Rechercher {$singular}", '148-posttypes'),
            'not_found'             => __("Non trouvé", '148-posttypes'),
            'not_found_in_trash'    => __("Non trouvé dans la corbeille", '148-posttypes'),
            'featured_image'        => __("Image mise en avant", '148-posttypes'),
            'set_featured_image'    => __("Définir image mise en avant", '148-posttypes'),
            'remove_featured_image' => __("Retirer image mise en avant", '148-posttypes'),
            'use_featured_image'    => __("Utiliser comme image mise en avant", '148-posttypes'),
            'insert_into_item'      => __("Insert into {$singular}", '148-posttypes'),
            'uploaded_to_this_item' => __("Uploaded to this {$singular}", '148-posttypes'),
            'items_list'            => __("{$plural} list", '148-posttypes'),
            'items_list_navigation' => __("{$plural} list navigation", '148-posttypes'),
            'filter_items_list'     => __("Filter {$plural} list", '148-posttypes'),
        );

        $pronoun = static::$is_female ? 'une' : 'un';

        // Override default labels with the specified custom ones
        $labels = array_replace($base_labels, $labels);

        $base_args = array(
            'label'                 => __("{$singular}", '148-posttypes'),
            'description'           => __("Créer {$pronoun} {$singular}", '148-posttypes'),
            'labels'                => $labels,
            'supports'              => array('title', 'thumbnail'),
            'taxonomies'            => array(),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 20,
            'menu_icon'             => static::$menu_icon,
            'show_in_admin_bar'     => false,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => false,
            'rest_base'             => static::$cpt,
        );

        // If graphql is enabled, we need to setup some more params
        if (static::$graphql_enabled) {
            $base_args = array_replace($base_args, [
                'show_in_graphql'       => true,
                'graphql_single_name'   => static::graphqlFormatName($singular),
                'graphql_plural_name'   => static::graphqlFormatName($plural),
                'graphql_singular_type' => static::graphqlFormatName($singular),
                'graphql_plural_type'   => static::graphqlFormatName($plural),
            ]);
        }

        // Override default args with the specified custom ones
        $args = array_replace($base_args, $args);

        register_post_type(static::$cpt, $args);
    }


    /**
     * Returns CPT's domain
     */
    public function getDomain()
    {
        return static::$domain;
    }

    /**
     * Convert label to graphql name
     * 'Étude de cas' => 'etudeDeCas'
     */
    protected static function graphqlFormatName(string $type)
    {
        return lcfirst(preg_replace('/\s/', '', ucwords(str_replace('-', ' ', sanitize_title($type)))));
    }
}
