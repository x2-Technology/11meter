<?php
session_start();
/**
 * Created by PhpStorm.
 * User: tSoftX
 * Date: 02/02/2017
 * Time: 22:23
 */
#echo phpinfo();
include "Bootstrap.php";
$bs = new Bootstrap();
echo $bs->output();