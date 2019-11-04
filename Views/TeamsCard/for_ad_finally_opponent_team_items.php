<?php
    #highlight_string(var_export($this->data, true));
?>
<span class="text-success"><?= $this->data->data["pretty_club_name"]; ?>, <?= $this->data->data["pretty_team_name"]; ?> <?= $this->data->data["pretty_team_group_name"]; ?>, <?= $this->data->data["pretty_league_name"]; ?></span>
<input type="hidden" name="opponent_club[]" id="" value="<?= $this->data->data["club_id"]; ?>" >
<input type="hidden" name="opponent_team[]" id="" value="<?= $this->data->data["team_id"]; ?>" >
<input type="hidden" name="opponent_team_group[]" id="" value="<?= $this->data->data["team_group_id"]; ?>" >
<input type="hidden" name="opponent_team_league[]" id="" value="<?= $this->data->data["league_id"]; ?>" >
<input type="hidden" name="opponent_trainer[]" id="" value="<?= $this->data->data["trainer_id"]; ?>" >



