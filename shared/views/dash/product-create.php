<?= $v->layout("layouts/dash") ?>

<?= $v->start("content") ?>

<div class="section">
    <?php

    $headerButtons = [
        t_button_link_elem("Voltar", "secondary", icon_class("arrowLeft"), route("dash.products"), icon_class("arrowLeft"), "phpButtonOne"),
    ];

    $filterFormActionLink = route("dash.products.filter");

    include __DIR__ . "/includes/page-header.php";

    ?>

    <div class="section-content">
        <form id="productForm" action="<?= route("dash.products.store") ?>" method="post" enctype="multipart/form-data">
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


<?= $v->start("scripts") ?>
<script>

</script>
<?= $v->end("scripts") ?>