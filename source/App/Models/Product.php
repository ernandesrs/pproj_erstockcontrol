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
}
