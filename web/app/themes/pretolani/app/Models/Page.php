<?php

namespace App\Models;

use App\Models\Abstracts\OverloadPostModel;

class Page extends OverloadPostModel
{
    /**
     * Wordpress post_type associated to the current model
     */
    public static $post_type = 'page';


    /**
     * Register abstract PostModel as Page
     */
    public function __construct($post_id = null)
    {
        $this->register();
        $this->construct($post_id);
    }
}
