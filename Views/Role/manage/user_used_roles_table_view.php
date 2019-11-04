
<ul class="x2-list" id="user_used_roles">
    <?php if( count($this->data->user_used_roles) ) { ?>
        <?= $this->data->user_used_roles; ?>
    <?php } else { ?>
        <div class="container-fluid full-height" >
            <div class="d-table full-width mt-50" >
                <div class="d-table-cell text-center font-bold font-italic text-disabled" >
                    Keine Rolle gefunden!
                </div>
            </div>
        </div>
    <?php } ?>
</ul>



