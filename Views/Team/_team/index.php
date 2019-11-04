<!--HEADER-->
<?= $this->data->header; ?>
<ul class="x2-list">
        <?php

        if (count($this->data->rows)) {


                foreach ($this->data->rows as $role => $rows) {

                    $presence_display_name = current($rows)["data"]; ?>

                    <li class="section">
                            <?= $presence_display_name["teamrolle_name"]; ?>
                        <span class="x2-badge" data-value="<?= count($rows); ?>"></span>
                    </li>

                    <?php

                        foreach ( $rows as $member ) {
                            echo $member["row"];
                        }
                }
        }
        ?>

</ul>