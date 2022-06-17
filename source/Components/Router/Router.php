<?php

namespace Components\Router;

class Router
{
    /** @var String */
    private $urlBase;

    public function __construct(string $urlBase)
    {
        $this->urlBase = $urlBase;
    }
}