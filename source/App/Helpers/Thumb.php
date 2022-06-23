<?php

namespace App\Helpers;

use Components\Thumb\Thumb as ThumbThumb;

class Thumb
{
    private const thumbsDirectory = CONF_BASE_DIR . CONF_UPLOAD_BASE_DIR;
    private const XS = 50;
    private const SM = 100;
    private const DEFAULT = 250;
    private const MD = 500;
    private const LG = 750;

    /**
     * @param string $path
     * @param integer $width
     * @param integer|null $height
     * @return string|null
     */
    public static function thumb(string $path, int $width, ?int $height = null): ?string
    {
        return (new ThumbThumb(self::thumbsDirectory))->make($path, $width, $height);
    }

    /**
     * @param string $path
     * @param boolean $square
     * @return string|null
     */
    public static function thumbExtraSmall(string $path, bool $square = true): ?string
    {
        return self::thumb($path, self::XS, ($square ? self::XS : null));
    }

    /**
     * @param string $path
     * @param boolean $square
     * @return string|null
     */
    public static function thumbSmall(string $path, bool $square = true): ?string
    {
        return self::thumb($path, self::SM, ($square ? self::SM : null));
    }

    /**
     * @param string $path
     * @param boolean $square
     * @return string|null
     */
    public static function thumbNormal(string $path, bool $square = true): ?string
    {
        return self::thumb($path, self::DEFAULT, ($square ? self::DEFAULT : null));
    }

    /**
     * @param string $path
     * @param boolean $square
     * @return string|null
     */
    public static function thumbMedium(string $path, bool $square = true): ?string
    {
        return self::thumb($path, self::MD, ($square ? self::MD : null));
    }

    /**
     * @param string $path
     * @param boolean $square
     * @return string|null
     */
    public static function thumbLarge(string $path, bool $square = true): ?string
    {
        return self::thumb($path, self::LG, ($square ? self::LG : null));
    }

    /**
     * @param string|null $path se nulo excluir todos thumbnails
     * @return void
     */
    public static function thumbClear(?string $path = null): void
    {
        (new ThumbThumb(self::thumbsDirectory))->unmake($path);
        return;
    }
}
