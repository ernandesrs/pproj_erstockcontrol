<div class="section-header">
    <div class="left-side">
        <h2 class="title"><?= $pageTitle ?? $seo->title ?></h2>
        <?php if ($pageSubtitle ?? null) : ?>
            <p class="mb-0"><?= $pageSubtitle ?></p>
        <?php endif; ?>
    </div>

    <div class="left-right ml-auto">
        <?php $i = 0;
        foreach ($headerButtons ?? [] as $headerButton) : ?>
            <?php if ($headerButton["type"] == "link") : ?>
                <a class="btn btn-<?= $headerButton["style"] ?> <?= $i == 0 ? "ml-auto" : "ml-2" ?> ml-lg-2 <?= $headerButton["id"] ?>" href="<?= $headerButton["link"] ?>" id="<?= $headerButton["id"] ?>">
                    <i class="icon <?= $headerButton["activeIcon"] ?>"></i> <?= $headerButton["text"] ?>
                </a>
            <?php else : ?>
                <button class="btn btn-<?= $headerButton["style"] ?> <?= $i == 0 ? "ml-auto" : "ml-2" ?> ml-lg-2 <?= $headerButton["id"] ?> <?= $headerButton["activeIcon"] ?>" data-active-icon="<?= $headerButton["activeIcon"] ?>" data-alt-icon="<?= $headerButton["altIcon"] ?>" data-action="<?= $headerButton["link"] ?>" id="<?= $headerButton["id"] ?>">
                    <?= $headerButton["text"] ?>
                </button>
            <?php endif; ?>
        <?php $i++;
        endforeach; ?>
    </div>
</div>