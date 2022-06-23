<?php

namespace Components\Thumb;

class Thumb extends SIManipulator
{

    /** @var string */
    protected $thumbsDir;

    /** @var string */
    protected $toExt;

    /** @var string */
    protected $thumbs;

    /**
     * @param string $dir
     */
    public function __construct(string $dir, ?string $toExt = "jpeg")
    {
        $this->thumbsDir = $dir;
        $this->toExt = $toExt ? (in_array($toExt, $this->allowedExtensions) ? $toExt : null) : null;
        $this->thumbs = "thumbs";
    }

    /**
     * @param string $path
     * @param integer $w
     * @param integer|null $h
     * @return null|string
     */
    public function make(string $path, int $w, ?int $h = null): ?string
    {
        if (!$this->ioDefine($path, $w, $h))
            return null;

        if (!$this->resize($w, $h))
            return null;

        if ($h)
            if (!$this->crop())
                return null;

        if (!$this->save())
            return null;

        return "/" . $this->thumbs . "/{$this->output["name"]}.{$this->output["extension"]}";
    }
}
