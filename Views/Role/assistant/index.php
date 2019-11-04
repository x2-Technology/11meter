<div class="view-body">

    <input type="hidden" name="user_used_role_data" id="user_used_role_data"
           value="<?= Helper::JSONCleaned($this->data->pars); ?>"/>

        <?php


        #unset($this->data->seasons);
        #unset($this->data->seasonViewData);
        #unset($this->data->teamViewData);
        #unset($this->data->clubViewData);
        #unset($this->data->user);
        #highlight_string(var_export($this->data->pars->role_locked, true));
        #highlight_string(var_export($this->data->pars->confirmed_by_club_logo, true));

        #highlight_string(var_export($this->data->user_used_role, true));

        $uur = $this->data->user_used_role;

        // echo $uud->role_locked;


        $globalDisabled = $uur->role_locked ? "disabled" : "";
        ?>


    <form>

        <input type="hidden" id="user_used_role_id" name="user_used_role_id"
               value="<?= $uur->user_used_role_id; ?>"/>

        <ul class="x2-list">

            <li class="section col text-center box-no-border ">
                <img
                        src="/images/<?= $uur->confirmed_by_club_logo; ?>"
                        onerror=""
                        data-original-src="/images/reject.jpg"
                        data-name=""
                        data-jump="1"
                        class="s100 member-image">
            </li>


            <li class="section box-no-border">
                Aktivität zwischen
            </li>

                <? $k = "activity_from"; ?>
                <li class="cell form <?= $globalDisabled; ?>" <?= $globalDisabled; ?> >
                <label for="<?= $k; ?>">Von</label>
                <input type="date" name="<?= $k; ?>" id="<?= $k; ?>" value="<?= $uur->activity_from; ?>">
            </li>
                <? $k = "activity_to"; ?>
            <li class="cell form <?= $globalDisabled; ?>" <?= $globalDisabled; ?> >
                <label for="<?= $k; ?>">Bis</label>
                <input type="date" name="<?= $k; ?>" id="<?= $k; ?>" value="<?= $uur->activity_to; ?>">
            </li>


            <li class="section">

            </li>

                <?php if ( $uur->role_locked ) { ?>
                <?php } ?>


            <!--SEASON SELECT -->

                <? $k = "season"; ?>
            <?php if ( !$uur->role_locked ) { ?>
            <li class="cell" id="<?= $k; ?>">

                        <a data-data="<?= Helper::JSONCleaned($this->data->seasonViewData); ?>">

                            <label>Season</label>

                            <select id="<?= $k; ?>" name="<?= $k; ?>" class="text-info">
                                <option value="0"></option>

                                <!--
                                With edit mode set selected variable
                                Via JS
                                -->
                                    <?php /*if (count($this->data->seasons)) { */?><!--
                                            <?php /*foreach ($this->data->seasons as $index => $season) { */?>
                                            <option value="<?/*= $index; */?>"><?/*= $season["name"]; */?></option>
                                            <?php /*} */?>
                                    --><?php /* } */?>

                            </select>
                        </a>
            </li>

            <?php }

            else { ?>

                <li class="cell disabled" disabled>

                    <label id="<?= $k; ?>" name="<?= $k; ?>">
                        <?= $uur->pretty_season; ?>
                    </label>
                </li>

            <?php } ?>


            <li class="section pb-10">
                <span class="font-italic font-mini font-normal">Saisonauswahl für einige Funktionen erforderlich</span>
            </li>

                <? $k = "club"; ?>

                <?php

                $clubCanBeChange = $this->data->clubCanBeChange ? "" : "disabled";
                $clubCanBeChange2 = $this->data->clubCanBeChange ? "" : "readonly";

                // $clubCanBeChange = is_null($this->data->user_used_role["club_id"]) ? "" : "disabled";


                ?>

            <li class="cell <?= $clubCanBeChange; ?>" <?= $clubCanBeChange; ?> <?= $clubCanBeChange2; ?> >
                <a data-data="<?= Helper::JSONCleaned($this->data->clubViewData); ?>">
                    <label>Verein</label>
                    <input type="hidden" name="pretty_club_name" id="pretty_club_name" value=""/>
                    <select id="<?= $k; ?>" name="<?= $k; ?>" class="text-info">

                        <!--
                        With edit mode remove first element
                        of select and add pretty option
                        like selected club data
                        Via JS
                        -->

                        <option value="0"></option>
                    </select>
                </a>
            </li>


                <?php if ( !$uur->role_locked ) { ?>

                    <li class="section"></li>

                    <? $k = "team"; ?>
                    <li class="cell required">

                        <input type="button" id="add_team"
                               data-data="<?= Helper::JSONCleaned($this->data->teamViewData); ?>"
                               value="MANNSCHAFT EINFÜGEN"/>
                       <!-- <a id="add_team" data-data="">MANNSCHAFT EINFÜGEN</a>-->
                    </li>
                    <li class="section pb-10">
                        <span class="font-italic font-mini font-normal">Option verfügbar, wenn das Verein ausgewählt ist</span>
                    </li>
                <?php } ?>
        </ul>
        <div class="clearfix table-distance-1"></div>


        <ul class="x2-list" id="teams" data-removeable="true">


        </ul>

    </form>
</div>

<?php if ( !$uur->role_locked ) { ?>
    <div class="view-footer">
        <input type="button" id="approve_edited_club_for_role" class="text-primary x2-mobile-button" value="Übernehmen"
               disabled/>
    </div>
<?php } ?>
