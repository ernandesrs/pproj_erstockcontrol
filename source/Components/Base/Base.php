<?php

namespace Components\Base;

use PDO;
use PDOStatement;
use stdClass;

class Base extends Connect
{
    /** @var String */
    private $table;

    /** @var Array */
    private $required;

    /** @var bool */
    private $timestamps;

    /** @var stdClass */
    private $data;

    /** @var Array */
    private $errors;

    /**
     * @param string $table
     * @param array $required
     * @param boolean $timestamps
     */
    public function __construct(string $table, array $required = [], bool $timestamps = true)
    {
        $this->table = $table;
        $this->required = $required;
        $this->timestamps = $timestamps;
        $this->data = new stdClass;
        $this->errors = [];
    }

    /**
     * @return boolean
     */
    public function add(): bool
    {
        $query = "INSERT INTO {$this->table} (" . $this->columns() . ") VALUES (" . implode(",", array_map(function ($i) {
            return ":" . $i;
        }, explode(",", $this->columns()))) . ")";

        $stmt = $this->bind($query, $this->getConnection());
        if (!$stmt)
            return false;

        return $stmt->execute();
    }

    /**
     * @param string $query
     * @param PDO $con
     * @return null|PDOStatement
     */
    private function bind(string $query, PDO $con)
    {
        if (!$this->requiredCheck())
            return null;

        $stmt = $con->prepare($query);
        if (!$stmt)
            return null;

        if ($this->timestamps) {
            if (!empty($this->data->id)) {
                $this->updated_at = date("Y-m-d H:i:s");
            } else {
                $this->created_at = date("Y-m-d H:i:s");
            }
        }

        foreach ($this->data as $key => $value) {
            switch ($value) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }

            if (!$stmt->bindValue(":{$key}", $value, $type))
                return null;
        }

        return $stmt;
    }

    /**
     * @return string
     */
    private function columns(): string
    {
        $required = $this->required;
        if ($this->timestamps) {
            if (empty($this->data->id))
                array_push($required, "created_at");
            else
                array_push($required, "updated_at");
        }
        return implode(",", $required);
    }

    /**
     * @return boolean
     */
    private function requiredCheck(): bool
    {
        foreach ($this->required as $required) {
            if (empty($this->data->$required))
                $this->errors[] = $required;
        }
        return count($this->errors) == 0 ? true : false;
    }

    /**
     * @return stdClass
     */
    public function data(): stdClass
    {
        return $this->data;
    }

    /**
     * @return Array
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * @param String $key
     * @param null|mixed $value
     * @return void
     */
    public function __set(string $key, $value): void
    {
        $this->data->$key = $value;
    }

    /**
     * @param String $key
     */
    public function __get(string $key)
    {
        return $this->data->$key ?? null;
    }
}
