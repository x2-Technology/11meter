<ul class="x2-list">
        <li class="cell">

                <a data-data="<?= Helper::JSONCleaned($this->data->my_ads_view_controller_data_public);?>" >
                        <label>Meine öffentliche Anzeige</label>
                    <div class="cell-badge pr-5" data-value="<?= $this->data->totals["public"]["total"]; ?>"></div>
                </a>
        </li>

        <li class="cell">

            <a data-data="<?= Helper::JSONCleaned($this->data->my_ads_view_controller_data_private);?>" >
                <label>Meine private Anzeige</label>
                <div class="cell-badge pr-5" data-value="<?= $this->data->totals["private"]["total"]; ?>"></div>
            </a>
        </li>

        <li class="cell">

            <a data-data="<?= Helper::JSONCleaned($this->data->ads_search_view_controller_data);?>" >
                <label>Anzeige Suche </label>
            </a>
        </li>
</ul>