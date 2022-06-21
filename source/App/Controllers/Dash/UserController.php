<?php

namespace App\Controllers\Dash;

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
        $this->view("dash/users")->seo("Listando usuários")->render();
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
    }

    /**
     * @return void
     */
    public function edit(): void
    {
        $this->view("dash/users-edit")->seo("Editando usuário")->render();
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
