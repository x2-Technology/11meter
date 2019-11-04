<ul class="x2-list" data-role="search">

    <li class="section">Suche</li>
    <li class="cell form">
        <label for="club_name">Verein</label>
        <input type="text" name="club_name" id="club_name" value="" placeholder="Geben Sie hire Vereinname" >
    </li>
    <li class="cell">
        <a data-data="<?= Helper::JSONCleaned($this->data->opponent_teams_view_controller);?>">
            <label for="opponent_team">Gegner Mannschaft</label>
            <select name="opponent_team" id="opponent_team" class="text-info">
                <option value="0"></option>
            </select>
        </a>
    </li>

    <li class="cell" data-sub-title="" data-sub-title-color="text-info">
        <a data-data="<?= Helper::JSONCleaned($this->data->opponent_leagues_view_controller);?>">
            <label for="opponent_league">Gegner Spielklasse</label>
        </a>

        <!--// POST HIDDEN ELEMENT-->
        <input type="hidden" name="opponent_leagued" id="opponent_leagued" value="" >

    </li>

    <li class="cell" data-sub-title="" data-sub-title-color="text-info">
        <a data-data="<?= Helper::JSONCleaned($this->data->environment_view_controller);?>">

            <label for="area">Umkreis</label>

            <select name="area" id="area" class="text-info">
                <option value="0"></option>
            </select>

            <input type="hidden" name="area_environment_km" id="area_environment_km" value="" />

        </a>
    </li>




    <li class="section"></li>
    <li class="cell">
        <input type="button" value="Ergebnisse" data-role="suggestions" >
    </li>

</ul>



<!--BASKET-->
<ul class="x2-list" data-role="team-card">

</ul>