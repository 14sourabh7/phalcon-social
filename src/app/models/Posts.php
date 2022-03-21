<?php

use Phalcon\Mvc\Model;

class Posts extends Model
{
    public $post_id;
    public $user_id;
    public $name;
    public $post_body;
    public $file;
}
