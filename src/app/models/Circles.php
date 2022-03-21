<?php

use Phalcon\Mvc\Model;

class Circles extends Model
{
    public $user_id;
    public $circle;

    public function getCircle($user)
    {
        $posts = Circles::find([
            'conditions' =>
            "user_id = '$user'",
        ]);
        return json_encode($posts);
    }
}
