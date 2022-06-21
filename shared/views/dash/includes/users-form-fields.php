<?php
function getValue(string $name, $user)
{
    if (!$user) return null;
    return $user->$name ?? null;
}
?>
<div class="col-12 col-md-6">
    <div class="form-group">
        <label for="first_name">Nome:</label>
        <input class="form-control" type="text" name="first_name" id="first_name" value="<?= getValue("first_name", $user ?? null) ?>">
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="form-group">
        <label for="last_name">Sobrenome:</label>
        <input class="form-control" type="text" name="last_name" id="last_name" value="<?= getValue("last_name", $user ?? null) ?>">
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="form-group">
        <label for="email">Email:</label>
        <input class="form-control" type="email" name="email" id="email" value="<?= getValue("email", $user ?? null) ?>">
    </div>
</div>

<div class="col-12 col-md-3">
    <div class="form-group">
        <label for="username">Usuário:</label>
        <input class="form-control" type="text" name="username" id="username" value="<?= getValue("username", $user ?? null) ?>">
    </div>
</div>

<div class="col-12 col-md-3">
    <div class="form-group">
        <label for="gender">Gênero:</label>
        <select class="form-control" name="gender" id="gender">
            <option value="n">Escolha</option>
            <option value="m" <?= getValue("gender", $user ?? null) == "m" ? "selected" : null ?>>Masculino</option>
            <option value="f" <?= getValue("gender", $user ?? null) == "f" ? "selected" : null ?>>Feminino</option>
        </select>
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="form-group">
        <label for="password">Senha:</label>
        <input class="form-control" type="password" name="password" id="password">
    </div>
</div>

<div class="col-12 col-md-6">
    <div class="form-group">
        <label for="password_confirm">Confirmar senha:</label>
        <input class="form-control" type="password" name="password_confirm" id="password_confirm">
    </div>
</div>