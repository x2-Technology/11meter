<?php $d = $this->data->ad_data; #highlight_string(var_export($d, true)); ?>
<li class="cell">

        <table class="table-sm w-100">
                <tbody>
                <tr>
                      <td class="text-center font-bold nopadding" colspan="3"><?= $d["ad_group"]; ?></td>
                </tr>
                <tr>
                        <td class="text-center" colspan="3">
                                <?= $d["pretty_ad_date"]; ?> - <?= $d["pretty_ad_time"]; ?>
                        </td>
                </tr>


                <?php

                    $owner_status_icon_with_color   = "icon-question3 text-warning";
                    $partner_status_icon_with_color = "icon-question3 text-warning";


                    if( !is_null($d["owner_accepted_at"]) ){
                        $owner_status_icon_with_color = "icon-thumbs-up3 text-success";
                    }

                    if( !is_null($d["owner_declined_at"]) ){
                            $owner_status_icon_with_color = "icon-thumbs-down3 text-danger";
                    }

                    if( !is_null($d["accepted_at"]) ){
                            $partner_status_icon_with_color = "icon-thumbs-up3 text-success";
                    }

                    if( !is_null($d["declined_at"]) ){
                            $partner_status_icon_with_color = "icon-thumbs-down3 text-danger";
                    }







                ?>


                <tr>
                    <td class="nopadding">
                        <div class="row">
                            <div class="col-5 text-center font-size-18"><i class="icon <?=$owner_status_icon_with_color;?> "></i></div>
                            <div class="col-2"></div>
                            <div class="col-5 text-center font-size-18"><i class="icon <?=$partner_status_icon_with_color;?> "></i></div>
                        </div>
                    </td>
                </tr>


                <tr>
                        <td>
                                <div class="row">
                                        <div class="col-5 text-center">
                                                <span class="font-bold">
                                                        <?= $d["pretty_my_club_name"]; ?>
                                                </span>
                                                <br />
                                                <?= $d["pretty_my_team_name_for_ad"]; ?>
                                            <br />
                                                <?= $d["pretty_ad_owner_name"]; ?>
                                        </div>
                                        <div class="col-2 font-bold text-center">VS.</div>
                                        <div class="col-5 text-center">
                                                <span class="font-bold">
                                                        <?= $d["pretty_club_name"]; ?>
                                                </span>
                                                <br />
                                                <?= $d["pretty_team_name"]; ?> <?= $d["pretty_team_group_name"]; ?>
                                                <br />
                                                <?= $d["pretty_trainer_name"]; ?>
                                        </div>
                                </div>
                        </td>
                </tr>

                </tbody>

        </table>
</li>