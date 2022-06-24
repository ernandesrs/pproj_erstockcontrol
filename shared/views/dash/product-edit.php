<?= $v->layout("layouts/dash") ?>

<?= $v->start("content") ?>

<div class="section">
    <div class="section-header">
        <div class="left-side">
            <h2 class="title">Editar produto</h2>
        </div>
        <div class="right-side">
            <a class="btn btn-info" href="<?= $router->route("dash.products") ?>">
                <?= icon_elem("arrowLeft") ?> Voltar
            </a>
        </div>
    </div>

    <div class="section-content">
        <form id="productForm" action="<?= $router->route("dash.products.update") ?>" method="post" enctype="multipart/form-data">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                    <?php include __DIR__ . "/includes/products-form-fields.php" ?>

                    <div class="form-group py-2 text-right">
                        <a class="btn btn-danger jsDeleteButtonAlert" href="<?= $router->route("dash.products.delete", ["id" => $product->id]) ?>">
                            <?= icon_elem("trash") ?> Excluir
                        </a>
                        <button class="btn btn-info <?= icon_class("checkLg") ?>" data-active-icon="<?= icon_class("checkLg") ?>" data-alt-icon="<?= icon_class("loading") ?>">
                            Atualizar agora
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<?= $v->end("content") ?>