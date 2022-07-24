<?php

namespace App\Helpers;

use Components\Uploader\Uploader;

/**
 * 
 * Extende Uploader e adicionar utilitários:
 * 
 * * Métodos do Storage
 * * store() - armazena o arquivo definido
 * * unlink() - remove(e limpa cache/thumbnails se for imagem)
 * * unlinkLast() - remove o último arquivo enviado
 * * url() - url para o arquivo
 * * path() - caminho para o arquivo
 * 
 * * Métodos do Uploader
 * * dirByDate() - define se será criada uma pasta com a data atual para o arquivo
 * * errors() - error ocorridos
 * * file() - upload de arquivos em geral
 * * fileMimes() - define/altera mime types aceitos para arquivos
 * * image() - upload de imagens
 * * imageMimes() - define/altera mime types aceitos para imagens
 * * media() - upload de mídias
 * * mediaMimes() - define/altera mime types aceitos para mídias
 * 
 */
class Storage extends Uploader
{
    /**
     * Caminho para o arquivo enviado
     *
     * @var string
     */
    private $uploadedPath;

    public function __construct()
    {
        parent::__construct(CONF_BASE_DIR . CONF_UPLOAD_BASE_DIR);
    }

    /**
     * Armazena o arquivo definido
     * 
     * @param string|null $rename
     * @return string|null
     */
    public function store(?string $rename = null): ?string
    {
        $this->uploadedPath = parent::store($rename);
        return $this->uploadedPath;
    }

    /**
     * Remove um arquivo e limpa cache caso o arquivo seja uma imagem
     * 
     * @param string $path caminho para o arquivo a partir da pasta de uploads
     * @return void
     */
    public function unlink(string $path): void
    {
        $path = $this->uploadDir . $path;

        if (file_exists($path)) {

            if (in_array(mime_content_type($path), $this->allowedImageMimes))
                Thumb::thumbClear($path);

            unlink($path);
        }

        return;
    }

    /**
     * Remove o último arquivo enviado
     * 
     * @return void
     */
    public function unlinkLast(): void
    {
        if (empty($this->uploadedPath))
            return;

        $this->unlink($this->subdir . $this->uploadedPath);

        return;
    }

    /**
     * Url para o arquivo
     * 
     * @param string|null $path
     * @return string
     */
    public function url(?string $path = null): string
    {
        return url(CONF_UPLOAD_BASE_DIR . ($path ?? $this->uploadedPath));
    }

    /**
     * Caminho absoluto para o arquivo
     * 
     * @param string|null $path
     * @return string
     */
    public function path(?string $path = null): string
    {
        return $this->uploadDir . ($path ?? $this->uploadedPath);
    }
}
