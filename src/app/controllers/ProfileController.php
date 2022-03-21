<?php

use Phalcon\Mvc\Controller;


class ProfileController extends Controller
{
    public function indexAction()
    {
    }
    public function operationAction()
    {
        $action = $this->request->getPost()['action'];
        switch ($action) {
            case 'getFriend':
                $id = $_POST['id'];
                $user  = Users::find([
                    'conditions' => "user_id = '$id'"
                ]);
                return json_encode($user);
                break;
            case 'getUsers':
                $users  = Users::find();
                return json_encode($users);
                break;
            case 'getUserId':
                $id = $_POST['user_id'];
                $user  = Users::find([
                    'conditions' => "user_id = '$id'"
                ]);
                return json_encode($user);
                break;
            case 'updateCircle':
                $id = $_POST['id'];
                $circle = Circles::findFirst("user_id = $id");
                $circle->circle = $_POST['circles'];
                $result = $circle->save();
                return json_encode($result);
                break;
        }
    }
}
