<?php

$env = parse_ini_file(__DIR__ . "/../.env");

define("CONF_APP_NAME", $env["APP_NAME"] ?? null);
define("CONF_URL_BASE", $env["APP_URL_BASE"] ?? null);

define("CONF_DBASE_NAME", $env["DBASE_NAME"]);
define("CONF_DBASE_HOST", $env["DBASE_HOST"]);
define("CONF_DBASE_PORT", $env["DBASE_PORT"]);
define("CONF_DBASE_USER", $env["DBASE_USER"]);
define("CONF_DBASE_PASS", $env["DBASE_PASS"]);
define("CONF_DBASE_OPTIONS", [
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_CASE => PDO::CASE_NATURAL
]);

define("CONF_BASE_DIR", __DIR__ . "/..");
define("CONF_VIEWS_DIR", "/shared/views");
