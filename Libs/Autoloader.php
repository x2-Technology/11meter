<?php

/**
 * Created by PhpStorm.
 * User: tSoftX
 * Date: 11/02/2017
 * Time: 22:16
 */
class Autoloader
{
    function __construct() {

        include "Libs/Texts.php";
        include "Libs/Config_Manager.php";
        include "Libs/Constant.php";
        include "Libs/Defaults.php";
        include "Libs/Controller_Extends.php";
        include "Libs/Controller.php";
        include "Libs/_Public_Extends.php"; // Implement for Public Class
        include "Libs/Model_Extends.php";
        include "Libs/Model.php";
        include "Libs/View.php";
        include "Libs/Config.php";
        include "Libs/ViewController.php";
        include "Libs/RedirectViewController.php";
        include "Libs/LOX24.php";
        include "Libs/Database_Helper.php";
        include "Libs/Database.php";
        include "Libs/Helper.php";
        include "Libs/Storage.php";
        include "Libs/Email.php";
        include "Libs/Zip_Codes.php";

    }
}