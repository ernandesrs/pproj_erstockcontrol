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
        /**
         * 
         * start filter
         * 
         */

        $search = filter_input(INPUT_GET, "search");
        $order = filter_input(INPUT_GET, "order");

        $rules = "";
        $ruleValues = "";
        if (!empty($search)) {
            $rules .= "MATCH(first_name, last_name, username, email) AGAINST(:search) AND ";
            $ruleValues .= "search={$search}&";
        }

        $orderBy = "created_at {$this->settings->listings->order_create_date}";
        if (!empty($order) && in_array($order, ["asc", "desc"])) {
            $orderBy = "created_at " . strtoupper($order);
        }

        $rules = !empty($rules) ? substr($rules, 0, strlen($rules) - 5) : null;
        $ruleValues = !empty($ruleValues) ? substr($ruleValues, 0, strlen($ruleValues) - 1) : null;

        /**
         * 
         * end filter
         * 
         */

        $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT) ?? 1;

        /** @var User */
        $user = (new User())->offset($page)->limit($this->settings->listings->limit_items)->orderBy("level DESC, username ASC, {$orderBy}")->find($rules, $ruleValues);

        $this->view("dash/users", [
            "pagination" => $user->paginate(),
            "users" => $user->get(true),
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
        $user = new User();

        if ($this->logged->level != User::LEVEL_OWNER) {
            message()->warning("Você não possui permissão para realizar este tipo de ação")->float()->flash();
            echo json_encode([
                "success" => false,
                "redirect" => $this->route("dash.users"),
            ]);
            return;
        }

        if (!$user->set($_POST)) {
            echo json_encode([
                "success" => false,
                "message" => message()->warning("Erro ao validar os dados informados")->float()->render(),
                "errors" => $user->errors()
            ]);
            return;
        }

        if (!$user->add()) {
            echo json_encode([
                "success" => false,
                "message" => message()->warning("Houve um erro interno ao tentar salvar os dados")->float()->render(),
                "errors" => $user->errors()
            ]);
            return;
        }

        message()->success("Um novo usuário foi registrado com sucesso")->float()->flash();
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
            message()->warning("O usuário que você tentou editar não existe ou já foi excluído")->float()->flash();
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
        $data = $_POST;

        /** @var User $user */
        $user = (new User())->find("id=:id", "id=" . (filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT) ?? 0))->get();

        if (!$user) {
            message()->warning("O usuário que você tentou atualizar não existe ou já foi excluído")->float()->flash();
            echo json_encode([
                "success" => false,
                "redirect" => $this->route("dash.users")
            ]);
            return;
        }

        // IMPEDE QUE USUÁRIOS NÃO PROPRIETÁRIO ALTEREM OUTROS USUÁRIOS
        if ($this->logged->id != $user->id && $this->logged->level != User::LEVEL_OWNER) {
            message()->warning("Você não possui permissão para realizar este tipo de ação")->float()->flash();
            echo json_encode([
                "success" => false,
                "redirect" => $this->route("dash.users"),
            ]);
            return;
        }

        // IMPEDE O USUÁRIO DE ALTERAR O PRÓPRIO NÍVEL
        if ($this->logged->id == $user->id)
            $data["level"] = $this->logged->level;

        // PHOTO UPLOAD
        $storage = null;
        $newPhotoPath = null;
        if (!empty($_FILES["photo"]["name"])) {
            $storage = storage_image($_FILES["photo"], "images/photo");
            $newPhotoPath = $storage->store();
            if (!$newPhotoPath) {
                echo json_encode([
                    "success" => false,
                    "message" => message()->warning($storage->error()->message ?? "Erro no upload da foto")->float()->render(),
                    "errors" => [
                        "photo" => "Extensões aceitas: " . $storage->error()->allowedExtensions ?? ""
                    ]
                ]);
                return;
            }

            if (!empty($user->photo))
                $storage->unlink($user->photo);

            $user->photo = $newPhotoPath;
        }

        if (!$user->set($data)) {
            if ($storage)
                $storage->unlink($newPhotoPath);
            echo json_encode([
                "success" => false,
                "message" => message()->warning("Erro ao validar os dados informados")->float()->render(),
                "errors" => $user->errors()
            ]);
            return;
        }

        if (!$user->update()) {
            if ($storage)
                $storage->unlink($newPhotoPath);
            echo json_encode([
                "success" => false,
                "message" => message()->warning("Houve um erro interno ao tentar salvar os dados")->float()->render(),
                "errors" => $user->errors()
            ]);
            return;
        }

        message()->success("O usuário foi atualizado com sucesso")->float()->flash();
        echo json_encode([
            "success" => true,
            "reload" => true,
        ]);
        return;
    }

    /**
     * @return void
     */
    public function delete(): void
    {
        /** @var User $user */
        $user = (new User())->find("id=:id", "id=" . (filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT) ?? 0))->get();

        if (!$user) {
            message()->warning("O usuário que você tentou excluir não existe ou já foi excluído")->float()->flash();
            echo json_encode([
                "success" => false,
                "redirect" => $this->route("dash.users")
            ]);
            return;
        }

        if ($this->logged->level != User::LEVEL_OWNER) {
            message()->warning("Você não possui permissão para realizar este tipo de ação")->float()->flash();
            echo json_encode([
                "success" => false,
                "redirect" => $this->route("dash.users"),
            ]);
            return;
        }

        // IMPEDE O PROPRIETÁRIO DE EXCLUIR O PRÓPRIO PERFIL
        if ($this->logged->id == $user->id) {
            echo json_encode([
                "success" => false,
                "message" => message()->warning("Você não pode excluir seu próprio perfil")->float()->render()
            ]);
            return;
        }

        // REMOVE A FOTO
        if ($user->photo)
            storage()->unlink($user->photo);

        $user->delete();

        message()->info("O usuário foi excluído com sucesso")->float()->flash();
        echo json_encode([
            "success" => true,
            "redirect" => $this->route("dash.users"),
        ]);
        return;
    }

    /**
     * @return void
     */
    public function filter(): void
    {
        $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT) ?? 1;
        $search = filter_input(INPUT_POST, "search");
        $order = filter_input(INPUT_POST, "order");

        $params = [];
        if (!empty($search))
            $params["search"] = $search;

        if (!empty($order) && in_array($order, ["asc", "desc"]))
            $params["order"] = $order;

        if (count($params) != 0 && $page)
            $params["page"] = $page;

        echo json_encode([
            "success" => true,
            "redirect" => $this->route("dash.users", $params)
        ]);
        return;
    }
}
