<?= $v->layout("layouts/front") ?>

<?= $v->start("content") ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6">
            <h1 class="text-center">Front do Site</h1>
            <div class="card card-body">
                <div class="d-flex justify-content-center">
                    <a href="<?= $router->route("front.front") ?>">Início</a>
                    <span class="text-light-dark px-3"> | </span>
                    <a href="<?= $router->route("dash.dash") ?>">Painel</a>
                    <span class="text-light-dark px-3"> | </span>
                    <a href="<?= $router->route("auth.login") ?>">Login</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $v->end("content") ?>