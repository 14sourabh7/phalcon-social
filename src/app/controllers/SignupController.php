<?php

use Phalcon\Mvc\Controller;

class SignupController extends Controller
{

    public function IndexAction()
    {
        // return "Signup";
    }

    public function registerAction()
    {
        // return '<h1>registered</h1>';
        $user = new Users();

        $user->name = $this->request->getPost()['name'];
        $user->username = $this->request->getPost()['userName'];
        $user->password = $this->request->getPost()['password'];
        $user->email = $this->request->getPost()['email'];
        $user->mobile = $this->request->getPost()['mobile'];
        $user->city = $this->request->getPost()['city'];
        $user->country = $this->request->getPost()['country'];
        $user->pincode = $this->request->getPost()['pin'];

        $success = $user->save();
        $username = $this->request->getPost()['userName'];
        $data = Users::find(["username = '$username'"]);
        return json_encode($data);
    }
    public function addcircleAction()
    {
        $circle = new Circles();

        $circle->user_id = $this->request->getPost()['user_id'];
        $circle->circle =  '{"block": [], "friends": []}';

        $success = $circle->save();


        return json_encode($success);
    }
    public function checkemailAction()
    {
        $email = $this->request->getPost()['email'];
        $data = Users::find(["email = '$email'"]);
        return json_encode($data);
    }
    public function checkusernameAction()
    {
        $username = $this->request->getPost()['username'];
        $data = Users::find(["username = '$username'"]);
        return json_encode($data);
    }
}
