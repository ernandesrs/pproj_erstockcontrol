<?php

namespace Components\Uploader;

trait FileTrait
{
    private static $fileMimes = [
        "text/plain",
        "text/html",
        "text/css",
        "text/javascript",

        "application/vnd.mspowerpoint",
        "application/pdf"
    ];
}
