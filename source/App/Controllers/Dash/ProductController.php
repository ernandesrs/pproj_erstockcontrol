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
        /** @var int */
        $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT) ?? 1;

        /** @var Product */
        $products = (new Product())->limit(12)->offset($page)->orderBy("created_at ASC")->find();

        $this->view("dash/products", [
            "pagination" => $products->paginate(),
            "products" => $products->get(true),
        ])->seo("Lista de produtos")->render();
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
        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT) ?? 0;
        $product = (new Product())->find("id=:id", "id={$id}")->get();
        if (!$product) {
            message()->warning("O produto não foi encontrado ou já foi excluído.")->float()->flash();
            $this->router->redirect("dash.products");
            return;
        }

        $this->view("dash/product-edit", ["product" => $product])->seo("Editar produto")->render();
    }

    /**
     * @return void
     */
    public function update(): void
    {
        /** @var int */
        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT) ?? 0;

        /** @var Product */
        $product = (new Product())->find("id=:id", "id={$id}")->get();

        if (!$product) {
            message()->warning("Atualização de produto que não existe ou que já foi excluído.")->float()->flash();
            echo json_encode([
                "success" => true,
                "redirect" => $this->route("dash.products")
            ]);
            return;
        }

        $data = $_POST;
        if (!$product->set($data)) {
            echo json_encode([
                "success" => false,
                "message" => message()->warning("Houve erros na validação dos dados, verifique e tente de novo.")->float()->render(),
                "errors" => $product->errors()
            ]);
            return;
        }

        $product->update();

        echo json_encode([
            "success" => true,
            "message" => message()->info("Este produto foi atualizado com sucesso.")->float()->render()
        ]);
        return;
    }

    /**
     * @return void
     */
    public function delete(): void
    {
        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT) ?? 1;
        $product = (new Product())->find("id=:id", "id={$id}")->get();

        if (!$product) {
            message()->warning("O produto que você tentou excluir não existe ou já foi excluído.")->float()->flash();
            $this->router->redirect("dash.products");
            return;
        }

        $product->delete();

        message()->info("O produto foi excluído com sucesso.")->float()->flash();
        $this->router->redirect("dash.products");
        return;
    }
}
