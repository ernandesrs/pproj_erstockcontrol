<?php

namespace Components\Base;

use PDO;
use PDOException;

abstract class Connect
{
    /** @var PDOException */
    protected $exception;

    /**
     * @return PDO|null
     */
    protected function getConnection(): ?PDO
    {
        $dsn = "mysql:dbname=" . CONF_DBASE_NAME . ";host=" . CONF_DBASE_HOST . (empty(CONF_DBASE_PORT) ? null : ";port=" . CONF_DBASE_PORT);
        $user = CONF_DBASE_USER;
        $pass = CONF_DBASE_PASS;
        $opt = [];

        try {
            return new PDO($dsn, $user, $pass, $opt);
        } catch (PDOException $e) {
            $this->exception = $e;
            return null;
        }
    }
}
