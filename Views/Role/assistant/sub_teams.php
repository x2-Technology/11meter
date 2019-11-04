<ul class="x2-list" id="sub_teams"  >

    <?php foreach ( $this->data->sub_teams as $index => $sub_team) { ?>

        <li class="cell ltr" data-sub-title="" >
            <a data-data="<?= Helper::JSONCleaned($this->data->leagues_view_controller_data); ?> ">
                <!--<input type="checkbox" name="sub_team[]" id="team_<?/*=$sub_team["id"];*/?>" value="<?/*=$sub_team["id"];*/?>" >
                <label for="team_<?/*=$sub_team["id"];*/?>"><?/*= $sub_team["name"]; */?></label>-->
                    <?= $sub_team["name"]; ?>
                <span data-role="league" data-league=""></span>
                <input type="hidden" name="sub_team" id="sub_team" value="<?=$sub_team["id"];?>" />
                <input type="hidden" name="league_id" id="league_id" value="" />
                <input type="hidden" name="pretty_league_name" id="pretty_league_name" value="" />
            </a>
        </li>

    <?php }?>


</ul>