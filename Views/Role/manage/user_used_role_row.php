
<li class="cell"
    data-id="<?= $this->data->user_used_role_id; ?>"
    data-sub-title="<?=$this->data->club_name;?>"
    data-group="<?= $this->data->display_name; ?>"
    data-sort="<?=$this->data->season;?>"

>

    <?php
        $season_part = "";
        if( !is_null($this->data->season) ){
            $season_part = "({$this->data->season})";
        }
    ?>
    
    <a data-data="<?= Helper::JSONCleaned($this->data->roleViewControllerData); ?>" >
            <?= $this->data->display_name; ?> <span class="font-mini" id="season"><?=$season_part;?></span>
    </a>


    <!--<label>Check Me</label>
    <div class="switch">
        <input id="x" type="checkbox" name="switch" checked="checked" />
        <label for="x" class="label-success"></label>
    </div>-->

</li>