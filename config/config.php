<?php

$env = parse_ini_file(__DIR__ . "/../.env");

define("CONF_URL_BASE", $env["APP_URL_BASE"] ?? null);
