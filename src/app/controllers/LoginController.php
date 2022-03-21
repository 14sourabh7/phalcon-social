<?php

use Phalcon\Mvc\Controller;

class LoginController extends Controller
{
    public function indexAction()
    {
        // return '<h1>Hello!!!</h1>';
    }
    public function checkUserAction()
    {
        $email = $this->request->getPost()['email'];
        $password = $this->request->getPost()['password'];
        $data = Users::find([
            'conditions'
            => "email='$email' AND password='$password' OR username='$email' AND password='$password'",

        ]);
        return json_encode($data);
    }
}
