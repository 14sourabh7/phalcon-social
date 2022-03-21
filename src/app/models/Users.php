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
}
