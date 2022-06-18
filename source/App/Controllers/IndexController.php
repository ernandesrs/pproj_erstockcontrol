<?php

namespace App\Controllers;

use Components\Message\Message;
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
        // $session->destroy();
        // $session->remove("user_id");

        $this->view("pages/index", [
            "firstName" => "My First Name",
            "lastName" => "My Last Name"
        ])
            ->seo("Dashboard", "Lorem ipsum dolor sit nit natus unis doloren instinctus dolor lorem", $this->route("index.index"), null, false)
            ->render();
    }

    public function messageTest(): void
    {
        (new Message())->danger("Uma mensagem de perigo", "Mensagem na sessão")->float()->fixed()->flash();
        $messages = [
            "float" => (new Message())->success("Uma mensagem de sucesso fluatuante temporária por definição por 7.5s", "Flutuante temporária por 7.5s")->float()->render(),
            "wtimer" => (new Message())->success("Uma mensagem de sucesso temporária por 10s", "Temporária por 10s")->time(10)->render(),
            "wotimer" => (new Message())->success("Uma mensagem de sucesso fixa permanente", "Permanente fixa")->render(),
            "json"=>(new Message())->success("Uma mensagem de sucesso json", "Mensagem em json")->float()->fixed()->json()
        ];

        $this->view("tests/message", [
            "firstName" => "My First Name",
            "lastName" => "My Last Name",
            "messages" => $messages
        ])->render();
    }
}
