<li class="cell image-cell">

    <span style="height: 40px;
                    width: 40px;
                    border-radius: 100px;
                    background-color: gray;
                    float: left;">
                <img data-role="image-preview" data-jump="2" data-name="<?= $this->data["db"]["member_final_name"]; ?>"
                     src="<?= $this->data["db"]["member_image_thumb"]; ?>"
                     data-original-src="<?= $this->data["db"]["member_image"]; ?>"
                     onerror="this.src='<?= $this->data["db"]["member_image_avatar"]; ?>'"
                     style="width: 100%; height: 100%; border-radius: 50%"
                />

            </span>
    <label class="single-line"><?= $this->data["db"]["member_final_name"]; ?></label>

</li>