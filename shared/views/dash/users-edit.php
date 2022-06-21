<?= $v->layout("layouts/dash") ?>

<?= $v->start("content") ?>

<div class="section section-user-edit">
    <div class="section-header">
        <div class="left-side">
            <h2 class="title">Editar usuário</h2>
        </div>
        <div class="right-side">
            <a class="btn btn-sm btn-info" href="<?= $router->route("dash.users") ?>">
                <?= icon_elem("arrowLeft") ?> Voltar
            </a>
        </div>
    </div>

    <div class="section-content">
        <div class="row py-3">
            <div class="col-12 col-lg-4">
                <?php if ($user->photo) : ?>
                    <img class="photo rounded-circle img-thumbnail" src="<?= $user->photo ?>" alt="<?= $user->username ?>">
                <?php else : ?>
                    <div class="photo no-photo rounded-circle img-thumbnail"><?= $user->username[0] ?></div>
                <?php endif; ?>
            </div>
            <div class="col-12 col-lg-8">
                <form action="<?= $router->route("dash.users.update", ["id" => $user->id]) ?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <?php
                        include __DIR__ . "/includes/users-form-fields.php";
                        ?>
                        <div class="col-12 form-group text-right mb-0">
                            <button class="btn btn-sm btn-outline-danger <?= icon_class("userX") ?>" data-active-icon="<?= icon_class("userX") ?>" data-alt-icon="<?= icon_class("loading") ?>" type="submit">
                                Excluir
                            </button>
                            <button class="btn btn-sm btn-info <?= icon_class("userCheck") ?>" data-active-icon="<?= icon_class("userCheck") ?>" data-alt-icon="<?= icon_class("loading") ?>" type="submit">
                                Atualizar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?= $v->end("content") ?>