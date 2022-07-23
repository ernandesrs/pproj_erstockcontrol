<?php

namespace App\Validators\Admin;

use App\Models\Auth;
use App\Models\User;
use App\Validators\Validator;

class UserUpdateValidator extends Validator
{
    /**
     * @var string
     */
    private $redirectUsersList = "/dash/usuarios";

    public function __construct(?User $user)
    {
        $this->user = $user;
    }

    /**
     * @return boolean
     */
    protected function permissions(): bool
    {
        return $this->hasErrors();
    }

    /**
     * @return void
     */
    protected function validate(): void
    {
        /** @var User $logged */
        $logged = (new Auth())->logged();

        if (!$this->user) {
            message()->warning("O usuário que você tentou atualizar não existe ou já foi excluído")->float()->flash();
            echo json_encode([
                "success" => false,
                "redirect" => $this->redirectUsersList
            ]);
            return;
        }

        if ($logged->level <= $this->user->level) {
            echo json_encode([
                "success" => false,
                "message" => message()->warning("Você não possui esse tipo de permissão")->float()->render(),
            ]);
            return;
        }

        $this->validateString("first_name", 2, 25);
        $this->validateString("last_name", 2, 45);
        $this->validateString("username", 5, 25);
        $this->validateString("gender", null, null, User::ALLOWED_GENDERS);

        $this->validateEmail("email");
        $this->uniqueOn("email", "\App\Models\User", "id", $this->user->id);

        if (!empty($this->data["password"]))
            $this->validatePassword("password");
    }
}
