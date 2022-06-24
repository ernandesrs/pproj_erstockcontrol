<?php

namespace App\Controllers\Dash;

use App\Models\Auth;
use App\Models\User;

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
        $overviewBoxes = [
            "users" => (object) [
                "total" => (new User())->find()->count(),
                "text" => "Usuários",
                "icon" => icon_class("userGroup"),
                "link" => $this->route("dash.users")
            ],
            "products" => (object) [
                "total" => 0,
                "text" => "Produtos",
                "icon" => icon_class("box2"),
                "link" => $this->route("dash.products")
            ],
            "lorem1" => (object) [
                "total" => 0,
                "text" => "Lorem 1",
                "icon" => icon_class("bell"),
                "link" => ""
            ],
            "lorem2" => (object) [
                "total" => 0,
                "text" => "Lorem 2",
                "icon" => icon_class("sliders"),
                "link" => ""
            ],
        ];
        $this->view("dash/index", [
            "overviewBoxes" => $overviewBoxes
        ])->seo("Resumo geral do sistema")->render();
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
