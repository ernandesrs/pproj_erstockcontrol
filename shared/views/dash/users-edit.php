<?= $v->layout("layouts/dash") ?>

<?= $v->start("content") ?>

<div class="section section-user-edit">
    <?php

    $headerButtons = [
        "phButtonOne" => [
            "type" => "link",
            "text" => "Voltar",
            "style" => "secondary",
            "link" => $router->route("dash.users"),
            "activeIcon" => icon_class("arrowLeft"),
            "altIcon" => icon_class("arrowLeft"),
        ]
    ];

    $filterFormActionLink = $router->route("dash.users.filter");

    include __DIR__ . "/includes/page-header.php";

    ?>

    <div class="section-content">
        <div class="row py-3">
            <div class="col-12 col-lg-4">
                <?php if ($user->photo) : ?>
                    <img class="photo rounded-circle img-thumbnail" src="<?= thumb_nm(storage_path($user->photo)) ?>" alt="<?= $user->username ?>">
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
                            <a class="btn btn-outline-danger <?= icon_class("userX") ?> jsDeleteUserButton" href="<?= $router->route("dash.users.delete", ["id" => $user->id]) ?>">
                                Excluir
                            </a>
                            <button class="btn btn-info <?= icon_class("userCheck") ?>" data-active-icon="<?= icon_class("userCheck") ?>" data-alt-icon="<?= icon_class("loading") ?>" type="submit">
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


<?= $v->start("scripts") ?>


<script>
    $(".jsDeleteUserButton").on("click", function(e) {
        e.preventDefault();
        let response = window.confirm("Você está excluindo um usuário definitivamente e isso não pode ser desfeito. Confirme para continuar.");
        if (!response) return;

        let action = $(this).attr("href");

        $.get(action, function(response) {
            if (response.redirect) {
                window.location.href = response.redirect;
                return;
            }

            addAlert($(response.message));
        }, "json");
    });
</script>


<?= $v->end("scripts") ?>