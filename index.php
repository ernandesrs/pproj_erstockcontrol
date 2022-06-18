<?php

use Components\Router\Router;

require_once __DIR__ . "/vendor/autoload.php";

session_start();

$router = new Router(CONF_URL_BASE);

$router->namespace("App\\Controllers");
$router->get("/", "IndexController@index", "index.index");
$router->get("/testes/mensagens", "IndexController@messageTest", "index.messageTest");

if (!$router->boot()) {
    echo "Erro " . $router->error();
}
