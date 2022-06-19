<?php

namespace App\Controllers\Dashboard;

use App\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct($router)
    {
        // autenticar: se logado direciado para dash, se não, direcionar para login

        parent::__contruct($router);
    }
}
