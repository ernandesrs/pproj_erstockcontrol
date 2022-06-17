<?php

namespace Components\Base;

use PDO;
use PDOStatement;
use stdClass;

abstract class Base extends Connect
{
    /** @var String */
    private $table;

    /** @var Array */
    private $required;

    /** @var String */
    private $query;

    /** @var  Array */
    private $rulesValuesArr;

    /** @var bool */
    private $timestamps;

    /** @var stdClass */
    private $data;

    /** @var Array */
    private $errors;

    /** @var String */
    private $errorMessage;

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
        $this->errors = [];
    }

    /**
     * @param string|null $rules
     * @param string|null $rulesValues
     * @param string $columns
     * @return Base
     */
    public function find(?string $rules = null, ?string $rulesValues = null, string $columns = "*"): Base
    {
        $this->query = "SELECT {$columns} FROM {$this->table} WHERE 1=:n" . (!empty($rules) ? " AND " . $rules : null);
        parse_str($rulesValues ? $rulesValues . "&n=1" : "n=1", $this->rulesValuesArr);
        return $this;
    }

    /**
     * @return boolean
     */
    public function add(): bool
    {
        $this->query = "INSERT INTO {$this->table} (" . $this->columns() . ") VALUES (" . implode(",", array_map(function ($i) {
            return ":" . $i;
        }, explode(",", $this->columns()))) . ")";

        $con = $this->getConnection();
        $stmt = $this->bind($con);
        if (!$stmt)
            return false;

        if (!$stmt->execute())
            return false;

        $this->id = $con->lastInsertId();

        return true;
    }

    /**
     * @param boolean $all
     * @return null|Array|Base
     */
    public function get(bool $all = false)
    {
        $stmt = $this->bind($this->getConnection(), $this->rulesValuesArr);

        if (!$stmt)
            return null;

        if ($stmt->execute()) {
            if ($all)
                return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
            else
                return $stmt->fetchObject(static::class);
        }

        return null;
    }

    /**
     * Update by id
     * @return boolean
     */
    public function update(): bool
    {
        if (empty($this->id))
            return false;

        $this->query = "UPDATE {$this->table} SET " . implode(",", array_map(function ($i) {
            return $i . "=:" . $i;
        }, explode(",", $this->columns()))) . " WHERE id=:id";

        $stmt = $this->bind($this->getConnection());

        if (!$stmt)
            return false;

        return $stmt->execute();
    }

    /**
     * Delete by id 
     * @return boolean
     */
    public function delete(): bool
    {
        if (empty($this->id))
            return false;

        $this->query = "DELETE FROM {$this->table} WHERE id=:id";
        $stmt = $this->getConnection()->prepare($this->query);
        if (!$stmt->bindValue(":id", $this->id, PDO::PARAM_INT))
            return false;

        return $stmt->execute();
    }

    /**
     * @return integer
     */
    public function count(): int
    {
        $stmt = $this->bind($this->getConnection(), $this->rulesValuesArr);
        if (!$stmt || !$stmt->execute())
            return null;
        return $stmt->rowCount();
    }

    /**
     * @param PDO $con
     * @return null|PDOStatement
     */
    private function bind(PDO $con, ?array $arr = null)
    {
        $stmt = $con->prepare($this->query);
        if (!$stmt)
            return null;

        if ($arr == null) {
            if (!$this->requiredCheck()) {
                $this->errorMessage = "Preencha todos os campos: " . implode(", ", $this->errors);
                return null;
            }

            if ($this->timestamps) {
                if (!empty($this->id)) {
                    $this->updated_at = date("Y-m-d H:i:s");
                } else
                    $this->created_at = date("Y-m-d H:i:s");
            }
            $data = $this->data;
        } else {
            $data = $arr;
        }

        foreach ($data as $key => $value) {
            switch ($value) {
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                case is_numeric($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
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
        if (empty($this->id))
            $required = $this->required;
        else
            $required = array_keys((array) $this->data);

        if ($this->timestamps) {
            if (empty($this->id))
                array_push($required, "created_at");
        }
        return implode(",", $required);
    }

    /**
     * @return boolean
     */
    private function requiredCheck(): bool
    {
        foreach ($this->required as $required) {
            if (empty($this->$required))
                $this->errors[] = $required;
        }
        return count($this->errors) == 0 ? true : false;
    }

    /**
     * @return stdClass
     */
    public function data(): stdClass
    {
        return $this->data ?? new stdClass;
    }

    /**
     * @return Array
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * @return string|null
     */
    public function errorMessage(): ?string
    {
        return $this->errorMessage ?? null;
    }

    /**
     * @param String $key
     * @param null|mixed $value
     * @return void
     */
    public function __set(string $key, $value): void
    {
        if (empty($this->data)) {
            $this->data = new stdClass;
        }

        $this->data->$key = $value;
    }

    /**
     * @param String $key
     */
    public function __get(string $key)
    {
        return $this->data->$key ?? null;
    }

    /**
     * @param string $key
     * @return boolean
     */
    public function __isset(string $key): bool
    {
        return isset($this->data->$key);
    }

    /**
     * @param string $key
     * @return;
     */
    public function __unset($key)
    {
        unset($this->data->$key);
    }
}
