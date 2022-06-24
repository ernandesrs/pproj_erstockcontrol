<?= $v->layout("layouts/dash") ?>

<?= $v->start("content") ?>

<div class="section">
    <div class="section-header">
        <div class="left-side">
            <h2 class="title">Novo produto</h2>
        </div>
        <div class="right-side">
            <a class="btn btn-info" href="<?= $router->route("dash.products") ?>">
                <?= icon_elem("arrowLeft") ?> Voltar
            </a>
        </div>
    </div>

    <div class="section-content">
        <form action="<?= $router->route("dash.products.store") ?>" method="post" enctype="multipart/form-data">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                    <?php include __DIR__ . "/includes/products-form-fields.php" ?>

                    <div class="form-group py-2 text-right">
                        <button class="btn btn-success <?= icon_class("checkLg") ?>" data-active-icon="<?= icon_class("checkLg") ?>" data-alt-icon="<?= icon_class("loading") ?>">
                            Cadastrar agora
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<?= $v->end("content") ?>