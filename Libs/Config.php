<?php

/**
 * Created by PhpStorm.
 * User: tSoftX
 * Date: 04/02/2017
 * Time: 02:47
 */
class Config
{

        const TEMPLATE = "default";



        const MYSQL_CONN_TIMEOUT = 60; // As Second

        /*
        const DB_Provider       = "MySQL";
        const DB_Username       = "dbo728089551";
        const DB_Name           = "db728089551";
        const DB_Password       = "";
        const DB_Host           = "db728089551.db.1and1.com";
        const DB_Port           = 3306;
        */

        // TEMPORARY CONNECTION DATA
        const DB_Provider   = "MySQL";
        const DB_Username   = "11meter";
        const DB_Name       = "11meter_";
        const DB_Password   = "";

        /* DEDICATE */
        /*
        const DB_Host       = "87.106.111.225";
        const DB_Port       = 3307;*/

        /*CLOUD*/
        const DB_Host       = "217.160.40.237";
        const DB_Port       = 3306;


        #------------------------------------------------
        #const LOGIN_HEADER = "Location: ../Pages.php?cnt=Login&mtd=Body";
        // const LOGIN_HEADER  = "Location: /Login/Output";
        // const MAIN_HEADER   = "Location: /Main/Output";


        const DEFAULT_LANGUAGE = "en";

        #------------------------------------------------
        const MAX_PROTOCOL_LENGTH = 1000; // Max Lenght protocols
        #------------------------------------------------
        const TIME_FORMAT   = "H:I";
        const S_DATE_FORMAT = "d.m.Y";
        const L_DATE_FORMAT = "d.m.Y - H:i:s";
        const DATE_MYSQL_FORMAT = "Y-m-d";
        #-------------------------------------
        const LOGOUT_TIME = 3600; // Seconds
        const SOFTWARE_VERSION = 2.1;
        // const FETCH_OBJ = "OBJ";
        const APP_NAME = "11meter.app";


        const SITE_TITLE = "Deutsche Fussball App";
        // const UPLOAD_PATH = "test_upload";
        const MAX_UPLOAD_FILE_SIZE_KB = 10000;

        const SHOW_DISPLAY_ERRORS = true;
        #const SHOW_PHP_ERRORS_WITH = E_ERROR | E_WARNING | E_STRICT |E_ALL ; // E_ERROR | E_STRICT | E_WARNING | E_ALL;
        const SHOW_PHP_ERRORS_WITH = E_ERROR | E_WARNING; // E_ERROR | E_STRICT | E_WARNING | E_ALL;

        const DEVELOPER_MODE = true;
        const DEVELOPER_PASSWORD = "1bdb4b64f7469c257b70097629ac6fe5";
        // const SV_PASSWORD = "1bdb4b64f7469c257b70097629ac6fe5";

        #const PAYMENT_SERVICE_OPEN = false;

        const TEST_OUTPUT_OUT = false;

        // const USE_GOOGLE_CAPTCHA = false;

        // const USER_PASSWORD_MIN_LENGTH = 5;


        // const COMPANY_BASE_UPLOAD_PATH = array("company", "[customer_id]",);
        // const CERTIFICATES_UPLOAD_PATH = "certificates";

        const BASE_IMAGE_PATH           = "images/";
        const BASE_URL                  = "https://app.11meter.app";
        // const BASE_URL                  = "https://app.11meter.local:8888";

        const CLUB_DOCS_BASE_URI        = "http://documents.11meter.app/clubs";
        const WEATHER_ICON_BASE_URL     = "http://openweathermap.org/img/w";


        const CLUB_FOLDER_MEMBER        = "members/";
        const CLUB_FOLDER_ADS           = "advertisement/";
        const CLUB_FOLDER_DOCS          = "docs/";

        const BASE_APP_SOURCE_PATH      = "Libs/"; // App helper files for example Tac s

        const LOGIN_REQUIRED_CLASSES = array(

            "Certificate.csform",
                // "_Public",
            "Messages"

        );


        const SMS_SEND_AGAIN_IN_INTERVAL = "3 Hours";



}

