<!--<button onclick="javascript:new Layout().save('_general');">Click</button>-->
<?
    $user = $this->data["user"];

?>
<form>

    <ul class="x2-list" id="general" >

        <!--IMAGE-->
        <li class="section text-center">

            <div class="col text-center member-image">
                <img
                        src="<?= $this->data["user"]["member_image_thumb"]; ?>"
                        onerror="this.src='<?= $this->data["user"]["member_image_avatar"]; ?>'"
                        data-original-src="<?= $this->data["user"]["member_image"]; ?>"
                        data-name="<?= $this->data["user"]["final_name"]; ?>"
                        data-jump="1"
                        data-role="image-preview"
                        class="s100 member-image">
                <div class="clearfix"></div>
            </div>

            <div class="col-form-label nopadding font-size-20">
                <span class="font-bold font-size-14"><?= $this->data["user"]["final_name"]; ?></span>
                <span class="clearfix"></span>
                <span class="font-normal font-small"><?= $this->data["user"]["mobil_number"]; ?></span>
            </div>


        </li>

            <? $k = "rufname";
            $disabled = !is_null($user[$k]) ? "disabled" : ""; ?>
        <li class="cell form <?= $disabled; ?>">
            <label for="<?= $k; ?>" class=""><?= strtoupper($k); ?></label>
            <input class="" id="<?= $k; ?>" name="<?= $k; ?>" value="<?= $user[$k]; ?>" type="text" placeholder=""/>
        </li>

            <? $k = "geburtsdatum"; ?>
            <? $disabled = !is_null($user[$k])? "disabled" : ""; ?>
        <li class="cell form required <?=$disabled;?>">
            <label for="<?= $k; ?>" class=""><?= strtoupper($k); ?></label>
            <input id="<?= $k; ?>" name="<?= $k; ?>" value="<?= $user[$k]; ?>" type="date"/>
        </li>

        <!--SECTION-->
        <li class="section"></li>
            <? $k = "email"; ?>
        <li class="cell form required">
            <label for="<?= $k; ?>" class=""><?= strtoupper($k); ?></label>
            <input id="<?= $k; ?>" name="<?= $k; ?>" value="<?= $user[$k]; ?>" type="email"/>
        </li>


        <!--SECTION-->
        <li class="section">
            ADRESSE
        </li>
            <? $k = "plz"; ?>
        <li class="cell form">
            <label for="<?= $k; ?>" class=""><?= strtoupper($k); ?></label>
            <input id="<?= $k; ?>" name="<?= $k; ?>" value="<?= $user[$k]; ?>" type="tel"/>
        </li>
            <? $k = "ort"; ?>
        <li class="cell form">
            <label for="<?= $k; ?>" class=""><?= strtoupper($k); ?></label>
            <input id="<?= $k; ?>" name="<?= $k; ?>" value="<?= $user[$k]; ?>" type="text"/>
        </li>

        <!--ROLE-->
        <!--SECTION-->
        <li class="section">
            ROLLE
        </li>

            <?php

            if( $user["total_role"] < 1 ) {
                    $newBlock = "d-block";
                    $oldBlock = "d-none";
            } else {
                    $newBlock = "d-none";
                    $oldBlock = "d-block";
            } ?>
        <!-- Use display None here -->
            <?php $off_class  = $this->data["fetchUserUsedRolesWithIcon"]["disabled"] ? "disabled" : ""; ?>
            <?php $off_attr   = $this->data["fetchUserUsedRolesWithIcon"]["disabled"] ? "disabled=disabled" : ""; ?>
            <?php $his_content  = $this->data["fetchUserUsedRolesWithIcon"]["content"]; ?>
        <li class="cell">
            <!--<input
                        data-role="new-role"
                        type="button"
                        data-data-deprecated="<?/*= Helper::JSONCleaned($this->data["newRoleViewData"]); */?>"
                        data-data="<?/*= Helper::JSONCleaned($this->data["userRolesViewData"]); */?>"
                        value="ROLLE EINFÜGEN" />-->

            <a data-data="<?= Helper::JSONCleaned($this->data["userRolesViewData"]); ?>" data-role="role-management">
                <span class="<?= $oldBlock; ?>" data-content="manage"><?= $his_content; ?></span>
                <span class="<?= $newBlock; ?>" data-content="new">Rolle Management</span>
            </a>
        </li>





    </ul>

</form>








