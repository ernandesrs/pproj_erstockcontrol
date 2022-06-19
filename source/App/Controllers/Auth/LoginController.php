<?php

namespace App\Controllers\Auth;

class LoginController extends AuthController
{
    /**
     * @param [type] $router
     */
    public function __construct($router)
    {
        parent::__construct($router);
    }

    /**
     * @return void
     */
    public function login(): void
    {
        $this->view("auth/login")->seo("Login")->render();
        return;
    }

    /**
     * @return void
     */
    public function authenticate(): void
    {
        return;
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        echo "Logout";
        return;
    }
}
