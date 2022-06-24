<?php if ($pagination ?? null) : ?>
    <div class="d-flex justify-content-end">
        <ul class="pagination">
            <?php for ($i = 0; $i < $pagination->pages; $i++) : ?>
                <li class="page-item <?= $pagination->currentPage == ($i + 1) ? "disabled" : null ?>">
                    <a class="page-link" href="<?= $router->route($router->currentRouteName(), ["page" => ($i + 1)]); ?>" tabindex="-1">
                        <?= ($i + 1) ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </div>
<?php endif; ?>