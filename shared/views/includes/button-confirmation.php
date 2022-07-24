<button class="btn <?= (($btnType ?? "button") == "button" ? "btn-outline-" : "btn-link text-") . $btnStyle ?> <?= $btnIconClass ?? null ?> jsConfirmationModalButton" data-action="<?= $btnUrlAction ?>" data-style="<?= $btnStyle ?>" data-message="<?= $btnMessage ?> Confirme para continuar.">
    <?= $btnText ?>
</button>