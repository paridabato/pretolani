<?php

namespace App\Models\Factory;

use App\Interfaces\ICpts;

class PostModelFactory implements ICpts
{
    /**
     * Factory model, get the post type and initiate a corresponding Model if applicable
     *
     * @param int    $post_id   ID of the concerned post
     * @param string $post_type WP Post type associated to the model to init
     *
     * @return Model
     */
    public static function model(int $post_id, string $post_type)
    {
        $model = static::MODELS[$post_type] ?? '';

        if ($model) {
            return new $model($post_id);
        }
    }
}
