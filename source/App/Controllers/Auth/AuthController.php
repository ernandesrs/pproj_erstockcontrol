<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;

class AuthController extends Controller
{
    public function __construct($router)
    {
        // autenticar: se logado direciado para dash, se não, permitir acesso

        parent::__contruct($router);
    }
}
