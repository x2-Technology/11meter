<div class="view-body">

    <ul class="x2-list" data-role="search">

        <li class="section">Suche</li>
        <li class="cell" data-role="name-xxx">
            <a data-data="<?= Helper::JSONCleaned($this->data->clubs_view_controller);?>">
                <label>Verein</label>
                <select name="club_name" id="club_name" class="text-info" >
                    <option value="0">Optional</option>
                </select>
                <label for="club_name" class="d-none"></label>
            </a>

        </li>
        <li class="cell required">
            <a data-data="<?= Helper::JSONCleaned($this->data->opponent_teams_view_controller);?>">
                <label for="opponent_team">Gegner Mannschaft</label>
                <select name="opponent_team" id="opponent_team" class="text-info">
                    <option value="0"></option>
                </select>
            </a>
        </li>

        <li class="cell required" data-sub-title="" data-sub-title-color="text-info">
            <a data-data="<?= Helper::JSONCleaned($this->data->opponent_leagues_view_controller);?>">
                <label for="opponent_league">Gegner Spielklasse</label>
            </a>

            <!--// POST HIDDEN ELEMENT-->
            <input type="hidden" name="opponent_league" id="opponent_league" value="" >

        </li>

        <li class="cell" data-sub-title="" data-sub-title-color="text-info">
            <a data-data="<?= Helper::JSONCleaned($this->data->environment_view_controller);?>">

                <label for="area">Umkreis</label>

                <select name="area" id="area" class="text-info">
                    <option value="0">Optional</option>
                </select>

                <input type="hidden" name="area_environment_km" id="area_environment_km" value="" />

            </a>
        </li>




        <li class="section"></li>
        <li class="cell">
            <input
                    type="button"
                    value="Suchen"
                    id="suggestions"
                    data-view-controller="<?= Helper::JSONCleaned($this->data->result_for_filter_view_controller); ?>"

            >
        </li>

    </ul>




    <!--BASKET-->
    <ul class="x2-list merge-with-upper" id="team-card">

    </ul>

</div>

<div class="view-footer">

    <input class="text-danger x2-mobile-button"
            type="button"
            value="Zurücksetzen"
            id="card-teams-items-reset"
    >

</div>