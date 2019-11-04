<div class="view-body">
    <form>

        <?php
                // Database'e Dikkat Licence ve Licence gultig yazilmiyor
                #highlight_string(var_export($this->data->user_used_role, true));
                #highlight_string(var_export($this->data->user_used_role, true));
        ?>
        
        <?php if( is_null( $this->data->user_used_role_id ) ) { ?>

        <!--ROLE SELECT -->
        <ul class="x2-list">

            <li class="section">
                ROLLE
            </li>

            <!--CELL SELECT-->
            <li class="cell select">

                <select name="role" id="role" >
                    <option value="0">ROLLE</option>
                        <?php if( count($this->data->roles) ) { ?>

                                <?php foreach ($this->data->roles as $index => $role) { ?>

                                        <?php $selectable = !is_null($role["selectable"]) && !$role["selectable"] ? "disabled" : ""; ?>

                                        <option value="<?= $index; ?>" <?= $selectable; ?>><?= $role["name"]; ?></option>


                                <?php }?>

                        <?php }?>
                </select>

            </li>

        </ul>

        <?php } else { ?>


                <!--* BU SEKILDE OLACAK ROLUN NE OLDUGU
                    * KULLANICININ KULLANDIGI DEGIL
                    -->
                <input type="hidden" name="role" id="role" value="<?= $this->data->role; ?>" />

        <?php } ?>





        <!--DETAILS-->
        <ul class="x2-list" id="profile" >

            <?php if( is_null( $this->data->user_managed_role ) ) { ?>

                <li class="section mb-30">
                    <span class="font-mini font-normal font-italic ">
                        Bitte wählen Sie Rolle und<br />
                        Beachten Sie, flicht felder kann nicht leer sein!
                    </span>
                </li>

            <?php } else { ?>

                <?= $this->data->user_managed_role; ?>

            <?php }  ?>


        </ul>


    </form>
</div>


<!--<div class="view-footer">
    <?php /*if( is_null($this->data->user_used_role_id )) { */?>
        <input type="button" id="role_add" class="text-primary x2-mobile-button" value="Speichern" disabled />
    <?php /*} else { */?>

        <input type="button" id="role_edit" class="text-primary x2-mobile-button" value="Speichern" />
        <input type="button" id="role_delete" class="text-danger x2-mobile-button" value="Löschen" data-role="role-delete" data-user-used-role-id="<?/*= $this->data->user_used_role_id; */?>" />

    <?php /*} */?>
</div>-->

<div class="view-footer">
        <?php if( is_null($this->data->user_used_role_id )) { ?>
            <input type="button" id="role_add" class="text-primary x2-mobile-button" value="Speichern" disabled />
        <?php } else { ?>

                <?php if(!$this->data->user_used_role["role_locked"]) { ?>
                <input type="button" id="role_edit" class="text-primary x2-mobile-button" value="Speichern" />
                <?php } ?>

                <?php if(
                        $this->data->user_used_role["confirmed_by_club"] == CONFIRMATION_TYPE::TYPE_REJECTED ||
                        $this->data->user_used_role["confirmed_by_club"] == CONFIRMATION_TYPE::TYPE_NOT_CHECKED ||
                        is_null($this->data->user_used_role["confirmed_by_club"])
                ) { ?>
                <input type="button" id="role_delete" class="text-danger x2-mobile-button" value="Löschen" data-role="role-delete" data-user-used-role-id="<?= $this->data->user_used_role_id; ?>" />
                <?php } ?>
        <?php } ?>
</div>

