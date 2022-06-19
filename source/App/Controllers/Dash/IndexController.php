<?php

namespace App\Controllers\Dash;

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
        echo "Dash logged";
    }
}
