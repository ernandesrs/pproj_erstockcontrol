<?php

namespace App\Controllers\Auth;

class LoginController extends AuthController
{
    public function __construct($router)
    {
        parent::__contruct($router);
    }

    public function login()
    {
        $this->view("auth/login")->render();
        return;
    }

    public function authenticate()
    {
        $data = $_POST;
    }
}
