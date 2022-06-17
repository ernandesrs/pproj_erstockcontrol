<?php

$env = parse_ini_file(__DIR__ . "/../.env");

define("CONF_URL_BASE", $env["APP_URL_BASE"] ?? null);

define("CONF_DBASE_NAME", $env["DBASE_NAME"]);
define("CONF_DBASE_HOST", $env["DBASE_HOST"]);
define("CONF_DBASE_PORT", $env["DBASE_PORT"]);
define("CONF_DBASE_USER", $env["DBASE_USER"]);
define("CONF_DBASE_PASS", $env["DBASE_PASS"]);
