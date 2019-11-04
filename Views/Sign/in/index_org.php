<ul class="x2-list">

    <li class="cell no-cell-border">

        <img src="/images/DFA23.png" class="mx-auto d-block" width="100">

    </li>
    <li class="cell no-cell-border">
        <span class="mx-auto d-block text-center font-large font-bold">Hallo</span>
    </li>

        <?php $v="username"; ?>
    <li class="cell no-cell-border">
        <div class="mx-auto d-block relative w-75">
            <input type="text" required name="<?=$v;?>" id="<?=$v;?>" class="form-control-underline box-with-border-radius-none background-primary text-color-primary" value="Marcel_Kilicalp" placeholder="Nutzername">
        </div>
    </li>

        <?php $v="password"; ?>
    <li class="cell no-cell-border">
        <div class="mx-auto d-block relative w-75">
            <input type="password" name="<?=$v;?>" id="<?=$v;?>" required class="form-control-underline box-with-border-radius-none background-primary text-color-primary" value="123" placeholder="Kennwort">
        </div>
    </li>
    <li class="cell no-cell-border">
        <div class="col-sm-12">
            <div class="mx-auto d-block relative w-50"><a class="wobbles btn badge-info full-width" id="login"><span class="mx-auto d-block">Login</span></a></div>
        </div>

    </li>
    <li class="cell no-cell-border">

        <div class="mx-auto d-block relative w-50 text-center">
            <label class="mx-auto d-block">Keine konto ?
                <a href="<?= Config::BASE_URL . "/Sign/up/index"; ?>" >
                    neu anmelden
                </a>
            </label>

        </div>
    </li>


</ul>

