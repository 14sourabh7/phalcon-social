<?php

use Phalcon\Mvc\Model;

class Posts extends Model
{
    public $post_id;
    public $user_id;
    public $name;
    public $post_body;
    public $file;

    public function getUserPost($user)
    {
        $posts = Posts::find([
            'conditions' =>
            "user_id = '$user'",
        ]);
        return json_encode($posts);
    }

    public function getOtherPosts($user)
    {
        $posts = Posts::find([
            'conditions' =>
            "user_id != '$user'",
        ]);
        return json_encode($posts);
    }

    public function getPost($id)
    {
        $post = Posts::find($id);
        return json_encode($post);
    }
}
