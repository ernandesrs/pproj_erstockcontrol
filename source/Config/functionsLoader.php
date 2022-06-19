<?php

/**
 * 
 * 
 * 
 */

$functions = [
    "components"
];

foreach ($functions as $func) {
    $funcPath = __DIR__ . "/../Functions/{$func}.php";

    if (file_exists($funcPath)) {
        require $funcPath;
    }
}
