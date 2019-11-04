<?php if( DEVICE_TYPE::IOS != REPOSITORY::read(REPOSITORY::CURRENT_DEVICE) && DEVICE_TYPE::ANDROID != REPOSITORY::read(REPOSITORY::CURRENT_DEVICE) ) { ?>
    <a onclick="new Layout().feedbackMeetingSave()">Submit</a>
<?php } ?>

<form>
    <ul class="x2-list">

        <!--HEADER-->
            <?= $this->data->header; ?>

            <?php

            if (count($this->data->rows)) {

                    #echo json_encode($this->data->rows);

                    foreach ($this->data->rows as $role => $rows) {


                            if ($role == TEAMROLLE::SPIELER) {


                                    foreach ($rows as $presence => $members) {

                                            if ($presence === ANWESENHEIT::YES) {

                                                    // Presence info from any user in this category
                                                    // while ist embedded in mysql column for member
                                                    #echo count($members) . "<br />";
                                                    $presence_display_name = current($members);
                                                    #reset($members);
                                                    if (count($members)) {
                                                            ?>

                                                            <li class="section">

                                                                <?= $presence_display_name["data"]["presence_display_name"]; ?>
                                                                <span class="x2-badge" data-value="<?= count($members); ?>"></span>
                                                            </li>

                                                            <?php foreach ($members as $index => $member) {
                                                                    echo $member["row"];
                                                            }
                                                    }
                                            }

                                            if ($presence === ANWESENHEIT::NO) {

                                                    if (count($members)) {

                                                            // Presence info from any user in this category
                                                            // while ist embedded in mysql column for member
                                                            $presence_display_name = current($members);
                                                            reset($members);
                                                            ?>

                                                            <li class="section">
                                                                    <?= $presence_display_name["data"]["presence_display_name"]; ?>
                                                                <span class="x2-badge" data-value="<?= count($members); ?>"></span>
                                                            </li>

                                                            <?php foreach ($members as $index => $member) {
                                                                    echo $member["row"];
                                                            }
                                                    }
                                            }

                                            if ($presence === ANWESENHEIT::MAYBE) {

                                                    if (count($members)) {

                                                            // Presence info from any user in this category
                                                            // while ist embedded in mysql column for member
                                                            $presence_display_name = current($members);
                                                            reset($members);
                                                            ?>

                                                            <li class="section">
                                                                    <?= $presence_display_name["data"]["presence_display_name"]; ?>
                                                                <span class="x2-badge" data-value="<?= count($members); ?>"></span>
                                                            </li>

                                                            <?php foreach ($members as $index => $member) {
                                                                    echo $member["row"];
                                                            }
                                                    }
                                            }

                                    }


                            }
                    }
            }
            ?>

    </ul>
</form>
