<?php

namespace Tools\FakerPosts\Generate;

use \Faker\Factory as FakerFactory;

use OP\Framework\Models\Factory\PostModelFactory;
use OP\Framework\Helpers\PostHelper;
use App\Models\User;

require_once dirname(__DIR__) . '/../vendor/autoload.php';

class Generate
{
    private static $_instance = null;

    private static $upload_dir;

    private static $publish = true;

    private $faker;
    private $faker_acf;
    private $user;


    /**
     * Class constructor
     *
     * @return void
     */
    private function __construct()
    {
        self::$upload_dir = wp_upload_dir()['path'];

        $this->faker = FakerFactory::create('fr_FR');
        $this->faker_acf = Acf::getInstance($this->faker);

        $this->setUser();

        $this->faker_acf->setUserAs($this->user);
    }


    /**
     * Returns instance, creates one if needed
     *
     * @param  void
     * @return Generate
     */
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Generate();
        }

        return self::$_instance;
    }


    /**
     * Retrieve/create the user that will detain the dummy data
     *
     * @param   void
     * @return  \App\Models\User
     */
    protected function setUser()
    {
        $user = User::getBy('login', 'FakerPostsDummyUser');

        if (is_bool($user) && $user === false) {
            $user = User::insert('FakerPostsDummyUser', 'FakerPostsDummyUser+admin@148hosting.fr');

            if ($user === false) {
                throw new \Exception(
                    "Could not create user. Perhaps username or email address is already in use ?"
                );
            }

            $user->removeRole('subscriber');
            $user->addRole('Administrator');
        }

        $this->user = $user;
    }


    /**
     * Delete Faker user and delete it's content
     */
    public function deleteUser()
    {
        return $this->user->delete();
    }


    /**
     * Generate a post
     *
     * @param $post_type
     */
    public function post(string $post_type = 'post')
    {
        $post   = PostModelFactory::model(null, $post_type);

        if ($post) {
            // Post properties
            $title = $this->faker->text(55);

            $post->setPostProperties([
                'post_title'        => $title,
                'post_content'      => $this->faker->text(400),
                'post_name'         => sanitize_title($title),
                'post_author'       => $this->user->id(),
            ]);

            // Post thumbnail
            $att_id = $post->setThumbailFromUrl(Image::getImageUrl());

            PostHelper::setPostPoperties($att_id, [
                'post_author' => $this->user->id(),
            ]);
            
            // Post taxonomies
            // TODO

            // Post custom fields
            $post->setMetas($this->faker_acf->getMetas());


            if (static::$publish) {
                $post->publish();
            }

            return $post;
        }
    }
}
