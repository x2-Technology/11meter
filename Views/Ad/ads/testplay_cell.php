<li class="cell"
    data-id="<?= $this->data->ad_id; ?>"
    data-group="<?= $this->data->cell_name; ?>"
    data-sort="<?=$this->data->ad_id;?>"

>

        <a data-data="<?= Helper::JSONCleaned($this->data->details_view_controller); ?>" >
                <?php highlight_string(var_export($this->data->ad_details, true));; ?><!-- <?/*= $this->data->display_name; */?> <span class="font-mini" id="season"><?/*=$season_part;*/?></span>-->


            <table>
                <tbody>
                    <tr><td></td></tr>
                </tbody>


            </table>




        </a>


        <!--<label>Check Me</label>
        <div class="switch">
            <input id="x" type="checkbox" name="switch" checked="checked" />
            <label for="x" class="label-success"></label>
        </div>-->

</li>