<?php

namespace Tools\ContactForm\CustomPostTypes;

class Contact
{
    private $domain;

    public function __construct($domain)
    {
        $this->domain = $domain;

        $labels = array(
            'name'                  => _x('Contacts', 'Post Type General Name', $this->getDomain()),
            'singular_name'         => _x('Contact', 'Post Type Singular Name', $this->getDomain()),
            'menu_name'             => __('Contacts', $this->getDomain()),
            'name_admin_bar'        => __('Contact', $this->getDomain()),
            'archives'              => __('Contact Archives', $this->getDomain()),
            'attributes'            => __('Contact Attributes', $this->getDomain()),
            'parent_item_colon'     => __('Parent Contact:', $this->getDomain()),
            'all_items'             => __('All Contacts', $this->getDomain()),
            'add_new_item'          => __('Add New Contact', $this->getDomain()),
            'add_new'               => __('Add New', $this->getDomain()),
            'new_item'              => __('New Contact', $this->getDomain()),
            'edit_item'             => __('Edit Contact', $this->getDomain()),
            'update_item'           => __('Update Contact', $this->getDomain()),
            'view_item'             => __('View Contact', $this->getDomain()),
            'view_items'            => __('View Contacts', $this->getDomain()),
            'search_items'          => __('Search Contact', $this->getDomain()),
            'not_found'             => __('Not found', $this->getDomain()),
            'not_found_in_trash'    => __('Not found in Trash', $this->getDomain()),
            'featured_image'        => __('Featured Image', $this->getDomain()),
            'set_featured_image'    => __('Set featured image', $this->getDomain()),
            'remove_featured_image' => __('Remove featured image', $this->getDomain()),
            'use_featured_image'    => __('Use as featured image', $this->getDomain()),
            'insert_into_item'      => __('Insert into Contact', $this->getDomain()),
            'uploaded_to_this_item' => __('Uploaded to this Contact', $this->getDomain()),
            'items_list'            => __('Contacts list', $this->getDomain()),
            'items_list_navigation' => __('Contacts list navigation', $this->getDomain()),
            'filter_items_list'     => __('Filter Contacts list', $this->getDomain()),
        );
        $args = array(
            'label'                 => __('Contact', $this->getDomain()),
            'description'           => __('Create a Contact', $this->getDomain()),
            'labels'                => $labels,
            'supports'              => array('title'),
            'hierarchical'          => false,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 10,
            'menu_icon'             => 'dashicons-megaphone',
            'show_in_admin_bar'     => false,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => false,
            'capability_type'       => 'post',
            // 'capabilities' => array(
            //     'create_posts' => 'do_not_allow',
            // ),
        );
        register_post_type('contact', $args);
        $this->createTaxonomies();
    }

    public function createTaxonomies()
    {
        $labels = array(
            'name' => _x('Types', 'taxonomy general name'),
            'singular_name' => _x('Type', 'taxonomy singular name'),
            'search_items' =>  __('Search Types'),
            'all_items' => __('All Types'),
            'parent_item' => __('Parent Type'),
            'parent_item_colon' => __('Parent Type:'),
            'edit_item' => __('Edit Type'),
            'update_item' => __('Update Type'),
            'add_new_item' => __('Add New Type'),
            'new_item_name' => __('New Type Name'),
            'menu_name' => __('Types'),
        );

        // Now register the taxonomy
        register_taxonomy('contactform_type', array('contact'), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
        ));

        add_action('admin_init', [$this, 'generateTaxonomies']);


        add_action('acf/render_field/name=contact_information', function () {
            global $post;

            $data = get_field('information', $post->ID);
            // echo \App\template('dynamic_message/contact-information', $data);
            sprintf('<h3>%s</h3>', __('Nom du formulaire', $this->getDomain()));
            sprintf('<p>%s</p>', $data['type']);
            sprintf('<h3>%s</h3>', __('Contenu', $this->getDomain()));
            sprintf('<p>%s</p>', nl2br(htmlspecialchars($data['content'])));
            if ($data['attachment']) {
                sprintf('<h3>%s</h3>', __('Pièce(s) jointe(s)', $this->getDomain()));
                sprintf('<a href="%s" download>%s</a>', $data['attachment'], __('Download', $this->getDomain()));
            }
        });
    }

    // TODO: Voir pour le template sur Nuxt
    public function generateTaxonomies()
    {
        $args = array(
            'post_type' => 'page',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => '_wp_page_template',
                    'value' => 'views/template-contact.blade.php' // Comme faire sur Nuxt
                )
            )
        );

        $pages = new \WP_Query($args);
        $terms = get_terms(array(
            'taxonomy' => 'contactform_type',
            'hide_empty' => false,
        ));

        $termsToDelete = array_filter($terms, function ($v) use ($pages) {
            foreach ($pages->posts as $page) {
                if ($v->name === get_field('form_type', $page->ID)) {
                    return false;
                }
            }

            return true;
        });

        $termsToAdd = array_filter($pages->posts, function ($v) use ($terms) {
            foreach ($terms as $term) {
                if ($term->name === get_field('form_type', $v->ID)) {
                    return false;
                }
            }

            return true;
        });

        foreach ($termsToDelete as $termToDelete) {
            wp_delete_term($termToDelete->term_id, 'contactform_type');
        }

        foreach ($termsToAdd as $termToAdd) {
            wp_insert_term(get_field('form_type', $termToAdd->ID), 'contactform_type');
        }
    }

    public function getDomain()
    {
        return $this->domain;
    }
}
