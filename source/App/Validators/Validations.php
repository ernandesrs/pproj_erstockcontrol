<?php

namespace App\Validators;

use Exception;

trait Validations
{
    /**
     * @param string $key
     * @param null|int|float $min
     * @param null|int|float $max
     * @param null|array $in
     * @return boolean
     */
    protected function validateString(string $key, $min = null, $max = null, ?array $in = null): bool
    {
        if (empty($this->data[$key]))
            $this->errors[$key][] = "Campo obrigatório";
        else {
            $this->validated[$key] = filter_var($this->data[$key] ?? null, FILTER_DEFAULT) ?? null;

            if (!$this->validated[$key])
                $this->errors[$key][] = "Informe uma string";
            else {
                if ($min !== null && strlen($this->validated[$key]) < $min)
                    $this->errors[$key][] = "Mínimo {$min} caracteres";

                if ($max !== null && strlen($this->validated[$key]) > $max)
                    $this->errors[$key][] = "Máximo {$max} caracteres";

                if (is_array($in) && !in_array($this->validated[$key], $in))
                    $this->errors[$key][] = "Valor não aceito";
            }
        }

        return $this->isValid($key);
    }

    /**
     * @param string $key
     * @param null|int|float $min
     * @param null|int|float $max
     * @param null|array $in
     * @return boolean
     */
    protected function validateNumber(string $key, $min = null, $max = null, ?array $in = null): bool
    {
        if (empty($this->data[$key]))
            $this->errors[$key][] = "Campo obrigatório";
        else {
            $likeInt = filter_var($this->data[$key] ?? null, FILTER_VALIDATE_INT) ?? null;
            $likeFloat = filter_var($this->data[$key] ?? null, FILTER_VALIDATE_FLOAT) ?? null;

            $this->validated[$key] = $likeFloat ?? $likeInt;

            if ($this->validated[$key] === null)
                $this->errors[$key][] = "O valor precisa ser numérico";
            else {
                if ($min !== null && $this->validated[$key] < $min)
                    $this->errors[$key][] = "O valor precisa ser maior/igual a {$min}";

                if ($max !== null && $this->validated[$key] > $max)
                    $this->errors[$key][] = "O valor precisa ser menor/igual a {$max}";

                if (is_array($in) && !in_array($this->validated[$key], $in))
                    $this->errors[$key][] = "Valor não aceito";
            }
        }

        return $this->isValid($key);
    }

    /**
     * @param string $key
     * @return boolean
     */
    protected function validateEmail(string $key): bool
    {
        if (empty($this->data[$key]))
            $this->errors[$key][] = "Campo obrigatório";
        else {
            $this->validated[$key] = filter_var($this->data[$key] ?? null, FILTER_VALIDATE_EMAIL) ?? null;

            if (!$this->validated[$key])
                $this->errors[$key][] = "O email informado é inválido";
        }

        return $this->isValid($key);
    }

    /**
     * Verifica se o campo $key é único no modelo informado
     * @param string $key campo a validar
     * @param string $model classe model com namespace
     * @param string|null $exceptColumn
     * @param null|mixed|int|float|string $exceptValue
     * @return boolean
     */
    protected function uniqueOn(string $key, string $model, ?string $exceptColumn = null, $exceptValue = null): bool
    {
        if (!key_exists($key, $this->validated)) {
            throw new Exception("Antes de chamar o método uniqueOn, valide o campo '{$key}'.");
            return false;
        }

        $modelInstance = new $model();

        $rules = "{$key}=:{$key}";
        $ruleValues = "{$key}={$this->validated[$key]}";
        if ($exceptColumn !== null) {
            $rules .= " AND {$exceptColumn}!=:{$exceptColumn}";
            $ruleValues .= "&{$exceptColumn}={$exceptValue}";
        }

        if ($modelInstance->find($rules, $ruleValues)->count() > 0)
            $this->errors[$key][] = "Já está cadastrado";

        return $this->isValid($key);
    }

    /**
     * @param string $key
     * @param integer|null $min
     * @param integer|null $max
     * @return boolean
     */
    protected function validatePassword(string $key, ?int $min = null, ?int $max = null): bool
    {
        $this->validateString($key, $min, $max);

        if (!$this->validated[$key])
            $this->errors[$key][] = "A senha informada e inválida";
        else {
            if ($this->validated[$key] != $this->data[$key . "_confirm"] ?? null) {
                $this->errors[$key][] = "As senhas não conferem";
                $this->errors[$key . "_confirm"][] = "As senhas não conferem";
            }
        }

        return $this->isValid($key);
    }

    /**
     * @param string $key
     * @return boolean
     */
    private function isValid(string $key): bool
    {
        if ($this->hasErrors($key)) {
            $this->validated[$key] = null;
            return false;
        }

        return true;
    }

    /**
     * @param string|null $key
     * @return boolean
     */
    protected function hasErrors(?string $key = null): bool
    {
        return count($key ? ($this->errors[$key] ?? []) : ($this->errors ?? []));
    }
}
