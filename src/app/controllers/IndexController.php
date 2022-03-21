<?php

use Phalcon\Mvc\Controller;


class IndexController extends Controller
{
    public function indexAction()
    {
        $this->view->users = Users::find();
    }
    public function operationAction()
    {
        $action = $this->request->getPost()['action'];

        switch ($action) {
            case 'getUser':
                $val = $this->request->getPost()['value'];
                $data = Users::find([
                    'conditions' =>
                    " email = '$val' OR username = '$val' OR name = '$val'",
                ]);
                return json_encode($data);
                break;
            case 'getUserPost':
                $user = $this->request->getPost()['user_id'];
                $posts = Posts::find([
                    'conditions' =>
                    "user_id = '$user'",
                ]);
                return json_encode($posts);
                break;
            case 'getOtherPosts':
                $user = $this->request->getPost()['user_id'];
                $posts = Posts::find([
                    'conditions' =>
                    "user_id != '$user'",
                ]);
                return json_encode($posts);
                break;
            case 'getCircle':
                $user = $this->request->getPost()['user_id'];
                $posts = Circles::find([
                    'conditions' =>
                    "user_id = '$user'",
                ]);
                return json_encode($posts);
                break;
        }
    }

    public function postAction()
    {
        $target_file = "../public/img/" . basename($_FILES["fileToUpload"]["name"]);

        // moving file to upload folder
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            //     // varaiable to hold file name
            $name = basename($_FILES["fileToUpload"]["name"]);
            $post = new Posts();
            $post->user_id = $_GET['id'];
            $post->name = $_GET['name'];
            $post->post_body = $_POST['postText'];
            $post->file = '../public/img/' . $name;
            $post->save();
            $last_id = Posts::find();
            $last_id = $last_id->getLast();
            $stats = new Stats();
            $stats->post_id = $last_id->post_id;

            $stats->stats = '{"likes": [], "comments": []}';
            $stats->save();
            header('Location:/');
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
