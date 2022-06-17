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

        // for ($i = 0; $i < 20; $i++) {
        //     $user = new User();
        //     $user->first_name = "Nome " . ($i + 1);
        //     $user->last_name = "Sobreome " . ($i + 1);
        //     $user->username = "Username " . ($i + 1);
        //     $user->email = "email" . ($i + 1) . "@mail.com";
        //     $user->password = password_hash("senha", PASSWORD_DEFAULT);
        //     $user->gender = ["m", "f"][rand(0, 1)];
        //     var_dump($user->add());
        // }
        $user = (new User())->limit(10)->offset(1)->orderBy("id ASC")->groupBy("gender")->find()->get(true);
        if ($user) {
            foreach ($user as $usr) {
                echo "ID: {$usr->id} - " . $usr->first_name . " - " . $usr->gender . "<br>";
            }
        }
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
