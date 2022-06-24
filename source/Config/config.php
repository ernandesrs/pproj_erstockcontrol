<?php

$env = parse_ini_file(__DIR__ . "/../../.env");

$iconsPath = __DIR__ . "/../../shared/others/icons.json";
$icons = json_decode(file_exists($iconsPath) ? file_get_contents($iconsPath) : "");

define("CONF_APP_LOCAL", $env["APP_LOCAL"] ?? "dev");
define("CONF_APP_NAME", $env["APP_NAME"] ?? null);
define("CONF_URL_BASE", $env["APP_URL_BASE"] ?? null);
define("CONF_ICONS", (array) $icons);

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

define("CONF_BASE_DIR", __DIR__ . "/../..");

define("CONF_VIEWS_DIR", "/shared/views");

define("CONF_ASSETS_DIR", "/public/assets");

define("CONF_UPLOAD_BASE_DIR", "/storage/uploads");
define("CONF_UPLOAD_IMAGES_DIR", "images");
define("CONF_UPLOAD_MEDIAS_DIR", "medias");
define("CONF_UPLOAD_FILES_DIR", "files");

/**
 * DASHBOARD: menus do sidebar
 */
define("CONF_DASHBOARD_SIDEBAR", [
    "menu" => [
        [
            "text" => "Resumo geral",
            "routeName" => "dash.dash",
            "iconName" => "pieChart",
            "target" => "_self",
            "activeIn" => [
                "dash.dash"
            ]
        ],
        [
            "text" => "Produtos",
            "routeName" => "dash.products",
            "iconName" => "box2",
            "target" => "_self",
            "activeIn" => [
                "dash.products",
                "dash.products.create",
                "dash.products.edit",
            ]
        ],
        [
            "text" => "Usuários",
            "routeName" => "dash.users",
            "iconName" => "userGroup",
            "target" => "_self",
            "activeIn" => [
                "dash.users",
                "dash.users.create",
                "dash.users.edit",
            ]
        ],
    ],
    "outros" => [
        [
            "text" => "Configurações",
            "routeName" => "dash.settings",
            "iconName" => "sliders",
            "target" => "_self",
            "activeIn" => [
                "dash.settings"
            ]
        ],
        [
            "text" => "Perfil",
            "routeName" => "dash.profile",
            "iconName" => "userProfile",
            "target" => "_self",
            "activeIn" => [
                "dash.profile"
            ]
        ],
        [
            "text" => "Sair",
            "routeName" => "auth.logout",
            "iconName" => "authLogout",
            "target" => "_self",
            "activeIn" => [
                "auth.logout"
            ]
        ],
    ]
]);
