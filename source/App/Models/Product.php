<?php

namespace App\Models;

class Product extends Model
{
    public const PURCHASE_UNIT = 1;
    public const PURCHASE_PACKAGE = 2;
    public const PURCHASE_PACKAGE_GROUP = 3;
    public const PURCHASE_MODES = [
        self::PURCHASE_UNIT,
        self::PURCHASE_PACKAGE,
        self::PURCHASE_PACKAGE_GROUP,
    ];
    public const PURCHASE_MODES_NAME = [
        self::PURCHASE_UNIT => "Unidade",
        self::PURCHASE_PACKAGE => "Pacote",
        self::PURCHASE_PACKAGE_GROUP => "Grupo de pacotes"
    ];

    public const SALE_UNIT = 1;
    public const SALE_PACKAGE = 2;
    public const SALE_PACKAGE_GROUP = 3;
    public const SALE_MODES = [
        self::SALE_UNIT,
        self::SALE_PACKAGE,
        self::SALE_PACKAGE_GROUP
    ];
    public const SALE_MODES_NAME = [
        self::SALE_UNIT => "Unidade",
        self::SALE_PACKAGE => "Pacote",
        self::SALE_PACKAGE_GROUP => "Grupo de pacotes"
    ];

    public function __construct()
    {
        parent::__construct("products", ["name", "purchase_mode", "sale_mode"]);
    }

    /**
     * @param array $data
     * @return boolean
     */
    public function set(array $data): bool
    {
        if (!$this->filter($data))
            return false;

        if (!$this->validate($data))
            return false;

        $this->name = strtoupper($this->filtered["name"] . " " . self::PURCHASE_MODES_NAME[$this->filtered["purchase_mode"]]);
        $this->purchase_mode = $this->filtered["purchase_mode"];
        $this->sale_mode = $this->filtered["sale_mode"];

        return true;
    }

    /**
     * @param array $data
     * @return boolean
     */
    private function filter(array $data): bool
    {
        $this->filtered["name"] = filter_var($data["name"] ?? null);
        $this->filtered["purchase_mode"] = filter_var($data["purchase_mode"] ?? null, FILTER_VALIDATE_INT);
        $this->filtered["sale_mode"] = filter_var($data["sale_mode"] ?? null, FILTER_VALIDATE_INT);

        foreach ($this->filtered as $key => $filtered) {
            if (empty($filtered))
                $this->errors[$key] = "O campo {$key} é obrigatório";
        }

        return $this->hasErrors();
    }

    /**
     * @return boolean
     */
    private function validate(): bool
    {
        $this->errors = [];

        // NAME VALIDATE
        $upperName = $this->filtered['name'] . " " . self::PURCHASE_MODES_NAME[$this->filtered['purchase_mode']];
        $rules = "name=:name";
        $rValues = "name={$upperName}";
        if (!empty($this->id)) {
            $rules .= " AND id!=:id";
            $rValues .= "&id=" . $this->id;
        }

        if ($this->find($rules, $rValues)->count())
            $this->errors["name"] = "Este nome de produto já está sendo utilizado";

        // PURCHASE MODE VALIDATE
        if (!in_array($this->filtered["purchase_mode"], self::PURCHASE_MODES))
            $this->errors["purchase_mode"] = "Escolha um modo de compra válido";

        // SALE MODE VALIDATE
        if (!in_array($this->filtered["sale_mode"], self::SALE_MODES))
            $this->errors["sale_mode"] = "Escolha um modo de venda válido";
        else {
            if ($this->filtered["sale_mode"] > $this->filtered["purchase_mode"])
                $this->errors["sale_mode"] = "Modo de venda não válido para o tipo de compra selecionado";
        }

        return $this->hasErrors();
    }
}
