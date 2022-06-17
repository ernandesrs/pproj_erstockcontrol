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
        $user = new User();
        $user->find();
        var_dump($user->get(true));
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
