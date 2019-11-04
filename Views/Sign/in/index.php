<?php
    $signupData = Helper::JSONCleaned($this->data->signup);
?>

<ul class="x2-list" >

    <li class="cell">

        <img src="/images/DFA23.png" class="mx-auto d-block" width="100">

    </li>
    <li class="cell no-cell-border">
        <span class="mx-auto d-block text-center font-large font-bold">Hallo</span>
    </li>

    <li class="cell no-cell-border">

            <?php $v = "mobil_number"; ?>
        <div class="mx-auto d-block relative w-75">
            <label class="text-info font-mini"><i class="icon icon-info2"></i> Handynummer erfolgreich mit Ländervorwahl</label>
            <!--<input type="tel" required name="<?/*=$v;*/?>" id="<?/*=$v;*/?>" class="form-control-underline box-with-border-radius-none background-primary text-color-primary" value="" placeholder="Handynummer">-->
            <input type="tel" value="015228763036" required name="<?=$v;?>" id="<?=$v;?>" class="form-control-underline box-with-border-radius-none background-primary text-color-primary" placeholder="Handynummer" >
        </div>

    </li>

    <li class="cell no-cell-border">

            <?php $v = "password"; ?>
            <div class="mx-auto d-block relative w-75">
                <label class="text-info font-mini"><i class="icon icon-info2"></i> Ihre Passwort</label>
                <!--<input type="password" pattern="[0-9]*" inputmode="numeric" required maxlength="4" name="<?/*=$v;*/?>" id="<?/*=$v;*/?>" class="form-control-underline box-with-border-radius-none background-primary text-color-primary" value="" placeholder="PIN-Nummer">
                --><input type="<?=$v;?>" value="1" required  name="<?=$v;?>" id="<?=$v;?>" class="form-control-underline box-with-border-radius-none background-primary text-color-primary" placeholder="Passwort">
            </div>

    </li>

    <li class="cell no-cell-border">
        <div class="col-sm-12">
            <div class="mx-auto d-block relative w-50"><a class="wobbles btn badge-info full-width" id="login"><span class="mx-auto d-block">Login</span></a></div>
        </div>

    </li>

    <li class="cell no-cell-border nopadding mt-20">

        <div class="mx-auto d-block relative w-50 text-center">
            <label class="mx-auto d-block">Passwort
                <a id="request_password" class="text-primary">
                    vergessen!
                </a>
            </label>

        </div>
    </li>

    <li class="cell no-cell-border nopadding">

        <div class="mx-auto d-block relative w-50 text-center">
            <label class="mx-auto d-block">Keine konto ?
                <a id="signup_view" data-data="<?= $signupData; ?>" class="text-primary">
                    neu anmelden
                </a>
            </label>

        </div>
    </li>


</ul>






<!--
<section id="stage" class="profile-theme-blue" data-lazyload="">
    <div class="stage-team stage-profile">
        <div class="background-image"></div>
        <div class="stage-profile-content container">
            <p class="subline">A-Junioren
                <span class="separator">|</span>
                <a href="http://www.fussball.de/verband/suedwest/-/verband/0123456789ABCDEF0123456700004160">Südwest</a>
            </p>
            <h2>TSG 1846 Bretzenheim</h2>
            <p class="subline">
                <a href="http://www.fussball.de/verein/tsg-1846-bretzenheim-suedwest/-/id/00ES8GNBB000000DVV0AG08LVUPGND5I">Zur Vereinsseite</a>
            </p>
            <div class="stage-content-wrapper">
                <div class="column-left">
                    <div class="column-image">
                        <div class="img">
                            <img src="//service.media.fussball.de/api/uimg/cont/-/ID/01HEHIHNDS000000VV0AG811VUIMUTIM/TYP/50/SZ/3" alt="image">
                            <div class="hexagon club">
                                <span class="icon-hexagon"></span>
                                <div class="inner">
                                    <div class="valign-wrapper">
                                        <div class="valign-inner">
                                            <img src="//www.fussball.de/export.media/-/action/getLogo/format/0/id/00ES8GNBB000000DVV0AG08LVUPGND5I" alt="logo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column-right">
                    <div class="inner">
                        <a href="http://www.fussball.de/spieltagsuebersicht/a-junioren-verbandsliga-suedwest-a-junioren-verbandsliga-a-junioren-saison1819-suedwest/-/staffel/023RGG1FJS000000VS54898DVST4NHAM-G" class="profile-value">A-Junioren Verbandsliga</a>
                        <p class="profile-label">Wettbewerb</p>
                        <p class="profile-value">1</p>
                        <p class="profile-label">Tabellenplatz</p>
                        <p class="profile-value">34</p>
                        <p class="profile-label">Punkte</p>
                        <p class="profile-value">67:26</p>
                        <p class="profile-label">Torverhältnis</p>
                        <p class="profile-value">Verbandsliga</p>
                        <p class="profile-label">Spielklasse</p>
                        <div class="profile-edit">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="teamProfile">
    <div data-toggle=".factfile-data .button-primary" data-toggle-content=".factfile-form" class="club-profile factfile ng-scope" data-toggle-close=".link-close">
        <div class="factfile-headline">
            <h3 class="headline">
                <a href="http://www.fussball.de/verein/tsg-1846-bretzenheim-suedwest/-/id/00ES8GNBB000000DVV0AG08LVUPGND5I">TSG 1846 Bretzenheim</a>
            </h3>
            <p class="subline">
                <a href="http://www.fussball.de/verband/suedwest/-/verband/0123456789ABCDEF0123456700004160">Südwest</a>
            </p>
        </div>
        <div class="factfile-data">
            <div class="row">
                <div class="column-left">
                    <div class="value">1846</div>
                    <div class="label">Gründungsjahr</div>
                </div>
                <div class="column-right">
                    <div class="value">blau-weiß</div>
                    <div class="label">Vereinsfarben</div>
                </div>
            </div>
            <div class="row">
                <div class="column-left">
                    <div class="value">
                        Röntgenstr. 14-16, 55128 Mainz
                    </div>
                    <div class="label">Adresse</div>
                </div>
                <div class="column-right">
                    <div class="value">&nbsp;</div>
                    <div class="label">Ansprechpartner</div>
                </div>
            </div>
            <div class="row">
                <div class="column-left">
                    <div class="value">
                        <a href="http://www.tsg1846bretzenheim.de" target="_blank">www.tsg1846bretzenheim.de</a>
                    </div>
                    <div class="label">Website</div>
                </div>
                <div class="column-right">
                    <button data-ajax-type="html" data-ajax-target=".contact-form-wrapper #captcha_1" data-ajax-resource="//www.fussball.de/ajax.captcha/-/id/00ES8GNBB000000DVV0AG08LVUPGND5I" class="button button-primary ng-scope" data-ajax-method="get" data-ajax="">Verein kontaktieren</button>
                </div>
            </div>
        </div>
        <div class="factfile-form">
            <div class="inner">
                <a href="#" class="link-close"><span class="icon-close"></span></a>
                <form data-ajax-type="html" data-ng-controller="AjaxController" data-ajax-target=".contact-form-wrapper" data-ajax-resource="http://www.fussball.de/ajax.contact.form/-/id/00ES8GNBB000000DVV0AG08LVUPGND5I" class="contact-form-wrapper ng-scope ng-pristine ng-valid" data-ajax="replace" data-ajax-method="post" data-tracking="{'href':'http://www.fussball.de/ajax.contact.form/-/id/00ES8GNBB000000DVV0AG08LVUPGND5I'}">
                    <div class="container">
                        <p class="description">Nachricht an TSG 1846 Bretzenheim</p>
                    </div>
                    <div class="container contact-form form-small">
                        <div class="column-left">
                            <input data-ng-model="ngFirstname" name="firstname" placeholder="Dein Vorname*" type="text" value="" class="input-firstname ng-pristine ng-valid" data-ajaxmodel="firstname">
                            <input data-ng-model="ngLastname" name="lastname" placeholder="Dein Nachname*" type="text" value="" class="input-lastname ng-pristine ng-valid" data-ajaxmodel="lastname">
                            <input data-ng-model="ngSender" name="address" placeholder="Deine E-Mail-Adresse*" type="text" value="" class="input-email ng-pristine ng-valid" data-ajaxmodel="address">
                            <input data-ng-model="ngSubject" name="subject" placeholder="Dein Betreff*" type="text" value="" class="input-subject ng-pristine ng-valid" data-ajaxmodel="subject">
                            <textarea data-ng-model="content" name="content" placeholder="Deine Nachricht*" data-ajaxmodel="content" class="ng-pristine ng-valid"></textarea>
                        </div>
                        <div class="column-right">
                            <div id="captcha_1" class="captcha">
                                <div>
                                    <img alt="renew captcha">
                                </div>
                                <a data-ajax-type="html" data-ajax-target=".contact-form-wrapper #captcha_1" data-ajax-resource="//www.fussball.de/ajax.captcha/-/id/00ES8GNBB000000DVV0AG08LVUPGND5I" href="//www.fussball.de/ajax.captcha/-/id/00ES8GNBB000000DVV0AG08LVUPGND5I" data-ajax-method="post" data-tracking="{'href':'//www.fussball.de/ajax.captcha/-/id/00ES8GNBB000000DVV0AG08LVUPGND5I'}" data-ajax="" class="ng-scope"><span class="icon-reload"></span></a>
                                <input data-ng-model="digest" name="captcha-digest" type="hidden" value="" data-ajaxmodel="captcha-digest" class="ng-pristine ng-valid">
                            </div>
                            <input data-ng-model="securityCode" name="captcha-code" placeholder="Sicherheitscode*" type="text" value="" data-ajaxmodel="captcha-code" class="ng-pristine ng-valid">
                            <button class="button button-primary">Nachricht senden</button>
                            <p class="info">* Pflichtfelder</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>-->