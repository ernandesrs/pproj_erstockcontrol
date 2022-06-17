<?php

namespace App\Controllers;

use Components\Base\Base;

class IndexController extends Controller
{
    public function __construct($router)
    {
        parent::__contruct($router);
    }

    public function index(): void
    {
        echo "Dashboard - Home<br>";
        $user = new Base("users", ["first_name", "last_name", "username", "email", "password", "gender"]);
        $user->first_name = "Ernandes";
        $user->last_name = "Souza";
        $user->username = "ernandes";
        $user->email = "ernandes@mail.com";
        $user->password = password_hash("ernandes", PASSWORD_DEFAULT);
        $user->gender = "m";
        var_dump($user, $user->data(), $user->add());
    }

    public function index2(): void
    {
        echo "Dashboard - Home 2";
    }

    public function index3(): void
    {
        echo "Dashboard - Home 3";
    }

    public function error(): void
    {
        echo "Erro!";
    }
}
