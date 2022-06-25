<div class="section-header row">
    <div class="left-side col-12 col-lg-6 d-flex align-items-center">
        <h2 class="title"><?= $pageTitle ?? $seo->title ?></h2>

        <?php if ($headerButtonNewLink ?? null) : ?>
            <a class="btn btn-info ml-auto ml-lg-2" href="<?= $headerButtonNewLink ?>">
                <?= icon_elem("plusLg") ?> <?= $headerButtonNewText ?>
            </a>
        <?php endif; ?>
    </div>

    <div class="right-side col-12 col-lg-6 d-flex align-items-center mt-3 mt-lg-0">
        <?php if ($filterFormActionLink ?? null) : ?>
            <div class="filter-bar w-100">
                <form action="<?= $filterFormActionLink ?>" method="post">
                    <div class="d-flex justify-content-end align-items-center">
                        <!-- order input -->
                        <div class="form-group ml-2">
                            <label for="order">Data de criação:</label>
                            <select class="form-control form-control-sm text-center" name="order" id="order">
                                <option value="none">Ordem</option>
                                <option value="asc" <?= input_value("order", $_GET) == "asc" ? "selected" : null ?>>Crescente</option>
                                <option value="desc" <?= input_value("order", $_GET) == "desc" ? "selected" : null ?>>Decrescente</option>
                            </select>
                        </div>

                        <!-- search input -->
                        <div class="form-group ml-2">
                            <label for="search">Buscar:</label>
                            <input class="form-control form-control-sm text-center" type="search" name="search" id="search" placeholder="Buscar" value="<?= input_value("search", $_GET) ?>">
                        </div>

                        <!-- submit button -->
                        <button class="btn bg-transparent <?= icon_class("funnel") ?>" data-active-icon="<?= icon_class("funnel") ?>" data-alt-icon="<?= icon_class("loading") ?>"></button>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>