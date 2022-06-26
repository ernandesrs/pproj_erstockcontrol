<?= $v->layout("layouts/dash") ?>

<?= $v->start("content") ?>

<div class="section section-overview">
    <!-- page header -->
    <?php

    $pageTitle = "Visão geral";

    include __DIR__ . "/includes/page-header.php";

    ?>

    <div class="section-content border-0 bg-transparent">
        <div class="row justify-content-center overview-boxes-list">
            <?php if (($overviewBoxes ?? null)) :
                foreach ($overviewBoxes as $boxe) : ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                        <div class="card card-body px-3 py-3 border-0 shadow d-flex flex-row align-items-center overview-boxes-item">
                            <i class="<?= $boxe->icon ?>"></i>
                            <div class="w-100">
                                <h5 class="mb-0 title">
                                    <?= $boxe->text ?>
                                </h5>
                                <div class="d-flex align-items-center">
                                    <p class="mb-0 total">
                                        <span>Total:</span> <span class="value"><?= $boxe->total ?></span>
                                    </p>
                                    <a class="btn btn-sm btn-link ml-auto" href="<?= $boxe->link ?>">
                                        Acessar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php endforeach;
            endif; ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-6 col-lg-7">
        <div class="section section-overview">
            <!-- page header -->
            <?php

            $pageTitle = "Um gráfico cairia bem aqui";
            $pageSubtitle = "Poderia ter um gráfico maneiro aqui embaixo";
            $headerButtons = [
                "phButtonOne" => [
                    "type" => "link",
                    "text" => "Mais detalhes",
                    "style" => "info btn-link",
                    "link" => $router->route("dash.products"),
                    "activeIcon" => "",
                    "altIcon" => "",
                ]
            ];

            include __DIR__ . "/includes/page-secondary-header.php";

            ?>

            <div class="section-content">
                <p class="mb-0">
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Totam, tempora fugiat architecto hic ullam ratione repellat cupiditate rem explicabo fugit, in ex provident corrupti labore ea vitae autem magnam voluptatem. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Exercitationem repudiandae accusamus inventore temporibus, molestiae aliquam eius, odio eveniet quia in consectetur deleniti perspiciatis nesciunt et adipisci quasi ad tenetur recusandae.
                </p>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-5">
        <div class="section section-overview">
            <!-- page header -->
            <?php

            $pageTitle = "Últimas atividades";
            $pageSubtitle = null;
            $headerButtons = null;

            include __DIR__ . "/includes/page-secondary-header.php";

            ?>

            <div class="section-content">
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Usuário</th>
                                <th>Status</th>
                                <th>Página</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reports ?? [] as $report) :
                                $last = $report->lastActivityReport(); ?>
                                <tr>
                                    <td><?= $report->username ?></td>
                                    <td><?= ($last->last_report ?? null) ? $last->last_report : "Nunca ativo" ?></td>
                                    <td><?= ($last->last_page ?? null) ? $last->last_page : "" ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $v->end("content") ?>