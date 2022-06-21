<?php

namespace App\Controllers\Dash;

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
            "users" => (new User())->offset($page - 1)->limit(12)->find()->get(true)
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
        // message()->success("tudo certo e recarregado kkk")->flash();
        // echo json_encode([
        //     "reload" => true,
        // ]);
        // return;

        // message()->success("tudo certo e redirecionado kkk")->flash();
        // echo json_encode([
        //     "redirect" => $this->route("dash.users"),
        // ]);
        // return;

        // echo json_encode([
        //     "success" => false,
        //     "message" => message()->success("Cetin kkk")->render(),
        // ]);
        // return;

        // echo json_encode([
        //     "success" => false,
        //     "message" => message()->warning("Corrija os erros nos campos")->render(),
        //     "errors" => [
        //         "first_name" => "Informe este campo",
        //         "last_name" => "Informe este campo",
        //         "email" => "Informe este campo",
        //         "gender" => "Informe este campo",
        //     ]
        // ]);
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
