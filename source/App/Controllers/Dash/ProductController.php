<?php

namespace App\Controllers\Dash;

class ProductController extends DashController
{
    /**
     * @param [type] $router
     */
    public function __construct($router)
    {
        parent::__construct($router);
    }

    /**
     * @return void
     */
    public function index(): void
    {
        $this->view("dash/products")->seo("Lista de produtos")->render();
    }

    /**
     * @return void
     */
    public function create(): void
    {
        $this->view("dash/product-create")->seo("Cadastrar novo produto")->render();
    }

    /**
     * @return void
     */
    public function edit(): void
    {
        $this->view("dash/product-edit")->seo("Editar produto")->render();
    }
}
