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
            "json" => (new Message())->success("Uma mensagem de sucesso json", "Mensagem em json")->float()->fixed()->json()
        ];

        $this->view("tests/message", [
            "firstName" => "My First Name",
            "lastName" => "My Last Name",
            "messages" => $messages
        ])->render();
    }

    public function uploadTest(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $upload = null;

            if (key_exists("image", $_FILES)) {
                $upload = $this->uploader->image($_FILES["image"], "images");
            } else if (key_exists("video", $_FILES)) {
                $upload = $this->uploader->media($_FILES["video"], "medias");
            } elseif (key_exists("file", $_FILES)) {
                $upload = $this->uploader->file($_FILES["file"], "files");
            } else {
                echo "nenhum upload";
            }

            if (!$upload) {
                (new Message())->danger($this->uploader->error()->message, "Falha no upload")->flash();
            } else {
                $path = $upload->store();
                (new Message())->success("Upload concluído: " . $this->route("index.index") . $path . " :)", "Tudo certo :D")->flash();
            }

            $this->router->redirect("index.uploadTest");
            return;
        }

        $this->view("tests/upload", [
            "firstName" => "My First Name",
            "lastName" => "My Last Name"
        ])->seo("Teste de upload")->render();
    }
}
