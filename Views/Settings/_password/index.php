<!--<button onclick="javascript:new Layout().save('_password');">Click</button>-->
<form>
    <ul class="x2-list">

            <?php if ($this->data->show_actually_password) { ?>
                    <? $k = "password_actually"; ?>
                <li class="cell form required">
                    <label for="<?= $k; ?>" class=""><?= ucwords("derzeitiges Passwort"); ?></label>
                    <input class="" id="<?= $k; ?>" name="<?= $k; ?>" value="<?= $user[$k]; ?>" type="password"/>
                </li>
            <?php } ?>




            <? $k = "password"; ?>
        <li class="cell form required">
            <label for="<?= $k; ?>" class=""><?= ucwords($k); ?></label>
            <input class="" id="<?= $k; ?>" name="<?= $k; ?>" value="<?= $user[$k]; ?>" type="password"/>
        </li>

            <? $k = "password_again"; ?>
        <li class="cell form required">
            <label for="<?= $k; ?>" class=""><?= ucwords("Passwort wiederholen"); ?></label>
            <input class="" id="<?= $k; ?>" name="<?= $k; ?>" value="<?= $user[$k]; ?>" type="password"/>
        </li>




    </ul>

</form>
