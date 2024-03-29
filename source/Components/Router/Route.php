<?php

namespace Components\Router;

use Exception;

abstract class Route
{
    use RouteTrait;

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

    /** @var Array */
    protected $currentRoute;

    /** @var int */
    protected $errno;

    /**
     * @return bool
     */
    public function boot(): bool
    {
        if (!$this->prepare())
            return false;

        $class = $this->currentRoute["namespace"] . "\\" . explode("@", $this->currentRoute["action"])[0];
        $method = explode("@", $this->currentRoute["action"])[1];

        if (!class_exists($class)) {
            $this->errno = self::NOTIMPLEMENTED;
            return false;
        }

        if (!method_exists($class, $method)) {
            $this->errno = self::NOTIMPLEMENTED;
            return false;
        }

        /**
         * 
         * inserindo dados de parâmetros da rota na variável global $_GET
         * 
         */
        if ($params = $this->currentRoute["params"])
            $_GET = ($_GET ?? []) + $params;

        (new $class($this))->$method();

        return true;
    }

    /**
     * @return boolean
     */
    private function prepare(): bool
    {
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (!array_key_exists($requestMethod, $this->routes)) {
            $this->errno = self::NOTIMPLEMENTED;
            return false;
        }

        $url = $this->getUrl();

        /**
         * 
         * buscando por rotas
         * 
         */
        $data = [];
        $urlArrayString = "";
        $urlArray = explode("/", $url);
        for ($i = count($urlArray) - 1; $i >= 0; $i--) {
            $urlArrayString = implode("/", $urlArray);

            if (!empty($urlArrayString) && array_key_exists($urlArrayString, $this->routes[$requestMethod])) {
                $this->currentRoute = $this->routes[$requestMethod][$urlArrayString];
                break;
            } else {
                $data[] = $urlArray[$i];
                $urlArray[$i] = "{var}";
            }
        }

        if (!$this->currentRoute) {
            $this->errno = self::NOTFOUND;
            return false;
        }

        if (empty($this->currentRoute["namespace"])) {
            throw new Exception("Namespace não definido");
            return false;
        }

        $param = 0;
        foreach ($this->currentRoute["params"] as $key => $value) {
            $this->currentRoute["params"][$key] = $data[$param];
            $param++;
        }

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

        /**
         * 
         * obtém possíveis rotas para o $name informado
         * 
         */
        $matcheds = [];
        foreach ($this->routes as $route) {
            if (count($route) == 0)
                return null;

            foreach ($route as $r) {
                if ($r["name"] === $name)
                    $matcheds[] = $r;
            }
        }

        arsort($matcheds);

        /**
         * 
         * procura pela rota correta levando em consideração
         * os parâmetros para cada rota e os valores de parâmetros passados em $args
         * 
         */
        foreach ($matcheds as $matched) {
            $has = 0;
            foreach (array_keys($matched["params"]) as $key) {
                if (key_exists($key, $args))
                    $has++;
            }

            if ($has === count($matched["params"])) {

                $url = explode("/", $matched["url"]);
                $count = count($url) - 1;

                foreach (array_keys($matched["params"]) as $key) {
                    $url[$count] = $args[$key];
                    unset($args[$key]);
                    $count--;
                }

                $url = implode("/", $url);

                if (count($args))
                    $url .= "?" . http_build_query($args);

                return $this->urlBase . $url;
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

        /**
         * 
         * remoção de parâmetros não amigáveis
         * 
         */
        $url = strpos($url, "?") !== false ? substr($url, 0, strpos($url, "?")) : $url;

        /**
         * 
         * remoção da última '/' se houver
         * 
         */
        return $url[strlen($url) - 1] == "/" ? substr($url, 0, strlen($url) - 1) : $url;
    }
}
