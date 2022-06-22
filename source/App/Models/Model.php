<?php

namespace App\Models;

use Components\Base\Base;

class Model extends Base
{
    /** @var array */
    protected $errors;

    /** @var array */
    protected $filtered;

    /**
     * @param string $table
     * @param array $required
     * @param boolean $timestamps
     */
    public function __construct(string $table, array $required = [], bool $timestamps = true)
    {
        parent::__construct($table, $required, $timestamps);
    }

    /**
     * @return boolean
     */
    protected function hasErrors(): bool
    {
        return count($this->errors ?? []) == 0 ? true : false;
    }

    /**
     * @return array|null
     */
    public function errors(): ?array
    {
        return $this->errors;
    }
}
