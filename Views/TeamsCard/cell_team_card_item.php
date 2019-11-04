<?php #highlight_string(var_export($this->data, true));?>

    <li class="cell border" data-team-key="<?= $this->data->cell_key; ?>" data-role="team-card-item" >

        <div class="d-table-cell">
            <table class="table-sm">
                <tbody>
                <tr><td><label class="font-bold">Verein</label></td><td><?= $this->data->cell["pretty_club_name"]; ?> [ <?= $this->data->cell_key; ?> ]</td></tr>
                <tr><td><label class="font-bold">Mannschaft</label></td><td><?= $this->data->cell["pretty_team_name"]; ?> <?= $this->data->cell["pretty_team_group_name"]; ?></td></tr>
                <tr><td><label class="font-bold">Spielklasse</label></td><td><?= $this->data->cell["pretty_league_name"]; ?></td></tr>
                <tr><td><label class="font-bold">Trainer</label></td><td><?= $this->data->cell["pretty_trainer_name"]; ?></td></tr>
                </tbody>
            </table>

        </div>
        <div class="d-table-cell vertical-align-middle text-right">
            <button id="remove-card-item" class="bg-transparent box-no-border text-primary">
                <!--<i class="icon icon-<?/*= APP_ICON::ICON_RECYCLE_BIN; */?>"></i>-->
                Löschen
            </button>
        </div>

    </li>



