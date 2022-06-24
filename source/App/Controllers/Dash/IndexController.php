<?php

namespace App\Controllers\Dash;

use App\Models\Auth;

class IndexController extends DashController
{
    /**
     * @param \Components\Router\Router $router
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
        $this->router->redirect("dash.dash");
        return;
    }

    /**
     * @return void
     */
    public function dash(): void
    {
        $this->view("dash/index")->seo("Resumo geral do sistema")->render();
    }

    /**
     * @return void
     */
    public function settings()
    {
        $this->view("dash/settings")->seo("Configurações")->render();
    }

    /**
     * @return void
     */
    public function profile()
    {
        $this->view("dash/profile", [
            "logged" => (new Auth())->logged()
        ])->seo("Meu perfil")->render();
    }

    /**
     * @return void
     */
    public function error(): void
    {
        $this->view("error", ["errorCode" => filter_input(INPUT_GET, "err", FILTER_VALIDATE_INT) ?? 404])
            ->render();
    }
}
