<?php

use Phalcon\Mvc\Controller;

class PostController extends Controller
{
    public function indexAction()
    {
        // return '<h1>Hello!!!</h1>';
    }
    public function operationAction()
    {
        $action = $this->request->getPost()['action'];
        switch ($action) {
            case 'getPost':
                $post = Posts::find($_POST['id']);
                return json_encode($post);
                break;
            case 'getStats':
                $stats = Stats::find($_POST['id']);
                return json_encode($stats);
                break;
            case 'updateStats':
                $id = $_POST['id'];
                $stats = Stats::findFirst("post_id = $id");
                $stats->stats = $_POST['stats'];
                $result = $stats->save();
                return json_encode($result);
                break;
            case 'sharePost':
                $post = new Posts();
                $post->user_id = $_POST['id'];
                $post->name = $_POST['name'];
                $post->post_body = $_POST['postText'];
                $post->file = $_POST['file'];
                $post->save();
                $last_id = Posts::find();
                $last_id = $last_id->getLast();
                $stats = new Stats();
                $stats->post_id = $last_id->post_id;
                $stats->stats = '{"likes": [], "comments": []}';
                $result = $stats->save();
                return json_encode($result);
                break;
        }
    }
}
