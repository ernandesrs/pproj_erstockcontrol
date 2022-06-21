<?php

use Components\Router\Router;

require_once __DIR__ . "/vendor/autoload.php";

session_start();

$router = new Router(CONF_URL_BASE);

/**
 * dashboard
 */

$router->namespace("App\\Controllers\\Dash");
$router->get("/", "IndexController@index", "dash.index");
$router->get("/dash", "IndexController@dash", "dash.dash");

$router->get("/dash/produtos", "IndexController@dash", "dash.products");
$router->get("/dash/produto/novo", "IndexController@dash", "dash.products.new");
$router->get("/dash/produto/editar", "IndexController@dash", "dash.products.edit");

$router->get("/dash/configuracao", "IndexController@dash", "dash.settings");
$router->get("/dash/perfil", "IndexController@dash", "dash.profile");

$router->get("/error", "IndexController@error", "dash.error");

/**
 * auth
 */
$router->namespace("App\\Controllers\\Auth");
$router->get("/auth/login", "LoginController@login", "auth.login");
$router->post("/auth/authenticate", "LoginController@authenticate", "auth.authenticate");
$router->get("/auth/logout", "LoginController@logout", "auth.logout");

/**
 * testes
 */

$router->namespace("App\\Controllers\\Tests");
$router->get("/testes", "IndexController@index", "index.index");
$router->get("/testes/mensagens", "IndexController@messageTest", "index.messageTest");
$router->get("/testes/uploads", "IndexController@uploadTest", "index.uploadTest");
$router->post("/testes/uploads", "IndexController@uploadTest", "index.uploadTest.post");

if (!$router->boot()) {
    $router->redirect("dash.error", ["err" => $router->error()]);
}
