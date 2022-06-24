<?= $v->layout("layouts/dash") ?>

<?= $v->start("content") ?>

<div class="section products-section">
    <div class="section-header">
        <div class="left-side">
            <h2 class="title">Listagem de produtos</h2>
        </div>
        <div class="right-side">
            <a class="btn btn-info" href="<?= $router->route("dash.products.create") ?>">
                <?= icon_elem("plusSquare") ?> Novo produto
            </a>
        </div>
    </div>

    <div class="section-content py-3">
        <div class="table-responsive">
            <table class="table table-sm table-hover table-borderless rounded">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Modo de compra</th>
                        <th>Modo de venda</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($products ?? null) :
                        /** @var \App\Models\Product $product */
                        foreach ($products as $product) : ?>
                            <tr>
                                <td>
                                    #<?= $product->id ?>
                                </td>
                                <td>
                                    <?= $product->name ?>
                                </td>
                                <td>
                                    <?= $product::PURCHASE_MODES_NAME[$product->purchase_mode] ?>
                                </td>
                                <td>
                                    <?= $product::SALE_MODES_NAME[$product->sale_mode] ?>
                                </td>
                                <td>
                                    <a class="btn btn-info" href="<?= $router->route("dash.products.edit", ["id" => $product->id]) ?>">
                                        <?= icon_elem("pencilSquare") ?>
                                    </a>
                                    <button class="btn btn-outline-danger">
                                        <?= icon_elem("trash") ?>
                                    </button>
                                </td>
                            </tr>
                    <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="section-footer pt-3">
        <!-- pagination -->
        <?php include __DIR__ . "/includes/pagination.php" ?>
    </div>
</div>


<?= $v->end("content") ?>