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
    <link rel="stylesheet" href="<?= asset("/css/dash/custom.css") ?>">
    <link rel="stylesheet" href="<?= asset("/css/bootstrap-icons.css") ?>">

    <?= $v->section("styles") ?>
</head>

<body>
    <div class="main-wrapp">
        <aside class="sidebar">
        </aside>

        <main class="main">
            <?= $v->section("content") ?>
        </main>
    </div>

    <script src="<?= asset("/js/dash/scripts.js") ?>"></script>
    <?= $v->section("scripts") ?>
</body>

</html>