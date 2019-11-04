<li class="cell" data-sub-title="<?= $this->data->team_group["name"] . ".Mannschaft" ; ?> (<?= $this->data->team_league["name"]; ?>)" >
    <?php
        #highlight_string(var_export($this->data, true));
    ?>

    <?php if( $this->data->role_locked ) { ?>
        <a>
    <?php } else { ?>
        <a data-data="<?= Helper::JSONCleaned($this->data->dfbConnect); ?>" >
    <?php }  ?>

        <label>
            <?= $this->data->team["name"]; ?>
            <input type="hidden" name="team[]" value="<?=$this->data->team["id"]; ?>" >
            <input type="hidden" name="team_group[]" value="<?=$this->data->team_group["id"];?>" >
            <input type="hidden" name="team_league[]" value="<?=$this->data->team_league["id"];?>" >
            <input type="hidden" name="team_dfb_name[]" value="<?=$this->data->team_dfb_name;?>" >
            <input type="hidden" name="team_dfb_link[]" value="<?=$this->data->team_dfb_link;?>" >

        </label>

        <?php
            $connected      = !is_null($this->data->team_dfb_link) && !empty($this->data->team_dfb_link) ? "success" : "danger";
            $connectedIcon  = !is_null($this->data->team_dfb_link) && !empty($this->data->team_dfb_link) ? "link3" : "unlink3";
            $isVIP          = !is_null($this->data->_code["licence_icon"]) && !empty($this->data->_code["licence_icon"]) ? '<span class="additional-icon"><i class="text-info icon ' . $this->data->_code["licence_icon"] . '"></i></span>'  : "";
        ?>

        <span class="additional-icon" id="dfb_connect">
            <i class="icon icon-<?=$connectedIcon;?> text-<?=$connected;?>"></i>
        </span>

        <?= $isVIP; ?>
    </a>
</li>