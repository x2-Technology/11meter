<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 2019-06-19
 * Time: 14:13
 */

class Zip_Codes
{
        protected static $instance = NULL;
        private static $db = NULL;

        private function __construct() {

                self::$db = new \PDO(
                        "mysql:host=" . Config::DB_Host . ";port=" . Config::DB_Port . ";dbname=" . Config::DB_Name
                        , Config::DB_Username //Config::DB_Username
                        , Config::DB_Password //Config::DB_Password
                        , array()
                );



        }



        static function getInstance(){

                    if( is_null(self::$instance) ){
                            self::$instance = new self;
                    }

                    return self::$instance;

        }


        function getEnvironmentAreasWithPostCode($sourceZipCodes = array(), $distance = 0){



                $resultingZipCodes = array();

                $getZcIdStmt = self::$db->prepare("SELECT zc_id
                        FROM zip_coordinates
                        WHERE zc_zip = :zip");
                $getZipList = self::$db->prepare("SELECT
                              dest.zc_zip,
                              dest.zc_location_name,
                              ACOS(
                                   SIN(RADIANS(src.zc_lat)) * SIN(RADIANS(dest.zc_lat))
                                   + COS(RADIANS(src.zc_lat)) * COS(RADIANS(dest.zc_lat))
                                   * COS(RADIANS(src.zc_lon) - RADIANS(dest.zc_lon))
                              ) * 6380 AS distance
                          FROM zip_coordinates dest
                          CROSS JOIN zip_coordinates src
                          WHERE src.zc_id = :zcid
                          AND dest.zc_id <> src.zc_id
                          HAVING distance < :distance
                          ORDER BY distance;");

                foreach ( $sourceZipCodes as $sourceZipCode ) {
                        $getZcIdStmt->execute(array(':zip' => $sourceZipCode));
                        $row = $getZcIdStmt->fetch();


                        $getZipList->execute(array(':zcid' => $row['zc_id'], ':distance' => $distance));
                        $zipList = $getZipList->fetchAll();

                        foreach ($zipList as $zipResult) {
                                if (!in_array($zipResult['zc_zip'], $resultingZipCodes)) {
                                        $resultingZipCodes[] = $zipResult['zc_zip'];
                                }
                        }
                }


                return (object) array(
                        "string"        => join(',', $resultingZipCodes),
                        "object"        => (object) $resultingZipCodes,
                        "array"         => $resultingZipCodes,

                );




        }







}