<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 14.10.18
 * Time: 21:25
 */

class Weather
{

        private $key = null;
        function __construct() {
            $this->key = "1429da67897be6f9f0942b6466f02956";
        }

        function get( $city ){



                if(isset($city))
                {
                        $url = 'http://openweathermap.org/data/2.1/find/name?q='.urlencode($city).'&cnt=1&lang=de';

                        $curl = curl_init();
                        $headers = array();
                        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($curl, CURLOPT_HEADER, 0);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_URL, $url);
                        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
                        $json = curl_exec($curl);
                        curl_close($curl);

                        $data = json_decode($json);

                        if(!empty($data->list[0]->name)) {
                                ?>
                                <div>
                                        Stadt: <strong><?php echo $data->list[0]->name ?></strong><br />
                                        Aktuell:  <strong><?php echo number_format($data->list[0]->main->temp - 273.15, 1, ',', '') ?> ° C </strong><br />
                                        Temperatur (heute):<br />
                                        min. <?php echo number_format($data->list[0]->main->temp_min - 273.15, 1, ',', '') ?> ° C<br />
                                        max. <?php echo number_format($data->list[0]->main->temp_max - 273.15, 1, ',', '') ?> ° C
                                </div>
                                <?php
                        }
                }

        }


}