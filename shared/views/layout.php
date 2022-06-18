<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="robots" content="<?= $seo->follow ?? null ?>">
    <title><?= ucwords(CONF_APP_NAME) . ("" . !empty($seo->title) ? (" - " . $seo->title) : null) ?></title>
    <meta name="description" content="<?= $seo->description ?? null ?>">
    <link rel="canonical" href="<?= $seo->url ?? null ?>" />

    <?= $v->section("styles") ?>
</head>

<body>
    <header style="text-align: center;">
        <h1>LAYOUT</h1>
        <?= $v->section("jujubas") ?>
        <p>
            <?= $firstName ?> - <?= $lastName ?>
        </p>
    </header>
    <main>
        <?= $v->section("content") ?>
    </main>

    <?= $v->section("scripts") ?>
</body>

</html>