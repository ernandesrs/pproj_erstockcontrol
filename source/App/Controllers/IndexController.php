<?php

namespace App\Controllers;

use Components\Session\Session;

class IndexController extends Controller
{
    public function __construct($router)
    {
        parent::__contruct($router);
    }

    public function index(): void
    {
        $session = new Session();
        $session->add("user_id", 2819);

        if ($session->get("page_updates") === null) {
            $session->add("page_updates", 0);
        } else {
            $updates = $session->get("page_updates");
            $session->update("page_updates", $updates += 1);
        }
    
        // $session->remove("user_id");

        $this->view("pages/index", [
            "firstName" => "My First Name",
            "lastName" => "My Last Name"
        ])
            ->seo("Dashboard", "Lorem ipsum dolor sit nit natus unis doloren instinctus dolor lorem", $this->route("index.index"), null, false)
            ->render();
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
