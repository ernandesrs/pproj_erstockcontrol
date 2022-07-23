<?php

namespace App\Controllers\Front;

use App\Controllers\Controller;
use App\Models\User;

class FrontController extends Controller
{
    public function __construct($router)
    {
        parent::__contruct($router);
    }

    /**
     * Executado apenas uma vez para criar os dados iniciais de acesso
     * Executado apenas quando a váriavel ambiente APP_LOCAL for true
     * @return void
     */
    public function starter(): void
    {
        if (!CONF_APP_LOCAL) {
            $this->router->redirect("front.front");
            return;
        }

        $user = new User();

        if ($user->find("level=:l", "l=" . User::LEVEL_MASTER)->count()) {
            $this->router->redirect("front.front");
            return;
        }

        $user->first_name = "User";
        $user->last_name = "First";
        $user->username = "Firstuser";
        $user->email = "user@email.com";
        $user->level = User::LEVEL_MASTER;
        $user->gender = User::GENDER_MALE;
        $user->password = password_hash("password", PASSWORD_DEFAULT);
        $user->save();

        return;
    }
}
