<?php

    if( count($this->data->teams) ){
        $teamsNameCollect = array();
        foreach ($this->data->teams as $index => $team) {
            array_push($teamsNameCollect, $team["name"]);
        }
        $teamsNameCollect = implode(", ", $teamsNameCollect);
    }

        # Burada LInkden Post edilen degerlere gore assistan index i doldur
        # Normalde user_used_role_id ye gore databaseden aciliyordu ama
        # problem cikiyor o yüzden url arkasina get ile gonder ver orda prs degeril ile formu doldur.
        # Ayrica Club eklendikten sonra status butonu aktiv olmuyior
        
        // highlight_string(var_export($this->data, true));

?>


<li class="cell ltr" data-role="role-clubs" data-user-used-role-id="<?= $this->data->user_used_role_id; ?>" >

        <a data-data="<?= Helper::JSONCleaned( $this->data->clubOfRoleDetailsViewControllerData ); ?>">

            <!--<label><span id="club"><?/*= $this->data->club["teamName2"]; */?></span>-->
            <label>

                <span id="club"><?= $this->data->clubName; ?></span>
                <table>
                    <tbody>

                    <?php if (!is_null($this->data->season)) { ?>
                        <tr class="font-mini">
                            <td>Season</td>
                            <td>: <span id="season"><?= $this->data->season["name"]; ?></span></td>
                        </tr>
                    <?php } ?>

                    <?php if (!empty($this->data->activity_from) || !empty($this->data->activity_to)) { ?>

                        <tr class="font-mini">
                            <td>Period</td>
                            <td>: <span id="period">

                                   <?php

                                   if (!empty($this->data->activity_from) && !empty($this->data->activity_to)) {
                                           echo $this->data->pretty_activity_from; ?> - <?= $this->data->pretty_activity_to;

                                   } else if (!empty($this->data->activity_from) && empty($this->data->activity_to)) {

                                           echo "ab: " . $this->data->pretty_activity_from;

                                   } else if (empty($this->data->activity_from) && !empty($this->data->activity_to)) {

                                           echo "bis: " . $this->data->pretty_activity_to;

                                   } ?>

                                   </span></td>
                        </tr>

                    <?php } ?>

                    <?php if (!is_null($this->data->teams)) { ?>
                        <tr class="font-mini">
                            <td>Mannschaft</td>
                            <td>: <span id="teams"><?= $teamsNameCollect; ?></span></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>

            </label>

            <span class="additional-icon"><img
                        src="/images/<?= $this->data->confirmed_by_club_logo; ?>"
                        onerror=""
                        data-original-src=""
                        data-name=""
                        data-jump="1"
                        data-role="image-preview"
                        class="s100 member-image"></span>

        </a>
</li>