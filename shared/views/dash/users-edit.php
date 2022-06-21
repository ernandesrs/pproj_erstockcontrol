<?= $v->layout("layouts/dash") ?>

<?= $v->start("content") ?>

<div class="section">
    <div class="section-header">
        <div class="left-side">
            <h2 class="title">Editar usuário</h2>
        </div>
        <div class="right-side">
            <a class="btn btn-sm btn-info" href="<?= $router->route("dash.users") ?>">
                <?= icon_elem("arrowLeft") ?> Voltar
            </a>
        </div>
    </div>

    <div class="section-content">
        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Optio soluta non dignissimos consequatur alias facere sed amet atque pariatur, praesentium commodi eligendi at ducimus animi culpa odio, tempore consectetur nisi. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Perspiciatis molestias repudiandae autem quae obcaecati inventore doloremque, sed corporis possimus illum sunt animi. Aperiam, eum neque harum iste tenetur officiis voluptate!
    </div>
</div>


<?= $v->end("content") ?>