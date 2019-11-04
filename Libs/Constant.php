<?php /** @noinspection ALL */
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 25.09.18
 * Time: 22:25
 */

/**
 * Class DATA_FETCH
 * @Deprecated
 */
class DATA_FETCH
{
        const ASSOC = 0;
        const INDEXED = 1;
}

class FETCH_TYPE
{
        const ASSOC = 0;
        const INDEXED = 1;
}

class FETCH_STRUCTURE
{
        const FETCH_ARRAY = 0;
        const FETCH_OBJECT = 1;
}

class BACKGROUND_COLOR{
        const BackgroundColorWhite              = array(255,255,255);
        const BackgroundColorIphoneDefault      = array(255,255,255);
}


class REPOSITORY
{

        const CURRENT_REDIRECT  = "CURRENT_REDIRECT";
        const CURRENT_USER      = "CURRENT_USER";
        const CURRENT_CLUB      = "CURRENT_CLUB";
        const CURRENT_DEVICE    = "CURRENT_DEVICE";
        const CURRENT_MESSAGE   = "CURRENT_MESSAGE";
        const CURRENT_MEETING   = "CURRENT_MEETING";
        const CURRENT_TEMPORARILY_ADDED_CLUB_FOR_ROLE = "CURRENT_TEMPORARILY_ADDED_CLUB_FOR_ROLE";
        const CURRENT_DFB_CLUB_TEAMS = "CURRENT_DFB_CLUB_TEAMS";
        const CURRENT_FILTER_FOR_CARD_TEAMS = "CURRENT_FILTER_FOR_CARD_TEAMS";
        const CURRENT_APPENDED_CARD_TEAMS = "CURRENT_APPENDED_CARD_TEAMS";
        const CURRENT_ENVIRONMENT_DATA = "CURRENT_ENVIRONMENT_DATA";
        const CURRENT_AD_DISCUSSION_DATA = "CURRENT_AD_DISCUSSION_DATA";
        const CURRENT_SELECTED_AD_FROM_SEARCH = "CURRENT_SELECTED_AD_FROM_SEARCH";
        const CURRENT_LAST_MYSQL_ERROR = "CURRENT_LAST_MYSQL_ERROR";

        /**
         * This is a temporarily storing user roles
         * Either New Adding Or calling from host
         * Storing all Roles data into this repository
         * Finally sending all user roles data from this REPOSITORY
         */
        const USER_ROLES        = "USER_ROLES";

        const LIFE              = 31556926;


        static function write($key, $val)
        {

                $_SESSION[$key] = $val;
                setcookie($key, (is_array($_SESSION[$key]) ? json_encode($_SESSION[$key]) : $_SESSION[$key]), time() + REPOSITORY::LIFE, '/');

        }

        static function read($key)
        {


                if (count($_SESSION) && !is_null($_SESSION[$key])) {
                        // echo "Read from Session";
                        return $_SESSION[$key];
                }

                // echo "Read from Cookie";
                $repository = self::isJson($_COOKIE[$key]) ? json_decode($_COOKIE[$key], true) : $_COOKIE[$key];


                $_SESSION = self::readAll();

                return $repository;
                // return self::isJson( $_COOKIE[$key] ) ? unserialize( $_COOKIE[$key] ) : $_COOKIE[$key];
        }

        static function kill($key)
        {


                $_SESSION[$key] = NULL;
                $_COOKIE[$key] = NULL;
                unset($_SESSION[$key]);
                unset($_COOKIE[$key]);
                setcookie($key, null, -1, '/');

        }



        static function writes($k, $sk, $v = NULL)
        {

                if (is_null($v)) {

                        $v = $sk;
                        $_SESSION[$k] = $v;
                        // setcookie($k, (is_array($_SESSION[$k]) ? json_encode($_SESSION[$k]) : $_SESSION[$k]), time() + REPOSITORY::LIFE, '/');
                } else {


                        if (!is_null(self::reads($k, $sk))) {

                                $_SESSION[$k][$sk] = $v;
                                // setcookie($k, (is_array($_SESSION[$k][$sk]) ? json_encode($_SESSION[$k][$sk]) : $_SESSION[$k][$sk]), time() + REPOSITORY::LIFE, '/');
                        }
                        else {
                                // $_SESSION[$k] = array(
                                //         $sk=>$v
                                // );

                                $_SESSION[$k][$sk] = $v;
                        }

                        // print_r($_SESSION[$k]);


                }

                setcookie($k, (is_array($_SESSION[$k]) ? json_encode($_SESSION[$k]) : $_SESSION[$k]), time() + REPOSITORY::LIFE, '/');


        }

        static function reads($k, $sk = NULL)
        {

                // return $_SESSION;

                if (is_null($sk)) {

                        if (count($_SESSION) && array_key_exists( $k, $_SESSION )) {
                                return $_SESSION[$k];
                        }

                        $repository = self::isJson($_COOKIE[$k]) ? json_decode($_COOKIE[$k], true) : $_COOKIE[$k];

                        $_SESSION = self::readAll();

                        return $repository;
                } else {

                        if (count($_SESSION) && array_key_exists( $k, $_SESSION )) {

                                if ( count($_SESSION[$k] ) && array_key_exists( $sk,  $_SESSION[$k] ) ) {
                                        return $_SESSION[$k][$sk];
                                }
                        }
                        $repository = self::isJson($_COOKIE[$k]) ? json_decode($_COOKIE[$k], true) : $_COOKIE[$k];

                        $_SESSION = self::readAll();

                        return $repository;

                }
        }

        static function kills($k, $sk = NULL)
        {

                if (is_null($sk)) {

                        $_SESSION[$k] = NULL;
                        $_COOKIE[$k] = NULL;
                        unset($_SESSION[$k]);
                        unset($_COOKIE[$k]);
                        setcookie($k, null, -1, '/');

                        return true;
                }

                else {

                        if (!is_null($_SESSION[$k][$sk])) {

                                $_SESSION[$k][$sk] = NULL;

                                $cookieRep = self::isJson($_COOKIE[$k]) ?
                                        json_decode($_COOKIE[$k], true) :
                                        $_COOKIE[$k];

                                unset($cookieRep[$k][$sk]);

                                setcookie($k, json_encode($cookieRep), time() + REPOSITORY::LIFE, '/');
                        }

                }

        }

        static function killAll($withUserData = false){

                $ra = self::readAll();
                foreach ($ra as $index => $item) {
                      if( $index === self::CURRENT_USER && $withUserData ){
                              self::kills($index);
                      } else {
                              self::kills($index);
                      }
                }


        }

        static function readAll()
        {

                // highlight_string(var_export(unserialize( $_COOKIE ), true));
                if (count($_SESSION)) {
                        return $_SESSION;
                }
                $prettyCookie = array();
                if (count($_COOKIE)) {
                        foreach ($_COOKIE as $index => $item) {
                                $prettyCookie[$index] = self::isJson($item) ? json_decode($item, true) : $item;
                        }
                        $_SESSION = $prettyCookie;
                }

                return $prettyCookie;
        }

        static function isJson($string)
        {
                json_decode($string);
                return (json_last_error() == JSON_ERROR_NONE);
        }


}

class DEVICE_TYPE
{

        const IOS = "ios";
        const ANDROID = "android";

}

class MAIL
{
        const READ = 0;
        const DELETE = 1;

}

class ALERT_ACTION_STYLE
{
        const UIAlertActionStyleDefault = 0;
        const UIAlertActionStyleDestructive = 2;
}

class ANLASS
{
        const TRAINING = 1;
        const LIGASPIEL = 2;
        const POKALSPIEL = 3;
        const TESTSPIEL = 4;
        const BESPRESCHUNG = 5;
        const FEIER = 6;
        const EVENT = 7;
        const VERSAMMLUNG = 8;
        const TERMIN = 9;
        const TURNIER = 10;
}

/**
 * Class TEAMROLLE
 * @deprecated use instead of REGISTER_ROLE
 */
class TEAMROLLE
{
        const VORSTAND_1 = 1;
        const VORSTAND_2 = 2;
        const VORSTAND_3 = 3;
        const KASSIERER_1 = 4;
        const KASSIERER_2 = 5;
        const SCHRIFTFUHRER_1 = 6;
        const SCHRIFTFUHRER_2 = 7;
        const KASSENPRUFER = 8;
        const JUGENDLEITER = 9;
        const TRAINER = 10;
        const COTRAINER = 11;
        const TORWARTTRAINER = 12;
        const BETREUER = 13;
        const GEGNER = 14;
        const SPIELER = 15;
        const MITGLIED = 16;
        const DEVELOPER = 17;
}

class CLUB_MANAGER_ROLE {

        const ADMIN = 1;
        const DEPARTMENT_MANAGER_FOOTBALL = 2;
        const DEPARTMENT_MANAGER_ACTIVE = 3;
        const DEPARTMENT_MANAGER_YOUTH = 4;
        const DEPARTMENT_MANAGER_AH = 5;
        const DEPARTMENT_MANAGER_LADY = 6;
        const CUSTOM = 7;
}

class CONFIRMATION_TYPE {

        const TYPE_CONFIRMED    = 1;
        const TYPE_REJECTED     = 2;
        const TYPE_NOT_CHECKED  = 3;
}

/**
 * Class ADS_GROUPS
 * Ads groups Olusabilicek Reklam yada ilan gruplarinin ana bigilerini icerir
 * Bu degerler ads_groups_ tablosunda bulunur
 */
class ADS_GROUPS {

        const ADS_FRIENDSHIP_GAMES      = 1; // Freundschaftspiele
        const ADS_COMPETITION           = 2; // Turnier

}

/**
 * Class PLACE_COVERING
 * Alan Kaplamasi
 */
class PLACE_COVERING{

        const LAWN_PLACE                = 1; // Rasenplatz = 0;
        const ARTIFICIAL_TURF_COURT     = 2; // Kunstrasenplatz = 0;
        const HARD_COURT                = 3; // Hartplatz = 0;
        const HALL_HARD_COURT           = 4; // Hallenhartboden = 0;
}


class INQUIRY_TYPE{

        const INQUIRY_TYPE_KEY = "inquiry_type";
        const INQUIRY_PUBLIC = 1;
        const INQUIRY_TARGET = 2;

}

/**
 * Class SELECTABLE_TEAMS
 * Takimlar tabelesinde hangileri listelensin
 */
class LISTING_TEAMS {

        const KEY                       = "LISTING_TEAMS";
        const NONE_REGISTERED           = 0;
        const REGISTERED_VIA_TRAINER    = 1;
        const REGISTERED_VIA_CLUB       = 2;

}

/**
 * Class AD_SUGGETION
 * Ilan Zaman Onerileri
 */
class AD_SUGGETION{

        const EXCACT_TIME        = 1; // bestimmte Uhrzeit
        const IT_DOES_NOT_MATTER = 2; // egal
        const IN_THE_MORNING     = 3; // vormittags
        const AT_THE_LUNCHTIME   = 4; // mittags
        const IN_THE_AFTERNOON   = 5; // nachmittags
        const IN_THE_EVENING     = 6; // abends

}


class REGISTER_ROLE {

        const ROLE_BOARD_1 = 1; // VORSTAND
        const ROLE_BOARD_2 = 2; // VORSTAND
        const ROLE_BOARD_3 = 3; // VORSTAND

        const ROLE_CASHIERS_1 = 4;
        const ROLE_CASHIERS_2 = 5;

        const ROLE_SECRETARY_1 = 6;
        const ROLE_SECRETARY_2 = 7;

        const ROLE_AUDITORS = 8; // Kassenprüfer

        const ROLE_YOUTH_LEADER = 9; // Jugendleiter

        const ROLE_TRAINER = 10; // TRAINER
        const ROLE_CO_TRAINER = 11;
        const ROLE_TORWARTTRAINER = 12;

        const ROLE_SUPERVISOR = 13; // Betreuer

        const ROLE_OPPONENT = 14;

        const ROLE_PLAYER = 15;

        const ROLE_MEMBER = 16;

        const ROLE_DEVELOPER = 17;

        const ROLE_SUPER_ADMIN = 18;

        const ROLE_OTHER = 19;

        const ROLE_FUN = 20;

        const ROLE_FUN_VIP = 21;

        const ROLE_PLAYER_PARENT = 22;

        const ROLE_TRAINER_COMMUNITY = 23;

        const ROLE_LEGAL_GUARDIAN = 24; // Erziehungsberechtigte

        const ROLE_ATHLETIC_TRAINER = 25;

        const ROLE_OFFICER = 26; // Vorstandsmitglied

        const ROLE_GM = 27; // Spielleiter

        const ROLE_YOUTH_COORDINATOR = 28; // Jugendkoordinator

        const ROLE_CLUB_ADMIN = 29; // Admin Verein

        const ROLE_CLUB = 30;

}


class ANWESENHEIT
{
        const NONE = 0;
        const YES = 1;
        const MAYBE = 2;
        const NO = 3;
}

class PRESENCE_ICON
{

        const YES = "icon-thumbs-up3 text-success";
        const NO = "icon-thumbs-down3 text-danger";
        const MAYBE = "icon-question5 text-warning";
        const NONE = "icon-frustrated text-secondary";

}

class ACTIVITY
{

        const ACTIVITY = "activity";
        const ACTIVITY_UNWIND = 0;
        const ACTIVITY_LOGGED = 1;
        const ACTIVITY_ALERT_VIEW = 2;
        const ACTIVITY_IMAGE_VIEW = 3;
        const ACTIVITY_REDIRECT = 4;
        const ACTIVITY_SHARED = 5;
        const ACTIVITY_BOOTSTRAP = 6;
        const ACTIVITY_MAIN = 7;
        const ACTIVITY_1 = 8;
        const ACTIVITY_2 = 9;
        const ACTIVITY_3 = 10;
        const ACTIVITY_4 = 11;
        const ACTIVITY_5 = 12;
        const ACTIVITY_6 = 13;
        const ACTIVITY_7 = 14;
        const ACTIVITY_8 = 15;

        /*Last added*/
        const ACTIVITY_9 = 16;
        const ACTIVITY_10 = 17;
        const ACTIVITY_11 = 18;
        /*Last added*/




        const ACTIVITY_EXTERNAL = 19;//15;
        const ACTIVITY_BROWSER = 20;//16;
        const ACTIVITY_RESTART = 21;//17;
        const ACTIVITY_VIBRATE = 22;//18;

        /*Last added*/
        const ACTIVITY_HELPER_1 = 23;
        const ACTIVITY_HELPER_2 = 24;
        const ACTIVITY_HELPER_3 = 25;
        const ACTIVITY_HELPER_4 = 26;
        const ACTIVITY_HELPER_5 = 27;

        const ACTIVITY_ERROR = 28;

        /*Last added*/


        static function go($activity)
        {

                try {
                        $activityReflection = new ReflectionClass('ACTIVITY');
                        foreach ($activityReflection->getConstants() as $constant_name => $constant_value) {
                                if ($constant_value === $activity) {
                                        return (REPOSITORY::read(REPOSITORY::CURRENT_DEVICE) === DEVICE_TYPE::IOS ? $activity : $constant_name);
                                }
                        }

                } catch (ReflectionException $e) {
                }

                return "";
        }
}

class NATIVE_VIEW_ROLE
{
        const VIEW_ROLE_INTERNAL = "internal";
        const VIEW_ROLE_EXTERNAL = "external";
}


class MAIN_TABS
{

        const HOME = 0;
        const MEETING = 1;
        const USER = 2;
        const MESSAGE = 3;
        const MORE = 4;

}

class APP_ICON
{

        const ICON_SAVE = "floppy-disk";
        const ICON_RECYCLE_BIN = "bin5";
        const ICON_WHATSAPP = "whatsapp";
        const ICON_HISTORY = "history";


        const ICON_LIST = "ic_list";
        const ICON_CALENDAR = "ic_calendar";
        const ICON_MESSAGE = "ic_bell";
        const ICON_TEAM = "collaboration";
        const ICON_MATCH_DAY = "ic_soccer";
        const ICON_TABLE = "ic_table2";
        const ICON_DOCUMENT_PDF = "ic_file-pdf";
        const ICON_SETTINGS = "ic_wrench";
        const ICON_ADD = "plus3";
        const ICON_PLUS = self::ICON_ADD;
        const ICON_OK = "checkmark3";
        const ICON_CHECK_MARK = self::ICON_OK;
        const ICON_EDIT = "pencil7";
        const ICON_FILTER = "filter3";
}

class APPICON
{

        const I_RECYCLE = array("HTML_ENTITY" => "&#xec05", "CSS" => "\\ec06", "CLASS" => "bin2");
        const I_ADD     = array("HTML_ENTITY" => "&#xec05", "CSS" => "\\ec06", "CLASS" => "bin2");


}

/*
class NOTIFICATION{

        const TICKET    = "n_ticket";
        const TIMEZONE  = "n_timezone";
        const MESSAGE   = "n_message";
        const TIME      = "n_time";
        const REDIRECT_DATA     = "n_data";
        const REDIRECT_TAB      = "n_tab";
}
*/

class NOTIFICATION
{
        const X2DataForNotificationRedirectData = "N_REDIRECT_DATA";
        const X2DataForNotificationRedirectDataObject = "N_REDIRECT_WITH_OBJECT";
        const X2DataForNotificationRedirectDataIndex = "N_REDIRECT_WITH_TAB_INDEX";
        const X2DataForNotificationTitleKey = "N_TITLE";
        const X2DataForNotificationMessageKey = "N_MESSAGE";
        const X2DataForNotificationTimeKey = "N_TIME";
        const X2DataForNotificationTimeZoneKey = "N_TIMEZONE";
        const X2DataForNotificationTicketKey = "N_TICKET";
}

class SHARED_APPLICATION
{
        const X2SharedApplicationKey = "SHARED_INN_APP";
        const X2SharedApplicationAdsKey = "SHARED_ADS";
        const X2SharedApplicationFacebookKey = "SHARED_FACEBOOK";
        const X2SharedApplicationTwitterKey = "SHARED_TWITTER";
        const X2SharedApplicationWhatsAppKey = "SHARED_WHATSAPP";

}

/**
 * Variable Extension's
 * Example Variable image, with extension image_thumb
 */
class VAR_EXTENSION
{

        const THUMB = "_thumb";

}


const MEMBER_ABSENCE_TYPE_SICK = 2;                            // <- KRANK
const MEMBER_ABSENCE_TYPE_INJURED = 3;                         // <- VERLETZT
const MEMBER_ABSENCE_TYPE_HOLIDAY = 4;                         // <- URLAUB
const MEMBER_ABSENCE_TYPE_NO_TRAINING_PERMITS = 6;             // <- KEINE_TRAININGERLAUBNISSE
const MEMBER_ABSENCE_TYPE_NO_GAME_AUTHORITY = 7;               // <- KEINE SPIELBERECHTIGUNG
const MEMBER_ABSENCE_TYPE_SCHOOL_EVENTS = 8;                   // <- SCHULVERANSTALTUNG
const MEMBER_ABSENCE_TYPE_PRIVATE_EVENT = 9;                   // <- PRIVATTERMIN
const MEMBER_ABSENCE_TYPE_OTHER = 10;                          // <- SONSTIGES
const MEMBER_ABSENCE_TYPE_TRAINING_WITH_OTHER_TEAM = 11;       // <- TRAINING MIT ANDEREN TEAM
const MEMBER_ABSENCE_TYPE_PLAY_WITH_OTHER_TEAM = 12;           // <- SPIELT MIT ANDEREN TEAM
const MEMBER_ABSENCE_TYPE_TASKS_FOR_THE_SCHOOL = 13;           // <- AUFGABEN FÜR DIE SCHULE
const MEMBER_ABSENCE_TYPE_DFB = 14;                            // <- DFB


const MEMBER_PRESENCE_TYPE_IN_TIME = 16;                        // <- PÜNKTLICH
const MEMBER_PRESENCE_TYPE_NO_IN_TIME = 17;                     // <- UNPÜNKTLICH


/*
const MEMBER_PRESENCE_TYPE_NONE = NULL;                         // <- PÜNKTLICH
const MEMBER_PRESENCE_TYPE_UNKNOWN = 1;
const MEMBER_PRESENCE_TYPE_UNEXCUSED = 15;                      // <- UNENTSCHULDIGT
const MEMBER_PRESENCE_TYPE_WITH_OTHER_TEAM = 16;                // <- TRAINING WITH ANOTHER TEAM
*/

// Deprecated Constants
const MEETING_FEEDBACK_TYPE_UNKNOWN = 1;
const MEETING_FEEDBACK_TYPE_IN_TIME = 16;
const MEETING_FEEDBACK_TYPE_NOT_IN_TIME = 5;
const MEETING_FEEDBACK_TYPE_WITH_OTHER_TEAM = 11;               // <- TRAINING WITH ANOTHER TEAM
const MEETING_FEEDBACK_TYPE_DFB = 14;
const MEETING_FEEDBACK_TYPE_INJURED = 3;
const MEETING_FEEDBACK_TYPE_ENGAGED = 21;
const MEETING_FEEDBACK_TYPE_UNEXCUSED = 15;


// Deprecated Constants
/*const MEETING_FEEDBACK_TYPES = [
        MEETING_FEEDBACK_TYPE_NONE              => '--------',
        MEETING_FEEDBACK_TYPE_DFB               => 'DFB',
        MEETING_FEEDBACK_TYPE_UNEXCUSED         => 'Unent',
        MEETING_FEEDBACK_TYPE_INJURED           => 'Verlet',
];*/

const MEETING_LOCATION_TYPE_HOME = 0;
const MEETING_LOCATION_TYPE_AWAY = 1;
const MEETING_LOCATION_TYPE = [
        MEETING_LOCATION_TYPE_HOME => "Heim",
        MEETING_LOCATION_TYPE_AWAY => "(Auswärts)"
];


class EXTRAS_REDIRECT
{
        const REDIRECT_KEY = "redirect";
        const REDIRECT_FUSSBALLDE = 0;
        const REDIRECT_DOCUMENT = 1;
}

class VIEW_CONTROLLER
{

        const X2UINavigationBarBackgroundKey = "X2UINavigationBarBackground";
        const X2UINavigationBarBackgroundShow = 0;
        const X2UINavigationBarBackgroundHide = 1;

        const X2UINavigationBackButtonKey = "X2UINavigationBackButton";
        const X2UINavigationBackButtonShow = 0;
        const X2UINavigationBackButtonHide = 1;

}

class X2_USER_MENU
{
        const X2UserMenuMenuSlide = 2;
        const X2UserMenuMenuBottom = 1;
}


class TABLE_VIEW_SELECTED_REDIRECT{

        const REDIRECT_KEY = "REDIRECT_KEY";
        const TO_TEAMS_TABLE_VIEW = "TO_TEAMS_TABLE_VIEW";
        const TO_TEAM_GROUPS_TABLE_VIEW = "TO_TEAM_GROUPS_TABLE_VIEW";
        const TO_LEAGUES_TABLE_VIEW = "TO_LEAGUES_TABLE_VIEW";


}

class TEAM_SELECT_FOR{

        const TEAM_SELECT_FOR_KEY = "TEAM_SELECT_FOR_KEY";
        const ROLE = "ROLE";

}




