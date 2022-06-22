<?php

namespace App\Controllers\Dash;

use App\Models\Auth;
use App\Models\User;

class UserController extends DashController
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
    public function index(): void
    {
        $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT) ?? 1;
        $this->view("dash/users", [
            "users" => (new User())->offset($page - 1)->limit(12)->orderBy("level DESC, username ASC, created_at DESC")->find()->get(true)
        ])->seo("Listando usuários")->render();
    }

    /**
     * @return void
     */
    public function create(): void
    {
        $this->view("dash/users-create")->seo("Novo usuário")->render();
    }

    /**
     * @return void
     */
    public function store(): void
    {
        $logged = (new Auth())->logged();
        $user = new User();

        if ($logged->level != 5) {
            message()->warning("Você não possui permissão para registrar usuários")->flash();
            echo json_encode([
                "success" => false,
                "redirect" => $this->route("dash.users"),
            ]);
            return;
        }

        if (!$user->set($_POST)) {
            echo json_encode([
                "success" => false,
                "message" => message()->warning("Erro ao validar os dados informados")->render(),
                "errors" => $user->errors()
            ]);
            return;
        }

        if (!$user->add()) {
            echo json_encode([
                "success" => false,
                "message" => message()->warning("Houve um erro interno ao tentar salvar os dados :9")->render(),
                "errors" => $user->errors()
            ]);
            return;
        }

        message()->success("Um novo usuário foi registrado com sucesso!")->flash();
        echo json_encode([
            "success" => true,
            "redirect" => $this->route("dash.users"),
        ]);
        return;
    }

    /**
     * @return void
     */
    public function edit(): void
    {
        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT) ?? 0;

        $user = (new User())->find("id=:id", "id={$id}")->get();
        if (!$user) {
            message()->warning("O usuário que você tentou editar não existe ou já foi excluído.")->flash();
            $this->router->redirect("dash.users");
        }

        $this->view("dash/users-edit", [
            "user" => $user
        ])->seo("Editando usuário")->render();
    }

    /**
     * @return void
     */
    public function update(): void
    {
    }

    /**
     * @return void
     */
    public function delete(): void
    {
    }
}
