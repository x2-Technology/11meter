<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 16.10.18
 * Time: 21:17
 */

abstract class Controller_Extends
{
        abstract public function contentHeader( $data = array() );
        abstract public function weatherNow( $city );
        abstract public function weatherIn5DayWithDateAndTime( $city, $datetime );

}