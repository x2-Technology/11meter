<?php
$file_ext = pathinfo($this->data->src)["extension"];
if( $file_ext === "pdf" ){ ?>

    <iframe src="http://docs.google.com/gview?url=<?= $this->data->src; ?>&embedded=true" class="full-height full-width" frameborder="0" scrolling="true"></iframe>

<?php } else { ?>

    <?php
        switch (exif_imagetype($this->data->src)){
                case IMAGETYPE_BMP:
                case IMAGETYPE_GIF:
                case IMAGETYPE_JPEG:
                case IMAGETYPE_PNG: ?>
                    <div style="background-image: url(<?= $this->data->src; ?>); background-size: contain; background-repeat: no-repeat;" class="full-height full-width" ></div>
                <?php break;
                default:break;
        } }?>

