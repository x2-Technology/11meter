<?php
        highlight_string(var_export($this->data, true));
?>

<ul class="x2-list">

        <li class="section">
                Message
        </li>
        <li class="cell">
                <?= $this->data->data["message_user"]; ?>
        </li>

        <li class="cell">
                <?= $this->data->data["message_developer"]; ?>
        </li>


        <li class="cell text-justify">
                <a data-data="<?= Helper::JSONCleaned($this->data->sql_view_controller_data)?>">
                        SQL
                </a>
        </li>

        <li class="section">
                Report
        </li>

        <li class="cell">

                <table class="w-100 text-justify tsoftx-table table-sm">
                        <tr>
                                <td>File</td>
                                <td>Line</td>
                                <td>Function</td>
                        </tr>

                        <?php
                        if( count($this->data->data["errors"]) ){
                            foreach ($this->data->data["errors"] as $index => $error) { ?>
                                    <tr>
                                            <td><?= $error["file"]; ?></td>
                                            <td><?= $error["line"]; ?></td>
                                            <td><?= $error["function"]; ?></td>
                                    </tr>
                            <?php }
                        } ?>

                </table>
        </li>
</ul>
