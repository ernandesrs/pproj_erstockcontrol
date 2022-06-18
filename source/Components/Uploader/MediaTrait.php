<?php

namespace Components\Uploader;

trait MediaTrait
{
    private static $mediaMimes = [
        "video/webm",
        "video/ogg",
        "video/mp4",

        "audio/midi",
        "audio/mpeg",
        "audio/webm",
        "audio/ogg",
        "audio/wav"
    ];
    
    /**
     * Upload de audio e vídeos
     * @param array $media
     * @param string $subDir
     * @return null|Uploader
     */
    public function media(array $media, string $subDir = "medias"): ?Uploader
    {
        if (!$this->extValidation($media, self::$mediaMimes))
            return null;

        $this->uploaded = $media;
        $this->subDir = $subDir;

        return $this;
    }
}
