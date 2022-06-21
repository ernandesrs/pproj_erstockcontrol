<?= $v->layout("layouts/dash") ?>

<?= $v->start("content") ?>

<div class="section">
    <div class="section-header">
        <div class="left-side">
            <h2 class="title">Novo usuário</h2>
        </div>
        <div class="right-side">
            <a class="btn btn-sm btn-info" href="<?= $router->route("dash.users") ?>">
                <?= icon_elem("arrowLeft") ?> Voltar
            </a>
        </div>
    </div>

    <div class="section-content">
        <form action="<?= $router->route("dash.users.store") ?>" method="post" enctype="multipart/form-data">
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