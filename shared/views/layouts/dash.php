<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="robots" content="<?= $seo->follow ?? null ?>">
    <title>Dashboard: <?= ("" . !empty($seo->title) ? ("" . $seo->title) : null) ?></title>
    <meta name="description" content="<?= $seo->description ?? null ?>">
    <link rel="canonical" href="<?= $seo->url ?? null ?>" />
    <link rel="shortcut icon" href="<?= asset("favicon.ico") ?>" type="image/x-icon">

    <?php

    $styles = [
        "dash/custom.css",
        "bootstrap-icons.css"
    ];

    foreach ($styles as $style) {
        echo "<link rel='stylesheet' href='" . asset("css/{$style}") . "'>\n";
    }

    ?>

    <?= $v->section("styles") ?>
</head>

<body>
    <aside class="d-none d-lg-block sidebar jsDashboardSidebar">
        <div class="container-fluid">
            <div class="profile d-flex align-items-center">
                <img class="photo img-thumbnail rounded-circle" src="https://via.placeholder.com/45x45" alt="">
                <div class="info pl-2 w-100">
                    <div class="mb-0 username">Ernandes</div>
                    <div class="mb-0 d-flex">
                        <span class="level">
                            <small>Proprietário</small>
                        </span>
                        <a class="profile-link ml-auto" href="">Sair</a>
                    </div>
                </div>
            </div>

            <div class="sidebar-elements">
                <div class="element">
                    <h5 class="title">menu</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="" class="nav-link">Resumo geral</a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link">Produtos</a>
                        </li>
                    </ul>
                </div>

                <div class="element">
                    <h5 class="title">outros</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="" class="nav-link">Configurações</a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link">Perfil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= url("auth/logout") ?>" title="Encerrar minha sessão">Sair</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </aside>

    <main class="main">
        <div class="container-fluid">
            <div class="main-bar d-flex align-items-center py-2">
                <button class="btn btn-sidebar-toggler jsSidebarToggler d-lg-none bi bi-arrow-right-square" data-active-icon="bi bi-arrow-right-square" data-alt-icon="bi bi-arrow-left-square"></button>
                <div class="ml-1">
                    <a class="btn btn-sm btn-outline-secondary border-0" href="">
                        <i class="icon bi bi-bell"></i>
                    </a>
                </div>
                <div class="ml-auto">
                    <a class="btn btn-sm btn-outline-danger" href="<?= url("auth/logout") ?>">
                        <i class="icon bi bi-box-arrow-left"></i> Sair
                    </a>
                </div>
            </div>

            <?= $v->section("content") ?>
        </div>
    </main>

    <?php

    $scripts = [
        "jquery.min.js",
        "jquery-ui.min.js",
        "bootstrap.min.js",
        "dash/scripts.js",
    ];

    foreach ($scripts as $script) {
        echo "<script src='" . asset("js/{$script}") . "'></script>\n";
    }

    ?>

    <?= $v->section("scripts") ?>
</body>

</html>