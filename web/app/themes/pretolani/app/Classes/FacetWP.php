<?php

namespace App\Classes;

class FacetWP
{
    /**
     * Class constructor
     */
    public static function init()
    {
        add_filter('facetwp_template_html', [__CLASS__, 'templateFacetFront'], 10, 2);
    }


    /**
     * Callback function, templating the results into cards
     *
     * @param string    $output
     * @param \stdClass $class
     *
     * @return string
     */
    public static function templateFacetFront($output, $class)
    {
        $GLOBALS['wp_query'] = $class->query;
        global $post;

        ob_start();

        if (have_posts()) {
            while (have_posts()) {
                the_post();

                try {
                    $model = \App\Models\Factory\PostModelFactory::model($post->ID, $post->post_type);

                    if (!$model) {
                        throw new \Exception("This post type has no corresponding Model..");
                    }

                    // echo \App\template('components.my-component', []);
                } catch (\Exception $e) {
                    // TODO: template was not found, use a default one?
                }
            }
        }

        return ob_get_clean();
    }
}
