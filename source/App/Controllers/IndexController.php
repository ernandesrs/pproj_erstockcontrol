<?php

namespace App\Controllers;

use App\Models\User;

class IndexController extends Controller
{
    public function __construct($router)
    {
        parent::__contruct($router);
    }

    public function index(): void
    {
        echo "Dashboard - Home<br>";
        // $user = new User();
        // $user->first_name = "032Kkk";
        // $user->last_name = "Kkk";
        // $user->username = "Kkk2";
        // $user->email = "Kkk2@kk";
        // $user->password = "Kkk";
        // $user->gender = "f";
        // var_dump($user->add(), $user);

        $user = (new User())->find("username=:username", "username=Usuario Doido")->get();
        // $user->update();
        $user->username = "Usuario Doido";
        $user->email = "kkk@mail.com";
        var_dump($user->update());
        die;
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
