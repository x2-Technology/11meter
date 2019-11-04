<div class="container-fluid font-small">
        Conditions
        <?= $this->data->content;?>


        <!--<div class="view-footer">
            <div class="btn-group btn-group-justified">
                <div class="btn-group">
                    <button type="button" class="btn btn-danger">Ablehnen</button>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary">Annehmen</button>
                </div>
            </div>
        </div>-->

</div>

<div class="view-footer">
            <input type="button" id="tac_accept" class="text-primary x2-mobile-button" data-role="tac-action" data-accept="true" value="Annehmen" />
            <input type="button" id="tac_decline" class="text-danger x2-mobile-button" data-role="tac-action" data-accept="false" value="Ablehnen" />
</div>
