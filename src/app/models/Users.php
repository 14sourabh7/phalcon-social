<?php

use Phalcon\Mvc\Model;

class Users extends Model
{
    public $user_id;
    public $name;
    public $username;
    public $password;
    public $email;
    public $mobile;
    public $city;
    public $country;
    public $pincode;

    public function getUser($val)
    {
        $data = Users::find([
            'conditions' =>
            " email = '$val' OR username = '$val' OR name = '$val'",
        ]);
        return json_encode($data);
    }
    public function checkUser($email, $password)
    {
        $data = Users::find([
            'conditions'
            => "email='$email' AND password='$password' OR username='$email' AND password='$password'",

        ]);
        return json_encode($data);
    }
}
