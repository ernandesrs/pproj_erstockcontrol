<?php

namespace Components\Thumb;

/**
 * Simple Image Manipulator
 */
class SIManipulator
{
    /** @var array */
    public $quality = [
        "jpeg" => 75,
        "webp" => 80,
        "png" => -1
    ];

    /** @var array */
    protected $allowedExtensions = ["jpg", "jpeg", "png", "webp"];

    /** @var array */
    protected $input;

    /** @var array */
    protected $output;

    /** @var array */
    protected $errors;

    /**
     * @param string $path
     * @param int $w
     * @param null|int $h
     * @return boolean
     */
    protected function ioDefine(string $path, int $w, ?int $h = null): bool
    {
        if (!file_exists($path)) {
            $this->errors["message"] = "Imagem não encontrada";
            return false;
        }

        $info = pathinfo($path);
        $this->input = [
            "name" => $info["filename"],
            "extension" => $info["extension"] == "jpg" ? "jpeg" : $info["extension"],
            "width" => null,
            "height" => null
        ];

        $this->output = [
            "name" => base64_encode($this->input["name"]) . "__{$w}" . ($h ? "x{$h}" : null),
            "extension" => $this->toExt ?? $info["extension"],
            "width" => $w,
            "height" => $h ?? null,
            "biggerSide" => $w >= $h ? $w : $h
        ];

        return $this->load($path);
    }

    /**
     * @param string $path
     * @return bool
     */
    protected function load(string $path): bool
    {
        if (!in_array($this->input["extension"], $this->allowedExtensions)) {
            $this->errors["message"] = "Extensão de imagem não é aceita";
            return false;
        }

        $resource = null;
        switch ($this->input["extension"]) {
            case "jpeg":
                $resource = imagecreatefromjpeg($path);
                break;
            case "png":
                $resource = imagecreatefrompng($path);
                break;
            case "webp":
                $resource = imagecreatefromwebp($path);
                break;
            default:
                break;
        }

        if (!$resource) {
            $this->errors["message"] = "Não foi possível carregar a imagem";
            return false;
        }

        $this->input["resource"] = $resource;
        $this->input["width"] = imagesx($resource);
        $this->input["height"] = imagesy($resource);

        return true;
    }

    /**
     * @return boolean
     */
    protected function resize(): bool
    {
        $resized = imagescale($this->input["resource"], -1, $this->output["biggerSide"]);

        if (!$resized)
            return false;

        $this->input["resized"] = $resized;
        $this->input["resized_width"] = imagesx($resized);
        $this->input["resized_height"] = imagesy($resized);

        return true;
    }

    /**
     * @return boolean
     */
    protected function crop(): bool
    {
        $x = ($this->input["resized_width"] - $this->output["width"]) / 2;
        $y = ($this->output["biggerSide"] - ($this->output["height"] ?? $this->output["width"])) / 2;

        $cropped = imagecrop($this->input["resized"], [
            "x" => $x,
            "y" => $y,
            "width" => $this->output["width"],
            "height" => $this->output["height"] ?? ($this->input["resized_height"])
        ]);

        if (!$cropped) {
            $this->errors["message"] = "Houve um erro no precessamento desta imagem";
            return false;
        }

        $this->input["cropped"]  = $cropped;

        return true;
    }

    /**
     * @return bool
     */
    protected function save(): bool
    {
        if (!file_exists($this->thumbsDir)) {
            $this->errors["message"] = "Diretório base não existe";
            return false;
        }

        if (!file_exists($this->thumbsDir . "/" . $this->thumbs))
            mkdir($this->thumbsDir . "/" . $this->thumbs);

        $save = false;
        $resized = $this->input["cropped"];
        $to = $this->thumbsDir . "/{$this->thumbs}/{$this->output["name"]}.{$this->output["extension"]}";

        switch ($this->input["extension"]) {
            case "jpeg":
                $save = imagejpeg($resized, $to, $this->quality["jpeg"]);
                break;
            case "png":
                $save = imagepng($resized, $to, $this->quality["png"]);
                break;
            case "webp":
                $save = imagewebp($resized, $to, $this->quality["webp"]);
                break;
            default:
                $save = false;
                break;
        }

        return $save;
    }

    /**
     * @param boolean $string
     * @return null|string|array
     */
    public function errors(bool $string = true)
    {
        if ($string)
            return $this->errors["message"] ?? null;

        return $this->errors;
    }

    /**
     * Debug
     * @param [type] $resource
     * @return void
     */
    public function print($resource)
    {
        header("Content-type: image/jpeg");
        imagejpeg($resource);
    }
}
