<?php if($this->data->pars->row === "radio") { ?>

        <li class="cell ltr" data-id="<?= $this->data->dfb_team["id"]; ?>" data-name="<?= $this->data->dfb_team["name"]; ?>" data-club="<?= $this->data->pars->club; ?>" >
                <input id="club_<?= $this->data->dfb_team["id"]; ?>" name="club[]" type="radio"/>
                <label for="club_<?= $this->data->dfb_team["id"]; ?>" class="">
                        <?= $this->data->dfb_team["name"]; ?>
                </label>
        </li>

<?php } else { ?>

        <li
                class="cell ltr"
                data-sub-title=""
                data-id="<?= $this->data->dfb_team["id"]; ?>"
                data-name="<?= $this->data->dfb_team["name"]; ?>"
                data-club="<?= $this->data->pars->club; ?>" >

                <a data-data="<?= Helper::JSONCleaned($this->data->subTeamDetailsViewController); ?>">
                        <?= $this->data->dfb_team["name"]; ?>
                </a>
        </li>



<?php }  ?>