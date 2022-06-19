<?php

namespace App\Controllers\Dashboard;

class IndexController extends DashboardController
{
    /**
     * @param [type] $router
     */
    public function __construct($router)
    {
        parent::__contruct($router);
    }

    /**
     * @return void
     */
    public function index(): void
    {
        $this->router->redirect("dash.dash");
    }

    /**
     * @return void
     */
    public function dash(): void
    {
        $this->view("dashboard/index")->seo("Resumo geral")->render();
        return;
    }
}
