<?php

/**
 * 
 * carregar os arquivos de funções helper
 * 
 */

$functions = [
    "components",
    "helpers",
    "storage",
    "thumb",
    "template",
];

foreach ($functions as $func) {
    $funcPath = __DIR__ . "/{$func}.php";

    if (file_exists($funcPath)) {
        require $funcPath;
    }
}
