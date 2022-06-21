<?= $v->layout("layouts/dash") ?>

<?= $v->start("content") ?>

<div class="section">
    <div class="section-header">
        <div class="left-side">
            <h2 class="title">Listagem de usuários</h2>
        </div>
        <div class="right-side">
            <a class="btn btn-sm btn-info" href="<?= $router->route("dash.users.create") ?>">
                <?= icon_elem("userPlus") ?> Novo usuário
            </a>
        </div>
    </div>

    <div class="section-content">
        <div class="row justify-content-start list-items">
            <?php if (!$users) : ?>
                <p class="h5 text-center py-3 mb-0">
                    Nenhum usuário para listar
                </p>
                <?php else :
                foreach ($users as $user) : ?>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="card card-body border-0 d-flex flex-column justify-content-center align-items-center list-item user">
                            <?php if ($user->photo) : ?>
                                <img class="photo rounded-circle img-thumbnail" src="<?= $user->photo ?>" alt="<?= $user->username ?>">
                            <?php else : ?>
                                <div class="photo no-photo rounded-circle img-thumbnail"><?= $user->username[0] ?></div>
                            <?php endif; ?>
                            <div class="text-center pt-2 pb-3">
                                <p class="mb-0 h2 username"><?= $user->username ?></p>
                                <p class="mb-0 h5 fullname"><?= $user->first_name . " " . $user->last_name ?></p>
                                <p class="mb-0 h5 email"><?= $user->email ?></p>
                            </div>
                            <a class="btn btn-sm btn-info" href="<?= $router->route("dash.users.edit", ["id" => $user->id]) ?>">
                                <?= icon_elem("pencilSquare") ?> Editar
                            </a>
                        </div>
                    </div>
            <?php endforeach;
            endif; ?>
        </div>
    </div>
</div>


<?= $v->end("content") ?>