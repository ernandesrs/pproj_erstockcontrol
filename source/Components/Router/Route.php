<?php

namespace Components\Router;

use Exception;

abstract class Route
{
    protected const GET_METHOD = "GET";
    protected const POST_METHOD = "POST";
    protected const NOTFOUND = 404;
    protected const UNAUTHORIZED = 401;
    protected const FORBIDDEN = 403;
    protected const NOTIMPLEMENTED = 501;

    /** @var String */
    protected $urlBase;

    /** @var String */
    protected $namespace;

    /** @var Array */
    protected $routes;

    /** @var int */
    protected $errno;

    /**
     * @return bool
     */
    public function boot(): bool
    {
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        $url = $this->getUrl();
        if (!array_key_exists($requestMethod, $this->routes)) {
            $this->errno = self::NOTIMPLEMENTED;
            return false;
        }

        if (!array_key_exists($url, $this->routes[$requestMethod])) {
            $this->errno = self::NOTFOUND;
            return false;
        }

        $route = $this->routes[$requestMethod][$url];
        if (count(explode("@", $route["action"])) != 2) {
            throw new Exception("Ao definir a rota, o parâmetro 'action' precisa seguir o padrão 'class@method'");
            return false;
        }

        if (empty($route["namespace"])) {
            throw new Exception("Namespace não definido");
            return false;
        }

        $class = $route["namespace"] . "\\" . explode("@", $route["action"])[0];
        $method = explode("@", $route["action"])[1];

        if (!class_exists($class)) {
            $this->errno = self::NOTFOUND;
            return false;
        }

        if (!method_exists($class, $method)) {
            $this->errno = self::NOTIMPLEMENTED;
            return false;
        }

        (new $class($this))->$method();

        return true;
    }

    /**
     * @param string $name
     * @param array $args
     * @return null|string
     */
    public function route(string $name, array $args = []): ?string
    {
        if (count($this->routes) == 0)
            return null;

        foreach ($this->routes as $route) {
            if (count($route) == 0)
                return null;

            foreach ($route as $r) {
                if ($r["name"] === $name) {
                    $url = $r["url"] === "/" ? $this->urlBase : $this->urlBase . $r["url"];

                    return count($args) > 0 ? $url .= "?" . http_build_query($args) : $url;
                }
            }
        }

        return null;
    }

    /**
     * @param string $routeName
     * @param array $values
     * @return void
     */
    public function redirect(string $routeName, array $values = []): void
    {
        $url = $this->route($routeName, $values);
        if (!$url)
            $url = $this->urlBase . "/error";

        header("Location: {$url}");
        exit;
    }

    /**
     * @var null|int
     */
    public function error(): ?int
    {
        return $this->errno;
    }

    /**
     * @return string
     */
    private function getUrl(): string
    {
        $url = str_replace(
            str_replace(
                ["http://", "https://"],
                "",
                $this->urlBase
            ),
            "",
            $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]
        );

        if ($url == "/")
            return $url;

        $url = strpos($url, "?") !== false ? substr($url, 0, strpos($url, "?")) : $url;

        return $url;
    }
}
