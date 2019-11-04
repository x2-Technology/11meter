<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 15.10.18
 * Time: 15:00
 */
// include "Libs/Frameworks/Weather/vendor/autoload.php";
include "vendor/autoload.php";
// print_r(scandir(getcwd()));

use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;
class Weather
{
        private $apiKey         = "1429da67897be6f9f0942b6466f02956";
        private $lang           = "en";
        private $units          = "metric";

        /**
         * @return string
         */
        public function getUnits()
        {
                return $this->units;
        }

        /**
         * @param string $units
         */
        public function setUnits($units)
        {
                $this->units = $units;
        }

        /**
         * @return string
         */
        public function getLang()
        {
                return $this->lang;
        }

        /**
         * @param string $lang
         */
        public function setLang($lang)
        {
                $this->lang = $lang;
        }

        private $owm    = null;
        /**
         * @return null|string
         */
        public function getApiKey()
        {
                return $this->apiKey;
        }

        /**
         * @param null|string $apiKey
         */
        public function setApiKey($apiKey)
        {
                $this->apiKey = $apiKey;
        }

        function __construct( $apiKey = null ) {

                if( !is_null($apiKey) ){
                        $this->setApiKey($apiKey) ;
                }

                $this->owm = new OpenWeatherMap( $this->getApiKey() );


        }


        function getWeather( $cityName ){

                // highlight_string(var_export($this->getForecastDataIn5DayWithDateAndTime($cityName, "2018-10-19"), true));
                
                try {
                        // echo $this->getApiKey();
                        // $data = $this->owm->getRawHourlyForecastData( $cityName, $this->getUnits(), $this->getLang(), $this->getApiKey(), 'json' );
                        $data = $this->owm->getWeather( $cityName, $this->getUnits(), $this->getLang(), $this->getApiKey() );
                        // return $this->owm->getWeatherForecast( $cityName, $this->getUnits(), $this->getLang(), $this->getApiKey(), 1 );
                        return $data;

                } catch(OWMException $e) {
                        echo 'OpenWeatherMap exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
                } catch(Exception $e) {
                        echo 'General exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
                }
        }

        // Need Payment
        function getDailyWeatherForecast( $cityName, $dayNumber ){

                #echo $this->getApiKey();

                try {

                        return $this->owm->getDailyWeatherForecast( $cityName, $this->getUnits(), $this->getLang(), $this->getApiKey(), $dayNumber );

                } catch(OWMException $e) {
                        echo 'OpenWeatherMap exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
                } catch(\Exception $e) {
                        echo 'General exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
                }
        }


        // Next 5 Day's every 3 hours
        function getRawHourlyForecastData( $cityName ){

                try {

                        $data = $this->owm->getRawHourlyForecastData( $cityName, $this->getUnits(), $this->getLang(), $this->getApiKey(), 'json' );
                        echo $data;
                        $data = simplexml_load_string($data);
                        highlight_string(var_export($data, true));
                        return $data;

                } catch(OWMException $e) {
                        echo 'OpenWeatherMap exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
                } catch(\Exception $e) {
                        echo 'General exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
                }


        }

        // Custom time in 5 Days
        function getForecastDataIn5DayWithDateAndTime( $cityName, $datetime ){

                try {

                        $today          = new DateTime();
                        $targetDate     = new DateTime($datetime);
                        $diff =         $targetDate->diff($today)->format("%d");

                        if( $diff <= 5 ){

                                $data = $this->owm->getRawHourlyForecastData( $cityName, $this->getUnits(), $this->getLang(), $this->getApiKey(), 'json' );
                                #highlight_string(var_export($data, true));
                                $data = json_decode($data, true);
                                // $data = simplexml_load_string($data);
                                $list =  $data["list"];


                                if ( count($list) ){
                                        return $this->closest( $list, $datetime );
                                }
                        }


                        return null;

                } catch(OWMException $e) {
                        echo 'OpenWeatherMap exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
                } catch(\Exception $e) {
                        echo 'General exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
                }


        }

        function closest ( $list , $lookFor )
        {
                $distances = array ( ) ;

                foreach ( $list as $num )
                {
                        $distances [ abs (  strtotime($num["dt_txt"]) - strtotime($lookFor) ) ] = $num ;
                }

                $minKey = min(array_keys($distances));

                return $distances [ $minKey ] ;

        }



}