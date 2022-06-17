<?php

use Components\Router\Router;

require_once __DIR__ . "/vendor/autoload.php";

$router = new Router(CONF_URL_BASE);

var_dump($router);