<?php

namespace App\Controllers;

use Components\Router\Router;
use Components\Template\Template;
use Components\Uploader\Uploader;

class Controller
{
    /** @var Router */
    protected $router;

    /** @var Template */
    private $view;

    /** @var Uploader */
    protected $uploader;

    /**
     * @param Router $router
     * @return void
     */
    public function __contruct(Router $router = null)
    {
        $this->router = $router;
        $this->view = new Template(CONF_BASE_DIR . CONF_VIEWS_DIR);
        $this->uploader = new Uploader(CONF_BASE_DIR . CONF_UPLOAD_BASE_DIR);

        $this->view->addData(["router" => $this->router]);
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
