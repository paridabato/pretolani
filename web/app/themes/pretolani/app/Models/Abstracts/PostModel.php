<?php

namespace App\Models\Abstracts;

use Exception;

abstract class PostModel
{
    /**
     * Post_id
     */
    protected $post_id;


    /**
     *
     */
    private $post;


    /**
     * Register model's post type
     *
     * @return void
     */
    public function register()
    {
        if (!isset(static::$post_type)
             || empty(static::$post_type)
             || !post_type_exists(static::$post_type)) {
            throw new \Exception((static::$post_type ?? 'undefined') . " is not a registred post_type");
        }
    }


    /**
     * Model constructor
     * Retrieve post_type model from database and setup variables
     *
     * @param int|null $model_id (optionnal)
     *
     * @return void
     */
    public function construct(int $model_id = null)
    {
        if (!isset(static::$post_type) || static::$post_type == null) {
            throw new Exception("Model's post_type must be registred");
        }

        if ($model_id === null) {
            $model_id = $this->create();
        }

        $post = get_post($model_id);

        if ($post === null) {
            throw new Exception("Failed to retreive post");
        } elseif ($post->post_type !== static::$post_type) {
            throw new Exception("Given post id is not part of the current model post_type");
        } else {
            $this->post_id = $model_id;
        }
    }



    /// *****  Class functions  ***** ///


    /**
     * Return post_id
     *
     * @return int post_id
     */
    public function id()
    {
        return $this->post_id;
    }


    /**
     * Return post_type
     *
     * @return string post_type
     */
    public function postType()
    {
        return static::$post_type;
    }


    /**
     * Retreive the post object from WP
     *
     * @param bool $refresh Refresh data from database
     * @return object
     */
    public function get(bool $refresh = false)
    {
        if ($this->post == null || $refresh === true) {
            $this->post = $this->getPost();
            $this->post_id = $this->post->ID;
        }

        return $this->post;
    }


    /**
     * Create a new Model in database
     *
     * @return int $post_id
     */
    public function create()
    {
        return wp_insert_post(
            [
                'post_title'    => 'Draft title',
                'post_status'   => 'draft',
                'post_type'     => static::$post_type
            ]
        );
    }


    /**
     * Publish the current post
     *
     * @return void
     */
    public function publish()
    {
        wp_publish_post($this->post_id);
    }


    /**
     * Trash the current post
     *
     * @return void
     */
    public function trash()
    {
        wp_trash_post($this->post_id);
    }


    /**
     * Delete permanently the current post
     *
     * @return void
     */
    public function delete()
    {
        wp_delete_post($this->post_id, true);
    }


    /**
     * Get the post permalink
     *
     * @return string|false
     */
    public function permalink()
    {
        return get_permalink($this->post_id);
    }


    /**
     * Retrieve post metas from database
     *
     * @return array
     */
    public function metas()
    {
        return get_post_custom($this->post_id);
    }


    /**
     * Retrieve post metas keys from database
     *
     * @return array
     */
    public function metasKeys()
    {
        return array_keys($this->metas());
    }


    /**
     * Get the post creation date at the specified date_format (php ref)
     *
     * @param string $format Eg. 'd/m/y' for '18/02/19'
     *
     * @return string
     */
    public function postDate($format = 'd/m/Y')
    {
        return get_the_date($format, $this->post_id);
    }



    /** CPT related **/



    /**
     * Return Custom post type label
     * if no params are specified, get the CPT singular name
     *
     * @param string $x Label tag to retrieve
     *
     * @return string|void
     */
    public function cptLabel(string $x = 'singular_name')
    {
        $labels = $this->cptLabels();

        if ($labels) {
            $labels = (array) $labels;
            return $labels[$x] ?? '';
        }
    }


    /**
     * Return custom post type labels
     *
     * @return object
     */
    public function cptLabels()
    {
        $postType = get_post_type_object(static::$post_type);

        if ($postType) {
            return $postType->labels ?? [];
        }
    }




    /**  WP Functions **/




    /**
     * Retrieve post from database
     *
     * @return \WP_post|array
     */
    public function getPost($output = OBJECT)
    {
        return get_post($this->post_id, $output);
    }




    /** Getters **/



    /**
     * Get a post meta based on meta key
     *
     * @param string $meta_key key colrresponding to the meta
     * @param bool   $single   optional $single see get_post_meta() single opt
     *
     * @return array|string|int
     */
    public function getMeta(string $meta_key, bool $single = true)
    {
        return get_post_meta($this->post_id, $meta_key, $single);
    }


    /**
     * Retrieve post taxonomies
     *
     * @param $hide_empty Weither should we get terms unused
     * @return array
     */
    public function getTaxonomies($hide_empty = false)
    {
        $values = array();
        $taxonomies = get_post_taxonomies($this->post_id);

        foreach ($taxonomies as $taxonomy) {
            $values[$taxonomy] = get_terms(
                [
                    'taxonomy' => $taxonomy,
                    'hide_empty' => $hide_empty
                ]
            );
        }
        return $values;
    }


    /**
     * Get post terms selected in a given taxonomy
     *
     * @param  string $taxonomy Taxonomy slug to search in
     * @return array
     */
    public function getTaxonomyTerms(string $taxonomy)
    {
        return wp_get_post_terms($this->post_id, $taxonomy);
    }


    /**
     * Return post thumbnail
     *
     * @param string|array $size (optionnal)
     * @param string|array $attr (optionnal)
     *
     * @return string|bool The post thumbnail image tag. False on failure (no thumbnail image)
     *
     * @reference https://developer.wordpress.org/reference/functions/get_the_post_thumbnail/
     */
    public function getPrintableThumbnail($size = 'post-thumbnail', $attr = '')
    {
        if (has_post_thumbnail($this->post_id)) {
            return get_the_post_thumbnail($this->post_id, $size, $attr);
        }
        return false;
    }


    /**
     * Return thumbnail information such as image dimensio and public url
     *
     * @param string|array $size (optionnal)
     * @return array|false
     *
     * @reference https://developer.wordpress.org/reference/functions/wp_get_attachment_image_src/
     */
    public function getThumbnailInfos($size = 'post-thumbnail')
    {
        return wp_get_attachment_image_src($this->getThumbnailID(), $size) ?? false;
    }


    /**
     * Return post thumbnail id
     *
     * @return int The post thumbnail image id
     */
    public function getThumbnailID()
    {
        return (int) get_post_thumbnail_id($this->post_id);
    }


    /**
     * Update post to database
     *
     * @param WP_Post|array $post post data to be updated
     *
     * @return void
     */
    protected function updatePost($post)
    {
        wp_update_post($post);
    }




    /** ACF Methods **/


    /**
     * Get an ACF field from a given key
     *
     * @param string $key
     * @return mixed
     */
    public function getField(string $key)
    {
        return get_field($key, $this->post_id);
    }



    /** Setters **/



    /**
     * Update post's given property
     *
     * @param string $property property key to be affected
     * @param mixed $value value to set
     *
     * @return void
     */
    public function setPostProperty(string $property, $value)
    {
        $post = $this->get();
        $post[$property] = $value;
        $this->updatePost($post);
    }


    /**
     * Update post's given properties
     *
     * @param array_a $args Associative array [property_key => value]
     *
     * @return void
     */
    public function setPostProperties(array $args)
    {
        $post = $this->get();

        foreach ($args as $key => $value) {
            $post[$key] = $value;
        }

        $this->updatePost($post);
    }


    /**
     * Update post meta
     *
     * @param string $key      name of post metas to be updated in the database
     * @param mixed  $value    value of post metas to be updated in the database
     * @param bool   $multiple tells is the meta key unique or not
     *
     * @return void
     */
    public function setMeta(string $key, $value, $multiple = false)
    {
        if ($multiple === false) {
            return update_post_meta($this->post_id, $key, $value);
        } else {
            return add_post_meta($this->post_id, $key, $value, false);
        }
    }


    /**
     * Update post meta
     *
     * @param array $metas ['meta_key' => 'meta_value']
     *
     * @return void
     */
    public function setMetas(array $metas)
    {
        foreach ($metas as $key => $value) {
            $this->setMeta($key, $value);
        }
    }


    /**
     * Update Property's taxonomies.
     *
     * @param string $taxonomy taxonomy key
     * @param array  $terms    terms list
     *
     * @return void
     */
    public function setTaxonomyTerms(string $taxonomy, array $terms)
    {
        wp_set_post_terms($this->post_id, [], $taxonomy, false);
        wp_set_post_terms($this->post_id, $terms, $taxonomy, false);
    }



    // ** Statics methods ** //




    /**
     * Get all the properties IDs from database
     *
     * @return array of ids
     */
    public static function all()
    {
        global $wpdb;
        $prefix = $wpdb->prefix;

        $query = "SELECT ID FROM {$prefix}posts WHERE post_type = '" . static::$post_type . "";

        return array_map(function ($p) {
            return (int) $p->ID;
        }, $wpdb->get_results($query));
    }


    /**
     * Get current post using wordpress magic function
     *
     * @return Model null on failure
     */
    public static function current()
    {
        $id = get_the_id();

        if (!$id) {
            global $post;
            $id = $post->ID ?? false;
        }

        if (!$id) {
            return null;
        }

        return new static($id);
    }
}
