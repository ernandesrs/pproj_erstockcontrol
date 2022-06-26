<?php

use Components\Router\Router;

require_once __DIR__ . "/vendor/autoload.php";

$router = new Router(CONF_URL_BASE);

/**
 * dashboard
 */

$router->namespace("App\\Controllers\\Dash");
$router->get("/", "IndexController@index", "dash.index");
$router->get("/dash", "IndexController@dash", "dash.dash");
$router->post("/dash", "IndexController@dash", "dash.dash");

$router->get("/dash/produtos", "ProductController@index", "dash.products");
$router->get("/dash/produto/novo", "ProductController@create", "dash.products.create");
$router->post("/dash/produto/cadastrar", "ProductController@store", "dash.products.store");
$router->get("/dash/produto/editar", "ProductController@edit", "dash.products.edit");
$router->post("/dash/produto/atualizar", "ProductController@update", "dash.products.update");
$router->get("/dash/produto/excluir", "ProductController@delete", "dash.products.delete");
$router->post("/dash/produtos/filtrar", "ProductController@filter", "dash.products.filter");

$router->get("/dash/usuarios", "UserController@index", "dash.users");
$router->get("/dash/usuario/novo", "UserController@create", "dash.users.create");
$router->post("/dash/usuario/cadastrar", "UserController@store", "dash.users.store");
$router->get("/dash/usuario/editar", "UserController@edit", "dash.users.edit");
$router->post("/dash/usuario/atualizar", "UserController@update", "dash.users.update");
$router->get("/dash/usuario/excluir", "UserController@delete", "dash.users.delete");
$router->post("/dash/usuarios/filtrar", "UserController@filter", "dash.users.filter");

$router->get("/dash/configuracao", "IndexController@settings", "dash.settings");
$router->post("/dash/configuracao", "IndexController@settings", "dash.settings");
$router->get("/dash/perfil", "IndexController@profile", "dash.profile");
$router->post("/dash/online-report", "IndexController@onlineReport", "dash.onlineReport");

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
// $router->post("/testes/uploads", "IndexController@uploadTest", "index.uploadTest.post");
$router->post("/testes/uploads", "IndexController@uploadTestStorage", "index.uploadTestStorage.post");
$router->get("/testes/imagens", "IndexController@images", "index.images");

if (!$router->boot()) {
    $router->redirect("dash.error", ["err" => $router->error()]);
}
