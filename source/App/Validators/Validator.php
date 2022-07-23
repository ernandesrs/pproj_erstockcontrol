<?php

namespace App\Validators;

abstract class Validator
{
    use Validations;

    /**
     * Dados da requisição
     * 
     * @var array $data
     *
     */
    protected $data;

    /**
     * Dados validados
     *
     * @var array
     */
    protected $validated;

    /**
     * Erros de validação
     * 
     * @var array
     */
    protected $errors;

    /**
     * Erro ao validar
     *
     * @var bool
     */
    protected $fail;

    /**
     * Verificar todas as permissões para esta ação.
     * Neste método pode-se checar se o usuário logado possui permissão, por exemplo, para
     * criar/editar usuário, se possui permissão para alterar um campo específico, etc.
     * 
     * @return boolean
     */
    abstract protected function permissions();

    /**
     * Chame os métodos de validação disponíveis necessários para cada campo
     * 
     * @return void
     */
    abstract protected function validate();

    /**
     * Dados validados
     * 
     * @return array|null
     */
    public function validated(): ?array
    {
        return $this->validated;
    }

    /**
     * Erros ocorridos
     * 
     * @return array|null
     */
    public function errors(): ?array
    {
        return $this->errors;
    }

    /**
     * Dispara as validações
     * 
     * @return null|Validator
     */
    public function boot(): ?Validator
    {
        $this->data = $_POST;

        $this->validate();

        $this->permissions();

        if ($this->hasErrors())
            $this->fail = true;
        else
            $this->fail = false;

        return $this;
    }

    /**
     * Verifica se houve erros
     * 
     * @return boolean
     */
    public function fail(): bool
    {
        return $this->fail ?? false;
    }
}
