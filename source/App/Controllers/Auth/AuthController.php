<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\Auth;

class AuthController extends Controller
{
    /**
     * @param [type] $router
     */
    public function __construct($router)
    {
        if ((new Auth())->isLogged()) {
            $router->redirect("dash.dash");
            return;
        }

        parent::__contruct($router);
    }
}
