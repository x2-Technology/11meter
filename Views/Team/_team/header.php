
<div class="team-item d-flex justify-content-between align-items-center position-relative pl-0 pr-0">
    <div style="width:100%; height: 198px;" >
            <img src="<?= $this->data->team_image; ?>"
                 onerror="this.src='/images/no-team.png';this.parentNode.style.height=118"
                 style="width: 100%; height: 100%;" >
    </div>
</div>
<div class="team-item list-group-item d-flex justify-content-between align-items-center pr-2 pl-0 pt-0 pb-2 position-relative "
     style="height:60px; display: table-cell; overflow: hidden;">

    <a class="w-100">

        <div class="pos-absolute" style="top: 0; left: 0; width: 40px; height: 40px;">

            <span class="ml-5 mt-10" style="height: 40px;
                width: 40px;
                border-radius: 100px;
                background-color: gray;
                float: left;">
            <img data-role="image-preview" data-jump="1" data-name="<?= $this->data->club_name; ?>"
                 src="<?= $this->data->club_logo; ?>"
                 data-original-src="<?= $this->data->club_logo; ?>"
                 onerror="/images/avatar.png"
                 style="width: 100%; height: 100%; border-radius: 50%"
            />

        </span>

        </div>
        <div class="float-left ml-50 font-small font-bold font-italic">
                <span><?= $this->data->club_name; ?></span>
                <div class="clearfix"></div>
                <span><?= $this->data->team_name; ?></span>
        </div>

        <span class="badge float-right">
            <span class="badge float-left"><i class="icon <?= $presence_ico; ?> font-size-14 "></i> </span>
        </span>



    </a>

</div>