<?php

namespace Components\Uploader;

trait ImageTrait
{
    private static $imageMimes = [
        "image/gif",
        "image/png",
        "image/jpeg",
        "image/bmp",
        "image/webp"
    ];

    /**
     * Upload de imagens
     * @param array $image
     * @param string $subDir
     * @return null|Uploader
     */
    public function image(array $image, string $subDir = "images"): ?Uploader
    {
        if (!$this->extValidation($image, self::$imageMimes))
            return null;

        $this->uploaded = $image;
        $this->subDir = $subDir;

        return $this;
    }
}
