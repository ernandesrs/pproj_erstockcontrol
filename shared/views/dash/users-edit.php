<?= $v->layout("layouts/dash") ?>

<?= $v->start("content") ?>

<div class="section section-user-edit">
    <?php

    $headerButtons = [
        t_button_link_elem("Voltar", "secondary", icon_class("arrowLeft"), route("dash.users"), icon_class("arrowLeft"), "phpButtonOne"),
    ];

    $filterFormActionLink = route("dash.users.filter");

    include __DIR__ . "/includes/page-header.php";

    ?>

    <div class="section-content">
        <div class="row py-3">
            <div class="col-12 col-lg-4 d-flex flex-column align-items-center">
                <div class="d-flex justify-content-center align-items-center photo <?= $user->photo ? "" : "no-photo" ?>">
                    <?= $user->photo ? "" : "<span>" . $user->first_name[0] . "</span>" ?>
                    <img class="img-fluid rounded-circle img-thumbnail" src="<?= thumb_nm(storage_path($user->photo)) ?>" alt="<?= $user->username ?>">
                </div>

                <!-- photo remove confirm -->
                <?php if ($user->photo) : ?>
                    <div class="pt-2 pb-1">
                        <?=
                        t_button_link_confirmation_elem(
                            "danger",
                            "Você está excluindo a foto deste usuário e não pode ser recuperada.",
                            "Excluir foto",
                            icon_class("trash"),
                            route("dash.users.photoRemove", ["user_id" => $user->id])
                        )
                        ?>
                    </div>
                <?php endif; ?>

                <div class="w-100 pt-2">
                    <div class="bg-light border rounded py-2 px-3">
                        <small>
                            <p class="mb-0">
                                <strong>Nível:</strong><span> <?= get_term("user.levels.level_{$user->level}") ?></span>
                            </p>
                            <p class="mb-0">
                                <strong>Registro:</strong> <?= date("d/m/Y H:i:s", strtotime($user->created_at)) ?>
                            </p>
                        </small>
                    </div>
                    <?php

                    $logged = (new \App\Models\Auth())->logged();

                    if ($user->id != $logged->id && $user->level < $logged->level) : ?>
                        <div class="rounded py-2 mt-2 text-center">
                            <!-- demote button -->
                            <?php if ($user->level > \App\Models\User::LEVEL_ONE) : ?>
                                <?=
                                t_button_confirmation_elem(
                                    "danger",
                                    "Você está retirando um nível deste usuário.",
                                    "Rebaixar",
                                    icon_class("userMinus"),
                                    route("dash.users.demote", ["user_id" => $user->id])
                                )
                                ?>
                            <?php endif; ?>

                            <!-- promote button -->
                            <?php if ($user->level < \App\Models\User::LEVEL_ADMIN) : ?>
                                <?=
                                t_button_confirmation_elem(
                                    "success",
                                    "Você está promovendo este usuário.",
                                    "Promover",
                                    icon_class("userPlus"),
                                    route("dash.users.promote", ["user_id" => $user->id])
                                )
                                ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <form action="<?= route("dash.users.update", ["id" => $user->id]) ?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <?php
                        include __DIR__ . "/includes/users-form-fields.php";
                        ?>
                        <div class="col-12 form-group text-right mb-0">
                            <!-- button delete confirmation -->
                            <?=
                            t_button_confirmation_elem(
                                "danger",
                                "Você está excluindo um usuário definitivamente e isso não pode ser desfeito.",
                                "Excluir",
                                icon_class("userX"),
                                route("dash.users.delete", ["id" => $user->id])
                            )
                            ?>

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


<?= $v->start("modals") ?>

<?php include __DIR__ . "/../includes/modal-confirmation.php" ?>

<?= $v->end("modals") ?>