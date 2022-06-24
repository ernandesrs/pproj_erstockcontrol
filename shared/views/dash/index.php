<?= $v->layout("layouts/dash") ?>

<?= $v->start("content") ?>

<div class="section section-overview">
    <div class="section-header">
        <div class="left-side">
            <h2 class="title">
                Resumo geral
            </h2>
        </div>
    </div>

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

<div class="section section-overview">
    <div class="section-header">
        <div class="left-side">
            <h2 class="title">
                Lugar bom para um gráfico
            </h2>
            <p class="subtitle">
                Poderia ter um gráfico maneiro aqui embaixo
            </p>
        </div>

        <div class="right-side">
            <a class="btn btn-info" href="">
                Mais detalhes
            </a>
        </div>
    </div>

    <div class="section-content">
        <p class="mb-0">
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Totam, tempora fugiat architecto hic ullam ratione repellat cupiditate rem explicabo fugit, in ex provident corrupti labore ea vitae autem magnam voluptatem. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Exercitationem repudiandae accusamus inventore temporibus, molestiae aliquam eius, odio eveniet quia in consectetur deleniti perspiciatis nesciunt et adipisci quasi ad tenetur recusandae.
        </p>
    </div>
</div>


<?= $v->end("content") ?>