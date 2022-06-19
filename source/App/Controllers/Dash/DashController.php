<?php

namespace App\Controllers\Dash;

use App\Controllers\Controller;
use App\Models\Auth;
use Components\Router\Router;

class DashController extends Controller
{
    /**
     * @param Router $router
     */
    public function __construct($router)
    {
        if (!(new Auth())->isLogged()) {
            $router->redirect("auth.login");
            return;
        }

        parent::__contruct($router);
    }
}
