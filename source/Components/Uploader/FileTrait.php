<?php

namespace Components\Uploader;

trait FileTrait
{
    /**
     * Upload de arquivos em geral
     * 
     * @param array $file
     * @param string $subDir
     * @return Uploader
     */
    public function file(array $file, string $subDir = "files"): Uploader
    {
        $this->uploaded = $file;
        $this->subDir = $subDir;
        $this->allowedMimes = $this->allowedFileMimes;

        return $this;
    }

    /**
     * Define/altera os mime types aceitos
     * 
     * @param array $allowedMimes
     * @return Uploader
     */
    public function fileMimes(array $allowedMimes): Uploader
    {
        $this->allowedFileMimes = $allowedMimes;
        $this->allowedMimes = $allowedMimes;
        return $this;
    }
}
