<?php

namespace App\Controllers;

use Components\Router\Router;
use Components\Template\Template;

class Controller
{
    /** @var Router */
    private $router;

    /** @var Template */
    protected $view;

    /**
     * @param Router $router
     * @return void
     */
    public function __contruct(Router $router)
    {
        $this->router = $router;
        $this->view = new Template(CONF_BASE_DIR . CONF_VIEWS_DIR);
    }

    /**
     * @param string $name
     * @param array $args
     * @return string|null
     */
    protected function route(string $name, array $args = []): ?string
    {
        return $this->router->route($name, $args);
    }

    /**
     * @param string $name
     * @param array $data
     * @return Template
     */
    protected function view(string $name, array $data = []): Template
    {
        return $this->view->addView($name)->addData($data);
    }
}
