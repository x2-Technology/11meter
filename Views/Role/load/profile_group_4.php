<?php $rcd = $this->data->registered_club_data_for_admin;


    /*unset($this->data->user);
    unset($this->data->viewControllerForRoleAssistantData);
    unset($this->data->licences);
    unset($this->data->viewControllerForCodeAddData);
    unset($this->data->clubViewData);
    unset($this->data->clubManagersViewData);
    unset($this->data->termsAndConditionsViewData);
    unset($this->data->RowClubForRole);
    unset($this->data->repository);
    // unset($this->data->user_used_role);
    unset($this->data->user_clubs_for_role);
    unset($this->data->registered_club_data_for_admin);
    unset($this->data->season);
    // unset($this->data->user_used_role_id);
    */

    #highlight_string(var_export($this->data, true));
    #highlight_string(var_export($rcd, true));

    // echo $this->data->user_used_role["club_id"];
    $globalDisabled = $this->data->user_used_role["role_locked"] ? "disabled" : "";


 ?>





    <input type="hidden" name="user_used_role_id"  id="user_used_role_id" value="<?= $this->data->user_used_role_id; ?>"/>

    <!--    !!!!!!
            This Data, 'role' need absolutely for this group, while by edit
            checking save from which role!
            This role from Club & Club Admin!
            This save operation not like standard save operation way
    -->
        <?php if( !is_null($this->data->user_used_role["role_id"]) ) { ?>
        <input type="hidden" name="role"  id="role" value="<?= $this->data->user_used_role["role_id"]; ?>"/>
        <?php }?>
    <!--END-->


    <li class="section pt-20">

            <?php if( $this->data->user_used_role["role_locked"] ) { ?>

                Role durch Admin blokiert!

            <?php } ?>

    </li>

        <? $k = "status"; ?>
    <li class="cell <?=$globalDisabled;?>" <?=$globalDisabled;?> >
        <label for="xs" class="">Status</label>
        <div class="switch">

                <?php
                $checked = "";
                if (count($this->data->user_used_role)) {
                        if ($this->data->user_used_role[$k]) {
                                $checked = "checked=checked";
                        }
                }
                ?>

            <input type="checkbox" name="<?= $k; ?>" id="<?= $k; ?>" <?= $checked; ?> >
            <label for="<?= $k; ?>" class="label-primary"></label>
        </div>
    </li>


    <li class="section"></li>

        <? $k = "club"; ?>

        <?php $clubCanBeChange = is_null($this->data->user_used_role["club_id"]) ? "" : "disabled"; // "disabled"; ?>

    <li class="cell required <?= $clubCanBeChange; ?>" <?= $clubCanBeChange; ?> >

            <?php if( !is_null($this->data->user_used_role["club_id"]) ) { ?>
                <input type="hidden" name="club_id"  id="club_id" value="<?= $this->data->user_used_role["club_id"]; ?>"/>

            <?php }?>


        <a data-data="<?= Helper::JSONCleaned($this->data->clubViewData); ?>" >
            <input type="hidden" name="pretty_club_name" id="pretty_club_name" value="<?= $this->data->user_used_role["pretty_club_name"]; ?>" />
            <select id="<?= $k; ?>" name="<?= $k; ?>" >

                <!--
                With edit mode remove first element
                of select and add pretty option
                like selected club data
                Via JS
                -->
                    <?php
                    if( is_null( $this->data->user_used_role["club_id"] ) ) { ?>
                        <option value="0">Verein</option>
                    <?php } else { ?>
                        <option value="<?= $this->data->user_used_role["club_id"]; ?>"><?= $this->data->user_used_role["pretty_club_name"]; ?></option>
                    <?php } ?>


            </select>
        </a>
    </li>

    <!--Logo-->
    <li class="section text-center disabled">

        <div class="col text-center club-image">
            <img
                    data-original-src="https://img.fcbayern.com/image/upload/f_auto,q_auto/t_product-superzoom/eCommerce/produkte/10853/aufnaeher-logo-gross.jpg"
                    src="https://img.fcbayern.com/image/upload/f_auto,q_auto/t_product-superzoom/eCommerce/produkte/10853/aufnaeher-logo-gross.jpg"
                    onerror=""
                    data-name=""
                    data-jump="1"
                    data-role="image-preview"
                    class="s100 member-image"
                    data-action="changeable-image"
            >
        </div>

    </li>

        <?php $disabled = is_null($rcd["id"]) ? "disabled" : "";?>


        <? $k = "founding_year"; ?>
    <li class="form cell <?=$disabled;?> required <?=$globalDisabled;?>" <?=$globalDisabled;?> >
        <label for="<?=$k;?>">Gründungsjahr</label>
        <input type="tel" maxlength="4" name="<?=$k;?>" id="<?=$k;?>" value="<?= $rcd["founding_year"]; ?>" >
    </li>

    <li class="section">
        ANSCHRIFT
    </li>

        <? $k = "street"; ?>
    <li class="form cell <?=$disabled;?> <?=$globalDisabled;?>" <?=$globalDisabled;?>>
        <label for="<?= $k; ?>">Straße</label>
        <input type="text" name="<?= $k; ?>" id="<?= $k; ?>" value="<?= $rcd[$k]; ?>">
    </li>
        <? $k = "post_code"; ?>
    <li class="form cell <?=$disabled;?> <?=$globalDisabled;?>" <?=$globalDisabled;?>>
        <label for="<?= $k; ?>">PLZ</label>
        <input type="text" name="<?= $k; ?>" id="<?= $k; ?>" value="<?= $rcd[$k]; ?>">
    </li>

        <? $k = "town"; ?>
    <li class="form cell <?=$disabled;?> <?=$globalDisabled;?>" <?=$globalDisabled;?> >
        <label for="<?= $k; ?>">Ort</label>
        <input type="text" name="<?= $k; ?>" id="<?= $k; ?>" value="<?= $rcd[$k]; ?>">
    </li>


    <li class="section"></li>

        <? $k = "homepage"; ?>
        <?php $rcd[$k] = $rcd[$k] ? $rcd[$k] : "http://www.adler-gruppe.com"; ?>
    <li class="form cell required  <?=$disabled;?> <?=$globalDisabled;?>" <?=$globalDisabled;?>>
        <label for="<?=$k;?>"><i class="icon icon-earth3"></i> Homepage</label>
        <input type="text" data-type="http" onblur="new X2Tools().validate(this);" name="<?=$k;?>" id="<?=$k;?>" value="<?= $rcd[$k]; ?>" >
    </li>

        <? $k = "email"; ?>
        <?php $rcd[$k] = $rcd[$k] ? $rcd[$k] : "info@mail.com"; ?>
    <li class="form cell required <?=$disabled;?> <?=$globalDisabled;?>" <?=$globalDisabled;?>>
        <label for="<?=$k;?>"><i class="icon icon-envelop2"></i> E-mail</label>
        <input type="email" data-type="email" onblur="new X2Tools().validate(this);" name="<?=$k;?>" id="<?=$k;?>" value="<?= $rcd[$k]; ?>" >
    </li>

    <li class="section">
        SOCIAL MEDIA
    </li>

        <? $k = "facebook"; ?>
        <?php $rcd[$k] = $rcd[$k] ? $rcd[$k] : "my Facebook"; ?>
    <li class="form cell <?=$disabled;?> <?=$globalDisabled;?>" <?=$globalDisabled;?>>
        <label for="<?=$k;?>"><i class="icon icon-facebook2 text-primary"> Facebook</i></label>
        <input type="text" name="<?=$k;?>" id="<?=$k;?>" value="<?= $rcd[$k]; ?>" >
    </li>

        <? $k = "instagram"; ?>
        <?php $rcd[$k] = $rcd[$k] ? $rcd[$k] : "my my Instagramm"; ?>
    <li class="form cell <?=$disabled;?> <?=$globalDisabled;?>" <?=$globalDisabled;?>>
        <label for="<?=$k;?>"><i class="icon icon-instagram text-warning"> Instagram</i></label>
        <input type="text" name="<?=$k;?>" id="<?=$k;?>" value="<?= $rcd[$k]; ?>" >
    </li>

        <? $k = "twitter"; ?>
        <?php $rcd[$k] = $rcd[$k] ? $rcd[$k] : "Twitter"; ?>
    <li class="form cell <?=$disabled;?> <?=$globalDisabled;?>" <?=$globalDisabled;?>>
        <label for="<?=$k;?>"><i class="icon icon-twitter text-info"> Twitter</i></label>
        <input type="text" name="<?=$k;?>" id="<?=$k;?>" value="<?= $rcd[$k]; ?>" >
    </li>

        <? $k = "youtube"; ?>
        <?php $rcd[$k] = $rcd[$k] ? $rcd[$k] : "my Youtube"; ?>
    <li class="form cell <?=$disabled;?> <?=$globalDisabled;?>" <?=$globalDisabled;?>>
        <label for="<?=$k;?>"><i class="icon icon-youtube text-danger"> Youtube</i></label>
        <input type="text" name="<?=$k;?>" id="<?=$k;?>" value="<?= $rcd[$k]; ?>" >
    </li>


    <!-- ADMIN WEB LOGIN -->
    <li class="section">
        ADMIN WEB LOGIN
    </li>
        <? $k = "username"; ?>
        <?php $rcd[$k] = $rcd[$k] ? $rcd[$k] : "creativedirektor"; ?>
    <li class="form cell required <?=$disabled;?> <?=$globalDisabled;?>" <?=$globalDisabled;?>>
        <label for="<?=$k;?>">Username</label>
        <input type="text" name="<?=$k;?>" id="<?=$k;?>" value="<?= $rcd[$k]; ?>" >
    </li>
        <? $k = "password"; ?>
    <li class="form cell required <?=$disabled;?> <?=$globalDisabled;?>" <?=$globalDisabled;?> >
        <label for="<?=$k;?>">Password</label>
        <input type="password" name="<?=$k;?>" id="<?=$k;?>" value="<?= $rcd["password_pure"]; ?>" >
    </li>


    <li class="section"></li>


    <li class="form cell <?=$disabled;?> <?=$globalDisabled;?>" <?=$globalDisabled;?> >
        <a data-data="<?= Helper::JSONCleaned($this->data->clubManagersViewData);?>" >Vereinsverantwortliche</a>
    </li>

        <?php  if( is_null($rcd["id"])){ ?>

                <? $k = "club_create_policy"; ?>
        <li class="cell">
            <a data-data="<?= Helper::JSONCleaned($this->data->termsAndConditionsViewData);?>"  >
                <span>Lesen unsere Policy</span>
                <span class="additional-icon"><i class="tac icon icon-circle text-primary"></i></span>
                <input type="hidden" name="tac" value="false" />
            </a>
        </li>

        <?php  } ?>






