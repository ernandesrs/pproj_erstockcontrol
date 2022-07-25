<?php

/**
 * 
 * 
 * Funções para facilitar o acesso à classe helper Storage
 * 
 * 
 */

use App\Helpers\Storage;

/**
 * @return Storage
 */
function storage(): Storage
{
    return (new Storage());
}

/**
 * @param array $image
 * @param string $subDir
 * @return Storage
 */
function storage_image(array $image, string $subDir = "images"): Storage
{
    return storage()->image($image, $subDir);
}

/**
 * @param array $media
 * @param string $subDir
 * @return Storage
 */
function storage_media(array $media, string $subDir = "medias"): Storage
{
    return storage()->media($media, $subDir);
}

/**
 * @param array $file
 * @param string $subDir
 * @return Storage
 */
function storage_file(array $file, string $subDir = "files"): Storage
{
    return storage()->file($file, $subDir);
}

/**
 * @param string $path
 * @return string
 */
function storage_url(string $path): string
{
    return storage()->url($path);
}

/**
 * @param null|string $path
 * @return string
 */
function storage_path(?string $path): string
{
    return storage()->path($path);
}
