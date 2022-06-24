<?php

namespace App\Controllers\Dash;

use App\Models\Product;

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
    public function store(): void
    {
        $data = $_POST;
        $product = new Product();

        if (!$product->set($data)) {
            echo json_encode([
                "success" => false,
                "message" => message()->warning("Erro ao validar os dados informados. Verifique e tente de novo.")->float()->render(),
                "errors" => $product->errors()
            ]);
            return;
        }

        if (!$product->add()) {
            echo json_encode([
                "success" => false,
                "message" => message()->warning("Houve um erro interno ao tentar salvar dados.")->float()->render()
            ]);
            return;
        }

        message()->success("Um novo produto foi cadastrado! Agora você pode cadatrar lotes deste produto.")->float(12)->flash();
        echo json_encode([
            "success" => true,
            "redirect" => $this->route("dash.products")
        ]);
        return;
    }

    /**
     * @return void
     */
    public function edit(): void
    {
        $this->view("dash/product-edit")->seo("Editar produto")->render();
    }
}
