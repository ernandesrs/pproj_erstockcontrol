<?php

use App\Controllers\Controller;

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__contruct();
    }

    public function index(): void
    {
        echo "Dashboard - Home";
    }
}
