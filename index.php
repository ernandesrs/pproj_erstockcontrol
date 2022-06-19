<?php

use Components\Router\Router;

require_once __DIR__ . "/vendor/autoload.php";

session_start();

$router = new Router(CONF_URL_BASE);

/**
 * dashboard
 */

$router->namespace("App\\Controllers\\Dashboard");
$router->get("/", "IndexController@index", "dash.index");
$router->get("/dash", "IndexController@dash", "dash.dash");

/**
 * auth
 */
$router->namespace("App\\Controllers\\Auth");
$router->get("/auth/login", "LoginController@login", "auth.login");
$router->post("/auth/authenticate", "LoginController@authenticate", "auth.authenticate");

/**
 * testes
 */

$router->namespace("App\\Controllers\\Tests");
$router->get("/testes", "IndexController@index", "index.index");
$router->get("/testes/mensagens", "IndexController@messageTest", "index.messageTest");
$router->get("/testes/uploads", "IndexController@uploadTest", "index.uploadTest");
$router->post("/testes/uploads", "IndexController@uploadTest", "index.uploadTest.post");

if (!$router->boot()) {
    echo "Erro " . $router->error();
}
