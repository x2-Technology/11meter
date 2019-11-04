<?php
    $additional_class_for_owner = "";
    $is_my_ad = false;
    if( $this->data->my_id === $this->data->ad_details["ad_owner"] ){
        $additional_class_for_owner = "cell-vertical-bar cell-vertical-bar-blue";
        $is_my_ad = true;
    }

?>



<li class="cell <?=$additional_class_for_owner;?>"
    data-id="<?= $this->data->ad_id; ?>"
    data-group="<?= $this->data->cell_name; ?>"
    data-sort="<?=$this->data->ad_id;?>"
    id="ad_<?= $this->data->ad_id; ?>"
>

    <a data-data="<?= Helper::JSONCleaned($this->data->details_view_controller); ?>" >

                <?php
                #highlight_string(var_export($this->data, true));
                ?>

            <div class="d-table-cell" >
                <table class="">
                        <tbody>
                            <tr><td>
                                            <?= $this->data->ad_details["pretty_my_club_name_for_ad"]?>
                                            "<?= $this->data->ad_details["pretty_my_team_name_for_ad"]?> <?= $this->data->ad_details["ad_owner_team_group"]?>"</td></tr>
                            <tr><td class="font-small">
                                    <i class="icon icon-user-check mr-5"></i><?= $this->data->ad_details["pretty_owner_name_for_ad"]?> | <?= $this->data->ad_details["pretty_my_team_league_for_ad"]?>"</td></tr>
                            <tr><td class="font-mini text-secondary"><?= $this->data->ad_details["teams_suggestion"]; ?> | <?= $this->data->ad_details["league_suggestion"]; ?></td></tr>
                            <tr><td class="font-mini text-secondary">
                                            <i class="icon icon-calendar mr-5"></i><?= $this->data->ad_details["pretty_shortened_day_name"]; ?>,
                                            <?= $this->data->ad_details["pretty_ad_date"]; ?> - <i class="icon icon-watch2 mr-5"></i><?= $this->data->ad_details["pretty_ad_time"]; ?> |
                                            <?= implode(" / ", json_decode($this->data->ad_details["location_shortened_suggestions"])); ?>
                                </td></tr>
                        </tbody>

                    </table>
            </div>


            <?php if($this->data->ad_details["ad_interested"] && $is_my_ad ) : ?>
                <div class="cell-badge" data-value="<?=$this->data->ad_details["ad_interested"]?>"></div>
            <?php else: ?>

                <?php $interestedIconDisplayClass = "d-none"; ?>
                <?php if($this->data->ad_details["is_interested"] ) : ?>
                    <?php $interestedIconDisplayClass = ""; ?>
                <?php endif; ?>
                <span class="additional-icon <?=$interestedIconDisplayClass;?>" id="interested-icon">
                    <i class="icon-heart5 text-danger"></i>
                </span>

            <?php endif; ?>

        </a>
</li>