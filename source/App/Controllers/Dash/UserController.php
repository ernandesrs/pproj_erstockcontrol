<?php

namespace App\Controllers\Dash;

use App\Helpers\Storage;
use App\Models\Auth;
use App\Models\User;
use App\Validators\Admin\UserCreateValidator;
use App\Validators\Admin\UserUpdateValidator;

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
        $this->csrfVerify($_POST);

        $create = (new UserCreateValidator())->boot();

        if ($create->fail()) {
            echo json_encode([
                "success" => false,
                "message" => message()->warning("Erro ao validar os dados informados")->float()->render(),
                "errors" => $create->errors()
            ]);
            return;
        }

        $validated = (object) $create->validated();

        $user = new User();
        $user->first_name = $validated->first_name;
        $user->last_name = $validated->last_name;
        $user->username = $validated->username;
        $user->email = $validated->email;
        $user->gender = $validated->gender;
        $user->email = $validated->email;
        $user->level = $validated->level;
        $user->password = password_hash($validated->password, PASSWORD_DEFAULT);

        if (!$user->save()) {
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
        $this->csrfVerify($_POST);

        /** @var User $user */
        $user = (new User())->find(
            "id=:id",
            "id=" . (filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT) ?? 0)
        )->get();

        $update = (new UserUpdateValidator($user))->boot();

        if ($update->fail()) {
            echo json_encode([
                "success" => false,
                "message" => message()->warning("Erro ao validar os dados informados")->float()->render(),
                "errors" => $update->errors()
            ]);
            return;
        }

        $validated = (object) $update->validated();

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

        $user->first_name = $validated->first_name;
        $user->last_name = $validated->last_name;
        $user->username = $validated->username;
        $user->email = $validated->email;
        $user->gender = $validated->gender;

        if ($validated->password ?? null)
            $user->password = password_hash($validated->password, PASSWORD_DEFAULT);

        if (!$user->save()) {
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
    public function promote(): void
    {
        $userId = filter_var($_GET["user_id"] ?? 0, FILTER_VALIDATE_INT) ?? 0;

        $user = (new User())->find("id=:id", "id={$userId}")->get();
        if (!$user) {
            message()->danger("O usuário não existe ou foi excluído!")->float()->flash();
            echo json_encode([
                "success" => false,
                "redirect" => route("dash.users")
            ]);
            return;
        }

        $logged = (new Auth())->logged();

        // IMPEDE AUTO PROMOÇÃO E PROMOÇÃO DE USUÁRIO DE NÍVEL IGUAL O SUPERIOR
        if ($logged->id == $user->id || $logged->level <= $user->level) {
            echo json_encode([
                "success" => false,
                "message" => message()->danger("Você não possui permissão para esse tipo de ação!")->float()->render()
            ]);
            return;
        }

        if ($user->level == User::LEVEL_ONE)
            $user->level = User::LEVEL_SEVEN;
        elseif ($user->level == User::LEVEL_SEVEN)
            $user->level = User::LEVEL_ADMIN;

        $user->save();

        message()->success("O usuário foi promovido com sucesso!")->float()->flash();
        echo json_encode([
            "success" => true,
            "reload" => true
        ]);
        return;
    }

    /**
     * @return void
     */
    public function demote(): void
    {
        $userId = filter_var($_GET["user_id"] ?? 0, FILTER_VALIDATE_INT) ?? 0;

        $user = (new User())->find("id=:id", "id={$userId}")->get();
        if (!$user) {
            message()->danger("O usuário não existe ou foi excluído!")->float()->flash();
            echo json_encode([
                "success" => false,
                "redirect" => route("dash.users")
            ]);
            return;
        }

        $logged = (new Auth())->logged();

        // IMPEDE AUTO REBAIXAMENTO E REBAIXAMENTO DE USUÁRIO DE NÍVEL IGUAL O SUPERIOR
        if ($logged->id == $user->id || $logged->level <= $user->level) {
            echo json_encode([
                "success" => false,
                "message" => message()->danger("Você não possui permissão para esse tipo de ação!")->float()->render()
            ]);
            return;
        }

        if ($user->level == User::LEVEL_SEVEN)
            $user->level = User::LEVEL_ONE;
        elseif ($user->level == User::LEVEL_ADMIN)
            $user->level = User::LEVEL_SEVEN;

        $user->save();

        message()->success("O usuário foi rebaixado com sucesso!")->float()->flash();
        echo json_encode([
            "success" => true,
            "reload" => true
        ]);
        return;
    }

    /**
     * @return void
     */
    public function photoRemove(): void
    {
        $userId = filter_var($_GET["user_id"] ?? 0, FILTER_VALIDATE_INT) ?? 0;

        $user = (new User())->find("id=:id", "id={$userId}")->get();
        if (!$user) {
            message()->danger("O usuário não existe ou foi excluído!")->float()->flash();
            echo json_encode([
                "success" => false,
                "redirect" => route("dash.users")
            ]);
            return;
        }

        $logged = (new Auth())->logged();

        // IMPEDE ALTERAÇÃO EM USUÁRIO DE NÍVEL IGUAL OU SUPERIOR EXCETO A SI PRÓPRIO
        if ($logged->id != $user->id && $logged->level <= $user->level) {
            echo json_encode([
                "success" => false,
                "message" => message()->danger("Você não possui permissão para esse tipo de ação!")->float()->render()
            ]);
            return;
        }

        (new Storage())->unlink($user->photo);

        $user->photo = null;
        $user->save();

        message()->success("A foto do usuário foi removida com sucesso!")->float()->flash();
        echo json_encode([
            "success" => true,
            "reload" => true
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

        if ($this->logged->level <= $user->level) {
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
                "message" => message()->warning("Você não pode excluir seu próprio perfil")->time()->render()
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
