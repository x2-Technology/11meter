<?php
    $signupData = Helper::JSONCleaned($this->data->signup);
    $forgotPasswordData = Helper::JSONCleaned($this->data->forgotPassword);
    // highlight_string(var_export($this->data, true));
?>
<ul class="x2-list">

    <li class="cell no-cell-border">

        <img src="/images/DFA23.png" class="mx-auto d-block" width="100">

    </li>
    <li class="cell no-cell-border nopadding">
        <span class="mx-auto d-block text-center font-large font-bold">Passwort ändern</span>
    </li>

    <li class="cell no-cell-border">
        <div class="mx-auto d-block relative w-75 text-center font-normal">
            Erstellen Sie ein neues, starkes Passwort, das Sie einfach erinnern können
        </div>
    </li>



    <li class="cell no-cell-border">

        <div class="mx-auto d-block relative w-75">

            <label class="text-info font-mini"><i class="icon icon-info2"></i> Passwort</label>

                <?php $key = "mobil_number"; ?>
            <input type="hidden" required name="<?= $key; ?>" id="<?= $key; ?>" value="<?= $this->data[$key]; ?>" >
                <?php $key = "password"; ?>

            <div class="row">


                <div class="col">

                    <input type="password" id="password" required class="password form-control-underline box-with-border-radius-none background-primary text-center" value="">


                </div>






            </div>
        </div>

    </li>


    <li class="cell no-cell-border">
        <div class="col-sm-12">
            <div class="mx-auto d-block relative w-50"><a class="wobbles btn badge-info full-width" id="save_password_number"><span class="mx-auto d-block">ändern</span></a></div>
        </div>

    </li>




</ul>

