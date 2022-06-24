<div class="form-row py-3">
    <div class="col-12">
        <div class="form-group">
            <label for="name">Nome do produto:</label>
            <div class="input-group mb-2">
                <input type="text" class="form-control" id="name" name="name" value="<?= input_value("name", $product ?? null) ?>">
                <div class="input-group-prepend">
                    <div class="input-group-text"></div>
                </div>
            </div>
        </div>
    </div>

    <?php
    $purchaseModes = \App\Models\Product::PURCHASE_MODES;
    $purchaseModesNames = \App\Models\Product::PURCHASE_MODES_NAME;

    $saleModes = \App\Models\Product::SALE_MODES;
    $saleModesNames = \App\Models\Product::SALE_MODES_NAME;
    ?>
    <div class="col-12 col-sm-6">
        <div class="form-group">
            <label for="purchase_mode">Modo de compra:</label>
            <select class="form-control" name="purchase_mode" id="purchase_mode">
                <?php foreach ($purchaseModes as $pm) : ?>
                    <option value="<?= $pm ?>" <?= input_value("purchase_mode", $product ?? null) == $pm ? "selected" : null ?>>
                        <?= $purchaseModesNames[$pm] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="col-12 col-sm-6">
        <div class="form-group">
            <label for="sale_mode">Modo de venda:</label>
            <select class="form-control" name="sale_mode" id="sale_mode" value="<?= input_value("sale_mode", $product ?? null) ?>">
                <?php foreach ($saleModes as $sm) : ?>
                    <option value="<?= $sm ?>" <?= input_value("sale_mode", $product ?? null) == $pm ? "selected" : null ?>>
                        <?= $saleModesNames[$sm] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>