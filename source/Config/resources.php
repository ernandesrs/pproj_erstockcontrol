<?php

if (CONF_APP_LOCAL !== "dev")
    return;

/**
 * 
 * este arquivo é responsável por copiar os arquivos .css e .js da pasta protegida de recursos
 * para pasta pública
 * 
 */

$sources = [
    "public/assets/css" => [
        "shared/styles/dash/custom.css"
    ],

    "public/assets/js" => [
        "shared/scripts/dash/scripts.js",

        "node_modules/jquery/dist/jquery.min.js"
    ],
];

foreach ($sources as $destiny => $resources) {
    foreach ($resources as $resource) {
        
        $fResourcePath = CONF_BASE_DIR . "/{$resource}";
        $fResourceDestiny = CONF_BASE_DIR . "/{$destiny}";

        if (file_exists($fResourcePath)) {
            if (!file_exists($fResourceDestiny))
                resources_cmDir($destiny);

            $resourceName = resources_grName($resource);

            copy($fResourcePath, $fResourceDestiny . "/{$resourceName}");
        }
    }
}

function resources_cmDir($destiny)
{
    $destinyArr = explode("/", $destiny);
    $ck = CONF_BASE_DIR;
    foreach ($destinyArr as $dest) {
        $ck .= "/{$dest}";
        if (!file_exists($ck))
            mkdir($ck);
    }
}

function resources_grName($resource)
{
    return array_reverse(explode("/", $resource))[0];
}
