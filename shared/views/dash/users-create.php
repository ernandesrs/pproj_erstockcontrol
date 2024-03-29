<?= $v->layout("layouts/dash") ?>

<?= $v->start("content") ?>

<div class="section">
    <?php

    $headerButtons = [
        t_button_link_elem("Voltar", "secondary", icon_class("arrowLeft"), route("dash.users"), icon_class("arrowLeft"), "phpButtonOne"),
    ];

    $filterFormActionLink = route("dash.users.filter");

    include __DIR__ . "/includes/page-header.php";

    ?>

    <div class="section-content">
        <form action="<?= route("dash.users.store") ?>" method="post" enctype="multipart/form-data">
            <div class="row py-3">
                <?php
                include __DIR__ . "/includes/users-form-fields.php";
                ?>
                <div class="col-12 form-group text-right mb-0">
                    <button class="btn btn-success <?= icon_class("userPlus") ?>" data-active-icon="<?= icon_class("userPlus") ?>" data-alt-icon="<?= icon_class("loading") ?>" type="submit">
                        Cadastrar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


<?= $v->end("content") ?>