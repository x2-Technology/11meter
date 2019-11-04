<?php
#highlight_string(var_export($this->data, true));
?>
<ul class="x2-list">

    <li class="cell no-cell-border">

        <img src="/images/DFA23.png" class="mx-auto d-block" width="100">

    </li>

    <li class="cell no-cell-border">
        <?php
            $title = !is_null($this->data["title"]) ? $this->data["title"] : "Kontowiederherstellung";
        ?>
        <span class="mx-auto d-block text-center font-large font-bold"><?= $title; ?></span>
    </li>

    <li class="cell no-cell-border">
        <div class="mx-auto d-block relative w-75 text-center font-normal">
            So können wir bestätigen, dass dieses Nummer wirklich Ihnen gehört
        </div>
    </li>

    <li class="cell no-cell-border">

        <div class="mx-auto d-block relative w-75">

                <?php $key = "mobil_number"; ?>
            <div class="font-small font-bold text-center full-width"><?= $this->data[$key]; ?></div>
        </div>

    </li>

    <li class="cell no-cell-border">

        <div class="mx-auto d-block relative w-75">

            <label class="text-info font-mini">Code eingeben</label>

                <?php $key = "mobil_number"; ?>
            <input type="hidden" required name="<?= $key; ?>" id="<?= $key; ?>" value="<?= $this->data[$key]; ?>" placeholder="Code">
                <?php $key = "mobil_confirmation"; ?>
            <input type="tel" maxlength="15" minlength="15" required name="<?= $key; ?>" id="<?= $key; ?>" class="pin form-control-underline box-with-border-radius-none background-primary text-center" value="">



        </div>
 
    </li>

    <li class="cell no-cell-border">

        <div class="mx-auto d-block relative w-50">
            <a class="wobbles btn badge-info full-width" id="confirmation" data-redirect="<?= NULL; ?>">
                <span class="mx-auto d-block">Weiter</span>
            </a>
        </div>
    </li>

</ul>