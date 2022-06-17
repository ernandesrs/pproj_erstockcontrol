<?php

namespace App\Models;

use Components\Base\Base;

class User extends Base
{
    public function __construct()
    {
        parent::__construct("users", ["first_name", "last_name", "username", "email", "password", "gender"]);
    }
}
