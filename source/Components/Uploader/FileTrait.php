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

    /**
     * Upload de arquivso em geral
     * @param array $file
     * @param string $subDir
     * @return null|Uploader
     */
    public function file(array $file, string $subDir = "files"): ?Uploader
    {
        if (!$this->extValidation($file, self::$fileMimes))
            return null;

        $this->uploaded = $file;
        $this->subDir = $subDir;

        return $this;
    }
}
