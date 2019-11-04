<li class="cell"
    data-id="<?= $this->data->ad_id; ?>"
    data-group="<?= $this->data->cell_name; ?>"
    data-sort="<?=$this->data->ad_id;?>"
    id="ad_<?=$this->data->ad_id;?>"
>

        <a data-data="<?= Helper::JSONCleaned($this->data->details_view_controller); ?>" class="">
                <?php #highlight_string(var_export($this->data->details_view_controller, true));; ?><!-- <?/*= $this->data->display_name; */?> <span class="font-mini" id="season"><?/*=$season_part;*/?></span>-->


            <div>
                <table class="table-sm w-100 h-100 ad-private">
                    <tbody>
                    <tr>
                        <td rowspan="4" class="nopadding" style="min-width: 20px;">

                                <?php if( !is_null($this->data->ad_details["last_message_sender"]) ) { ?>
                                    <i class="icon <?= $this->data->ad_details["message_way_icon"]; ?>"></i>
                                <?php } else { ?>

                                <?php } ?>

                        </td>


                        <td class="text-success font-mini">
                                <?= $this->data->ad_details["pretty_shortened_day_name"]; ?>,
                                <?= $this->data->ad_details["pretty_ad_date"]; ?>,
                                <?= $this->data->ad_details["pretty_ad_time"]; ?>,
                                <?= $this->data->ad_details["pretty_my_team_name_for_ad"]?> <?= $this->data->ad_details["pretty_my_team_group_name_for_ad"]?>
                        </td>

                        <td rowspan="4" class="nopadding">

                                <i class="font-size-18 icon icon-circle2  <?= $this->data->ad_details["status_color"]; ?>"></i>

                        </td>
                    </tr>

                    <tr><td class="font-small"><?= $this->data->ad_details["pretty_my_club_name"]?></td></tr>
                    <tr><td class="font-small"><?= $this->data->ad_details["pretty_opponent_club_name"]?></td></tr>
                    <?php if( !is_null($this->data->ad_details["last_message_sender"]) ) { ?>
                        <tr>
                            <td class="nopadding align-top">

                                <div class="d-sm-table-row w-50">
                                    <div class="text-ellipsis font-mini font-italic">
                                        <span class="text-info"><?= $this->data->ad_details["last_message_sender"]?></span> :<?= $this->data->ad_details["last_message_sender_text"]?>
                                    </div>



                            </td>
                        </tr>


                    <?php }?>

                    </tbody>


                </table>
            </div>



        </a>


        <!--<label>Check Me</label>
        <div class="switch">
            <input id="x" type="checkbox" name="switch" checked="checked" />
            <label for="x" class="label-success"></label>
        </div>-->

</li>