<?php

namespace App\Controllers;

use Components\Router\Router;

class Controller
{
    /** @var Router */
    private $router;

    public function __contruct($router)
    {
        $this->router = $router;
    }

    protected function route(string $name, array $args = []): ?string
    {
        return $this->router->route($name, $args);
    }
}
