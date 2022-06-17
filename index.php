<?php

use Components\Router\Router;

require_once __DIR__ . "/vendor/autoload.php";

$router = new Router(CONF_URL_BASE);

$router->namespace("App\\Controllers");
$router->get("/", "IndexController@index", "index.index");
$router->post("/a", "IndexController@a", "index.a");
$router->get("/index1", "IndexController@index1", "index.index1");
$router->get("/index2", "IndexController@index2", "index.index2");
$router->get("/index3", "IndexController@index3", "index.index3");
$router->get("/error", "IndexController@error", "index.error");

if(!$router->boot()) {
    echo "Erro " . $router->error();
}