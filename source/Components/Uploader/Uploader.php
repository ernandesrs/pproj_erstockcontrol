<?php

namespace Components\Uploader;

use Exception;
use stdClass;

class Uploader
{
    use ImageTrait;
    use MediaTrait;
    use FileTrait;

    /** @var string */
    private $uploadDir;

    /** @var string */
    private $subDir;

    /** @var bool */
    private $dirByDate;

    /** @var array */
    private $uploaded;

    /** @var Exception */
    private $exception;

    /** @var array */
    private $error;

    /**
     * @param string $uploadBaseDir
     */
    public function __construct(string $uploadBaseDir)
    {
        $this->uploadDir = $uploadBaseDir;
        $this->dirByDate = true;
    }

    /**
     * @param string|null $rename
     * @return string|null
     */
    public function store(?string $rename = null): ?string
    {
        // checar e criar diretórios
        $finalPath = $this->cmDirectory();

        // renomear e/ou mover arquivos
        $name = $this->uploaded["name"];
        $tmpName = $this->uploaded["tmp_name"];
        $ext = pathinfo($this->uploaded["name"], PATHINFO_EXTENSION);

        if ($rename) $newName = $rename;
        else $newName = base64_encode($name . "_" . time());
        
        $to = $finalPath . "/{$newName}.{$ext}";

        if (!is_uploaded_file($tmpName))
            return null;

        if (!move_uploaded_file($tmpName, $to))
            return null;

        // limpar o caminho para o arquivo
        return str_replace($this->uploadDir, "", $to);
    }

    /**
     * @param boolean $make
     * @return Uploader
     */
    public function dirByDate(bool $make = true): Uploader
    {
        $this->dirByDate = $make;
        return $this;
    }

    /**
     * @return string
     */
    private function cmDirectory(): string
    {
        $checkedDir = $this->uploadDir;
        if ($this->subDir) {
            $subDirsArr = explode("/", $this->subDir);
            foreach ($subDirsArr as $subDir) {
                $checkedDir .= "/" . $subDir;
                if (!is_dir($checkedDir))
                    mkdir($checkedDir);
            }
        }

        if ($this->dirByDate) {
            $year = date("Y");
            $month = date("m");

            $checkedDir .= "/{$year}";
            if (!is_dir($checkedDir))
                mkdir($checkedDir);

            $checkedDir .= "/{$month}";
            if (!is_dir($checkedDir))
                mkdir($checkedDir);
        }

        return $checkedDir;
    }

    /**
     * @param array $file
     * @param array $mimes
     * @return bool
     */
    private function extValidation(array $file, array $mimes): bool
    {
        if (!in_array($file["type"], $mimes, true)) {
            $this->exception = new Exception("A extensão do arquivo enviado não é não aceito");
            $this->error = [
                "message" => $this->exception->getMessage(),
                "allowedExtensions" => implode(", ", $mimes),
            ];
            return false;
        }

        return true;
    }

    /**
     * @return stdClass|null
     */
    public function error(): ?stdClass
    {
        return ($this->error ?? null) ? (object) $this->error : null;
    }
}
