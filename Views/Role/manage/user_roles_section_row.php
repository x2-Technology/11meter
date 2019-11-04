<? /* This file for user_used_roles_icon_view.php ( This is a parent item )*/ ?>
<?php $is_disabled  = $this->data->disabled; ?>
<?php $his_content  = $this->data->content; ?>
<li class="cell <?= $is_disabled; ?>" <?= $is_disabled; ?> data-role="user-roles-row" >
        <a data-data="<?= Helper::JSONCleaned($this->data->userRolesViewData); ?>" data-role="user-roles">
                <?= $his_content; ?>
        </a>
</li>