<?php

namespace Components\Router;

trait RouteTrait
{
    /**
     * @return string
     */
    public function currentRouteName(): string
    {
        return $this->currentRoute["name"];
    }

    /**
     * @return string
     */
    public function currentRouteAction(): string
    {
        return $this->currentRoute["action"];
    }

    /**
     * @return string
     */
    public function currentRoutePath(): string
    {
        return $this->currentRoute["url"];
    }
}
