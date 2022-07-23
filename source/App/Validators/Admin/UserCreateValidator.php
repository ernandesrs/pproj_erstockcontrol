<?php

namespace App\Validators\Admin;

use App\Models\Auth;
use App\Models\User;
use App\Validators\Validator;

class UserCreateValidator extends Validator
{
    /**
     * @return boolean
     */
    protected function permissions(): bool
    {
        $logged = (new Auth())->logged();

        if ($logged->level <= $this->validated["level"])
            $this->errors["level"][] = "Escolha um nível inferior ao seu";

        return $this->hasErrors();
    }

    /**
     * @return void
     */
    protected function validate(): void
    {
        $this->validateString("first_name", 2, 25);
        $this->validateString("last_name", 2, 45);
        $this->validateString("username", 5, 25);
        $this->validateString("gender", null, null, User::ALLOWED_GENDERS);

        $this->validateEmail("email");
        $this->uniqueOn("email", "\App\Models\User");

        $this->validatePassword("password");
        $this->validateNumber("level", null, null, User::ALLOWED_LEVELS);
    }
}
