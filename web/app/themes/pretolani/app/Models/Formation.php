<?php

namespace App\Models;

use App\Models\Abstracts\OverloadPostModel;

class Formation extends OverloadPostModel
{
    /**
     * Wordpress post_type associated to the current model
     */
    public static $post_type = 'formation';


    /**
     * Register abstract PostModel as Formation
     */
    public function __construct($post_id = null)
    {
        $this->register();
        $this->construct($post_id);
    }
}
