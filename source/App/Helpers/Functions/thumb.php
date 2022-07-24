<?php

use \App\Helpers\Thumb as HelpersThumb;

/**
 * @param string $path caminho absoluto até a imagem
 * @param integer $width
 * @param integer|null $height
 * @param boolean $url
 * @return string
 */
function thumb(string $path, int $width, ?int $height = null, bool $url = true): string
{
    $thumb = HelpersThumb::thumb($path, $width, $height);

    if ($url)
        return storage_url($thumb ?? "");

    return $thumb;
}

/**
 * @param string $path caminho absoluto até a imagem
 * @param boolean $url define se o retorno será a url ou o caminho a partir do diretório de thumbnails
 * @param boolean $square define se a imagem será quadrada
 * @return string
 */
function thumb_xs(string $path, bool $url = true, bool $square = true): string
{
    $thumb = HelpersThumb::thumbExtraSmall($path, $square);

    if ($url)
        return storage_url($thumb ?? "");

    return $thumb;
}

/**
 * @param string $path caminho absoluto até a imagem
 * @param boolean $url define se o retorno será a url ou o caminho a partir do diretório de thumbnails
 * @param boolean $square define se a imagem será quadrada
 * @return string
 */
function thumb_sm(string $path, bool $url = true, bool $square = true): string
{
    $thumb = HelpersThumb::thumbSmall($path, $square);

    if ($url)
        return storage_url($thumb ?? "");

    return $thumb;
}

/**
 * @param string $path caminho absoluto até a imagem
 * @param boolean $url define se o retorno será a url ou o caminho a partir do diretório de thumbnails
 * @param boolean $square define se a imagem será quadrada
 * @return string
 */
function thumb_nm(string $path, bool $url = true, bool $square = true): string
{
    $thumb = HelpersThumb::thumbNormal($path, $square);

    if ($url)
        return storage_url($thumb ?? "");

    return $thumb;
}

/**
 * @param string $path caminho absoluto até a imagem
 * @param boolean $url define se o retorno será a url ou o caminho a partir do diretório de thumbnails
 * @param boolean $square define se a imagem será quadrada
 * @return string
 */
function thumb_md(string $path, bool $url = true, bool $square = true): string
{
    $thumb = HelpersThumb::thumbMedium($path, $square);

    if ($url)
        return storage_url($thumb ?? "");

    return $thumb;
}

/**
 * @param string $path caminho absoluto até a imagem
 * @param boolean $url define se o retorno será a url ou o caminho a partir do diretório de thumbnails
 * @param boolean $square define se a imagem será quadrada
 * @return string
 */
function thumb_lg(string $path, bool $url = true, bool $square = true): string
{
    $thumb = HelpersThumb::thumbLarge($path, $square);

    if ($url)
        return storage_url($thumb ?? "");

    return $thumb;
}
