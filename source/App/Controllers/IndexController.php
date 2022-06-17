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
        (new Base());
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
