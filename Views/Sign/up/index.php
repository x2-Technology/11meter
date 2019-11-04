<?php
    $termsData = Helper::JSONCleaned($this->data->termsData);

?>

<form>

    <ul class="x2-list">

        <li class="cell no-cell-border">

            <img src="/images/DFA23.png" class="mx-auto d-block" width="100">

        </li>

        <li class="cell no-cell-border">
            <span class="mx-auto d-block text-center font-large font-bold">Konto erstellen</span>
        </li>


        <li class="section no-cell-border nopadding transparent ">
            <div class="mx-auto d-block relative w-75 select">
                <label class="text-info font-mini nopadding nomargin" for="<?= $v; ?>">Rolle</label>
            </div>
        </li>

        <li class="cell no-cell-border nopadding-l nopadding-r pt-10">

                <?php $v = "teamrolle"; ?>
            <div class="mx-auto relative w-75 select form-control-underline nopadding-l nopadding-r">
                <select required name="<?= $v ?>" id="<?= $v; ?>" >

                        <?php foreach ($this->data->maybelistedforappregister as $key => $value) { ?>
                            <option value="<?= $key; ?>"><?= $value["name"]; ?></option>
                        <?php } ?>

                </select>
            </div>

        </li>


            <?php $v = "vorname"; ?>
        <li class="section no-cell-border nopadding mt-10 transparent">
            <div class="mx-auto d-block relative w-75 select">
                <label class="text-info font-mini nopadding nomargin" for="<?= $v; ?>">Vorname</label>
            </div>
        </li>
        <li class="cell no-cell-border nopadding-l nopadding-r pt-10">
            <div class="mx-auto relative w-75">
                <input type="text" required name="<?= $v; ?>" id="<?= $v; ?>"
                       class="form-control-underline box-with-border-radius-none background-primary text-color-primary nopadding"
                       value="Solomon" placeholder="Vorname">
            </div>

        </li>


        <li class="section no-cell-border nopadding mt-10 transparent">
            <div class="mx-auto d-block relative w-75 select">
                <label class="text-info font-mini nopadding nomargin" for="<?= $v; ?>">Nachname</label>
            </div>
        </li>

        <li class="cell no-cell-border nopadding-l nopadding-r pt-10">

                <?php $v = "nachname"; ?>
            <div class="mx-auto d-block relative w-75">
                <input type="text" required name="<?= $v; ?>" id="<?= $v; ?>"
                       class="form-control-underline box-with-border-radius-none background-primary text-color-primary nopadding"
                       value="Topal" placeholder="Nachname">
            </div>

        </li>


        <li class="section no-cell-border nopadding mt-10 transparent">
            <div class="mx-auto d-block relative w-75 select">
                <label class="text-info font-mini nopadding nomargin" for="<?= $v; ?>"><i class="icon icon-info2"></i> Handynummer erfolgreich mit Ländervorwahl</label>
            </div>
        </li>

        <li class="cell no-cell-border nopadding-l nopadding-r pt-10">

                <?php $v = "mobil_number"; ?>
            <div class="mx-auto d-block relative w-75">

                <input type="tel" required name="<?= $v; ?>" id="<?= $v; ?>"
                       class="form-control-underline box-with-border-radius-none background-primary text-color-primary nopadding"
                       value="004915228763036" placeholder="Handynummer">
            </div>

        </li>



        <li class="cell pos-relative no-cell-border nopadding-l nopadding-r pt-10">

            <? $v = "terms_and_conditions"; ?>
            <div class="mx-auto d-block relative w-75">
                <!--<div class="material-switch float-right">
                    <input id="<?/*= $v; */?>" name="<?/*= $v; */?>" type="checkbox" >
                    <label for="<?/*= $v; */?>" class="label-primary"></label>
                </div>-->

                <div class="x2-check-option">
                    <div class="option">
                        <input id="<?= $v; ?>" name="<?= $v; ?>" type="checkbox" >
                        <label for="<?= $v; ?>" class="text-primary float-left"></label>
                    </div>
                    <label class="label" for="<?= $v; ?>" >Ich habe <a id="terms_view" data-data="<?= $termsData; ?>" class="text-primary font-bold text-underline">AGB</a> gelesen und akzeptiere ich</label>
                </div>

            </div>

        </li>












        <li class="cell no-cell-border">

            <div class="mx-auto d-block relative w-50">
                <a class="wobbles btn badge-info full-width" id="signup_save">
                    <span class="mx-auto d-block">Register</span>
                </a>
            </div>
        </li>

        <li class="cell no-cell-border">

            <div class="mx-auto d-block relative w-50 text-center">
                <label class="mx-auto d-block">Zurück zum
                    <a id="backtologin"  class="text-primary">
                        Login
                    </a>
                </label>

            </div>
        </li>


    </ul>

</form>
