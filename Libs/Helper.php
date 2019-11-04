<?php

/**
 * Created by PhpStorm.
 * User: tSoftX
 * Date: 30/10/2016
 * Time: 02:45
 */
class Helper
{
      
      var $storage      = array();
      var $label        = array();
      var $lng_src      = Config::DEFAULT_LANGUAGE;
      
      public function __construct()
      {
            #echo $this->lng_src . ",";
      }
      
      public function __destruct()
      {
            // TODO: Implement __destruct() method.
      }
      
      function keyEncode($str)
      {
            
            return base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($str))))));
            
      }
      
      function keyDecode($str)
      {
            
            return base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($str))))));
            
      }



      static function JSONCleaned( $data ){

              switch (gettype($data)){
                      case "object":
                      case "array":
                              return htmlspecialchars(json_encode($data, JSON_UNESCAPED_UNICODE), ENT_QUOTES, "UTF-8");
                              break;
              }

              return htmlspecialchars( $data, ENT_QUOTES, "UTF-8" );
      }

        static function isJSON( $string ){
              try{
                      if( is_string($string) ){

                              $_ = array("array", "object");
                              $arr = json_decode($string);
                              return in_array( gettype($arr), $_);

                      } else {
                              return false;
                      }




              } catch (Exception $exc){
                      return false;
              }


        }


      function wordToUTF($str)
      {
            
            $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
            $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
            return str_replace($a, $b, $str);
            
      }



      
      function checkAndCreateClientFolder($folderName = NULL)
      {
            
            $folderName = rtrim(ltrim($folderName, "/"), "/");
            $folderName = explode("/", $folderName);
            
            $target_dir = Config::BASE_IMAGE_PATH;
            if (!file_exists($target_dir)) {
                  #highlight_string(var_export($target_dir, true));
                  mkdir($target_dir, 0777);
            }
            
            
            $target_dir = Config::BASE_IMAGE_PATH . $_SESSION["club"]->id . "/";
            if (!file_exists($target_dir)) {
                  #highlight_string(var_export($target_dir, true));
                  mkdir($target_dir, 0777);
            }
            
            
            #$target_dir = Config::BASE_IMAGE_PATH . $_SESSION["club"]->id . "/" . $f . "/" ;
            if (!is_null($folderName)) {
                  foreach ($folderName as $f) {
                        $finalFolder = $target_dir . $f . "/";
                        if (!file_exists($finalFolder)) {
                              #highlight_string(var_export($finalFolder, true));
                              mkdir($finalFolder, 0777);
                              $target_dir = $finalFolder;
                        } else {
                              $target_dir = $finalFolder;
                        }
                  }
            }
            
            
            if (file_exists($target_dir)) {
                  return $target_dir;
            }
            return die("No Target Folder found!");
            
            
      }
      
      /**
       * @deprecated reference on Public Class with diffrente params -> uploadFile
       * @param int $file_size Uploadable file size
       * @param null $file_path File will uploade determined file
       * @param null $file_obj_name File Input
       * @param string $uploaded_file_name File will uploaded with this name
       * @param string $uploaded_file_displayed_name File after uploaded displayed this name
       * @return string
       */
      function uploadFile($file_size = Config::MAX_UPLOAD_FILE_SIZE_KB, $file_path = NULL, $file_obj_name = NULL, $uploaded_file_name = "", $uploaded_file_displayed_name = "")
      {
            
            
            $target_dir = $this->checkAndCreateClientFolder($file_path);
            
            // highlight_string(var_export($_FILES, true));
            
            
            $real_target_file = $target_dir . basename($_FILES[$file_obj_name]["name"]);
            $imageFileType = pathinfo($real_target_file, PATHINFO_EXTENSION);
            $target_file = $target_dir . preg_replace('/\s+/', "", $uploaded_file_name) . "." . $imageFileType;
            $uploaded_base_filename = $uploaded_file_name . "." . $imageFileType;
            $uploadOk = 1;
            // Check if image file is a actual image or fake image
            
            $check = getimagesize($_FILES[$file_obj_name]["tmp_name"]);
            if ($check !== false) {
                  $m = "File is an image - " . $check["mime"] . ".";
                  $uploadOk = 1;
            } else {
                  $m = "File is not an image.";
                  $uploadOk = 0;
            }
            
            // Check if file already exists
            if (file_exists($target_file)) {
                  // echo "Sorry, file already exists.";
                  // $uploadOk = 0;
            }
            // Check file size
            if ($_FILES[$file_obj_name]["size"] > $file_size) {
                  $m = "Sorry, your file is too large. 
                  File is:" . $file_size . "KB, Max file size " . \Config::MAX_UPLOAD_FILE_SIZE_KB . "KB.";
                  $resultaLogo = false;
                  $uploadOk = 0;
            }
            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif"
            ) {
                  $m = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                  $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                  #$return =  "Sorry, your file was not uploaded.";
                  // if everything is ok, try to upload file
            } else {
                  if (move_uploaded_file($_FILES[$file_obj_name]["tmp_name"], $target_file)) {
                        $uploadOk = 1;
                        $m = "The file {$uploaded_file_displayed_name} has been uploaded.";
                  } else {
                        $uploadOk = 0;
                        $m = "Sorry, there was an error uploading your file.";
                  }
            }
            
            return array(
                "resulta" => $uploadOk,
                "message" => $m,
                "filename" => $uploaded_base_filename
            );
            
            
      }
      
      
      static function passwordGenerator($pw = NULL, $length = 5)
      {
            $to = 9;
            $from = 0;
            for ($i = 1; $i < $length; $i++) {
                  $to .= 9;
                  $from .= "0";
            }
            
            $from = 1 . $from;
            $from = substr($from, 0, strlen($from) - 1);

            if( !is_null($pw) && !empty($pw) ){

                    if( trim(strlen($pw)) > 0  ){
                            $pass = $pw;
                    }

            } else {
                    $pass = rand(intval($from), $to);
            }

            return (object)array(
                "base" => $pass,
                "md5" => md5($pass)
            );
      }


        static function prettyTelNumberFormat($number)
        {
                return $mobile = preg_replace('/\s+|^0+|^\++|[.,!$@]/', '', $number);
        }

        // SMS Send able with after specific time
        static function sentCodeMitInterval( $time = NULL ){

                if( !is_null($time) ){

                        // echo $time;
                        $sentDate       = strtotime($time);
                        $now            = strtotime(date("Y-m-d H:i:s"));
                        $diff = $sentDate - $now;
                        #highlight_string(var_export($diff, true));
                        return array(
                            "sent"=> $diff < 0 ,
                            "in_min"=> floor($diff / 60)  . ".min und ". $diff % 60 . ".sec",
                            "next_time" => $time,
                                "now"=>date("Y-m-d H:i:s")
                        );


                }

                return array(
                    "sent"=>true,
                    "in_min"=>0
                );



        }


      function createSecretEmail($string)
      {
            
            $email = explode("@", $string);
            $emailName = $email[0];
            $emailDomain = $email[1];
            $emailDomainExt = pathinfo($emailDomain, PATHINFO_EXTENSION);
            $emailDomain = preg_replace("/.{$emailDomainExt}/", NULL, $emailDomain);
            
            
            /*echo $emailName . "<br />";
            echo $emailDomain . "<br />";
            echo $emailDomainExt . "<br />";*/
            $secretEmail = array();
            
            $combination = array($emailName, "@", $emailDomain, ".", $emailDomainExt);
            
            foreach ($combination as $comb) {
                  
                  // echo $comb . "<br />";
                  
                  if ($comb !== "@" && $comb !== ".") {
                        $maxShowChar = 3;
                        $len = strlen($comb);
                        $parse = array();
                        for ($i = 0; $i < $len; $i++) {
                              $show = 3;// rand(0,999) % 2;
                              if ( /*$show < $i &&*/
                                  $maxShowChar > $i
                              ) {
                                    array_push($parse, $comb[$i]);
                              } else {
                                    array_push($parse, "*");
                              }
                              // $maxShowChar++;
                        }
                        
                        array_push($secretEmail, implode("", $parse));
                        
                  } else {
                        array_push($secretEmail, $comb);
                  }
            }
            
            return implode("", $secretEmail);
            
      }
      
      function createTempLink()
      {
            
            $today = new DateTime();
            
            return md5($today->format('d.m.Y H:i:s'));
            
            
      }
      
      
      function showUserMessage( $message, $style = Defaults::MESSAGE_SUCCESS, $dismissible = true, $messageID = "")
      {
            
            $dismissible_class = $dismissible ? "alert-dismissable" : "";
            
            $ret = "<div class=\"alert alert-{$style} fade in {$dismissible_class}\">";
            if ($dismissible) {
                  $ret .= "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\" title=\"close\">×</a>";
            }
            if (Config::DEVELOPER_MODE && !empty($messageID)) {
                  $ret .= "<span class='title pull-right'>({$messageID})</span>";
            }
            $ret .= $message;
            $ret .= "</div>";
            
            return $ret;
            
            
      }
      
      function dateFormat($date, $toMySQL = false)
      {
            
            if (!is_null($date) || !empty($date)) {
                  if ($toMySQL) {
                        $date = date_create($date)->format(Config::DATE_MYSQL_FORMAT);
                  } else {
                        $date = date_create($date)->format(Config::S_DATE_FORMAT);
                  }
                  # $date = DateTime::createFromFormat( 'Y-m-d', $date );
                  # $date = $date->format(Config::DATE_FORMAT);
                  return $date;
            } else {
                  return NULL;
            }
      }
      
      
      function checkSession()
      {
            
            $storage = new Storage();
            if (!$storage->read("logged")) {
                  header("Location: /Error/!/session_expired");
                  exit();
            }
            return true;
            
      }

    function accessWithLogin( $class )
    {
            // highlight_string(var_export($class, true));
        $storage = new Storage();
        if (!$storage->read("logged")) {

            $cls = new ReflectionClass( $class );
            
            #highlight_string(var_export($cls->getNamespaceName(), true));
            
            if( !empty($cls->getNamespaceName())){
                $key = $cls->getShortName() . "." . $cls->getNamespaceName();
            } else {
                $key = $cls->getShortName();
            }

            // highlight_string(var_export($key, true));
            // highlight_string(var_export(Config::LOGIN_REQUIRED_CLASSES, true));
            
            if( in_array( $key, Config::LOGIN_REQUIRED_CLASSES ) ){
                  
                return false;

            }
        }
        return true;

    }

    


      
      /**
       * @param $language $ User Language
       * @param $folder $ Text File Folder Path
       * @param $file $ File Name
       * @param $ext $ File Extension Default Text File
       * @param array $replaceWords $ Replacement Words in Array Key and Value
       * @return string $ Return as File content
       */
      function readFileContent($language, $folder, $file, $ext = "txt", $replaceWords = array() )
      {
            
            $path = Config::BASE_APP_SOURCE_PATH . "{$folder}/{$language}/{$file}.{$ext}";          // <- File With Language

            // $path = "../sources/{$folder}/{$language}/{$file}.{$ext}";          // <- File With Language
            if (!file_exists($path)) {
                  $path = Config::BASE_APP_SOURCE_PATH . "{$folder}/en/{$file}.{$ext}";     // <- Default file
                  // $path = "../sources/{$folder}/en/{$file}.{$ext}";     // <- Default file
            }
            
            $o = "";
            if (file_exists($path)) {
                  
                  switch ($ext) {
                        
                        case "json":
                              
                              $o = file_get_contents($path);
                              $o = json_decode($o, true);
                              
                              break;
                        
                        
                        case "text":
                        case "txt":
                        case "twig":

                              $path = fopen($path, 'r');
                              while (!feof($path)) {
                                    $o .= fgets($path) . "<br />";
                              }
                              fclose($path);
                              
                              // Replacement on String
                              if (count($replaceWords)) {
                                    foreach ($replaceWords as $index => $replaceWord) {
                                          
                                          $o = preg_replace('/\[' . $index . '\]/', $replaceWord, $o);
                                          
                                    }
                              }
                              
                              
                              $o .= "<br />\nFile Code:" . $file;
                              
                              
                              break;
                        
                        
                  }
                  
                  
            } else {
                  
                  $o = "No file found! {$path}";
                  
                  
            }

            // $o = preg_replace('/\<br \/\>/', '', $message);
            
            
            return $o;
            
      }
      
      function createPopoverWithDynamicData( $popoverID, $string = NULL, $icon = NULL, $iconPos = "l" )
      {
      
            if( is_null($string) && is_null( $icon ) ){
                  
                  
            }
            
            else {
      
                  $popoversContent = $this->readFileContent(
                      $this->lng_src,
                      "Texts/Toggle",
                      "popover",
                      "json",
                      array()
                  )[$popoverID];
                  
                  $title = "<span class=\"pull-left\">" . $popoversContent[0] . "</span><span class=\"pull-right text-info bg-info\" >{$popoverID}</span>";
      
                  if( is_null($string) && !is_null($icon) ){
                        return "<i data-custom-class='popover-custom' class='glyphicon icon icon-info' data-toggle='popover' title='{$title}' data-html='true' data-content='{$popoversContent[1]}' ></i>";
                  }
                  else if( !is_null($string) && is_null($icon) ){
                        return "<span class='glyphicon icon icon-{$icon}' data-toggle='popover' title='{$popoversContent[0]}' data-content='{$popoversContent[1]}' ></span>";
                  }

                  else if( !is_null($string) && !is_null($icon) ){
                        return "<span class='glyphicon' data-toggle='popover' title='{$popoversContent[0]}' data-content='{$popoversContent[1]}' ><i class='icon icon-{$icon}' ></i> {$string}</span>";
                  }
      
                  
                  
                  
            }
            
            
            
      }
      
      
      function getPageHeader($data)
      {
            
            // $o = "<h1 class='mb-30'>{$data}</h1>";
            $o = "<h1 class=\"bd-title mb-20 pb-10\" style=\"border-bottom: 1px solid #CCCCCC;\" id=\"content\">{$data}</h1>";
            return $o;
            
      }
      
      function hashGenerate($key = null)
      {
            return base64_encode(date("Ymdhis") . rand(0, 9999) . $key);
      }
      
      
      function encodeTokenWithExpired($plus = "+2 minute")
      {
            
            $myIp = $this->getUserIP();
            $now = strtotime(date("d.m.Y H:i:s"));
            $expiredAt = strtotime(date("d.m.Y H:i:s") . " {$plus}");
            
            $_array = array(
                "ip" => $myIp,
                "expired" => $expiredAt
            );
            
            return base64_encode(base64_encode(base64_encode(json_encode($_array))));
      }
      
      function decodeTokenWithExpired($string = null)
      {
            return (object)json_decode(base64_decode(base64_decode(base64_decode($string))), true);
      }
      
      
      function getUserIP()
      {
            $client = @$_SERVER['HTTP_CLIENT_IP'];
            $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
            $remote = $_SERVER['REMOTE_ADDR'];
            
            if (filter_var($client, FILTER_VALIDATE_IP)) {
                  $ip = $client;
            } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
                  $ip = $forward;
            } else {
                  $ip = $remote;
            }
            
            return $ip;
      }
      
      
      function isTokenExpired($string)
      {
            
            $string = $this->decodeTokenWithExpired($string);
            
            $string->d = $string->ip !== $this->getUserIP() && $string->expired < strtotime(date("d.m.Y H:i:s"));
            $string->exp = $string->expired < strtotime(date("d.m.Y H:i:s"));
            $string->ipl = $string->ip === $this->getUserIP();
            
            // highlight_string(var_export($string, true));
            
            if ($string->ip === $this->getUserIP()) {
                  
                  if ($string->expired < strtotime(date("d.m.Y H:i:s"))) {
                        return true;
                  }
                  
                  return false;
                  
            } else {
                  
                  return true;
                  
            }
            
            // return true;
            
            // return $string->ip === $this->getUserIP() && $string->expired < strtotime(date("d.m.Y H:i:s"));
      }
      
      function createExpiredTime($time, $interval)
      {
            return date($time, strtotime($interval));
            
      }
      
      
      function setLastRequestedPage($url = "")
      {
            $this->storage->write("SYSTEM", "last_requested_page", $url);
      }
      
      function getLastRequestedPage()
      {
            return $this->storage->read("SYSTEM")->last_requested_page;
      }
      
      function killLastRequestedPage()
      {
            return $this->storage->kill("SYSTEM");
      }
      
      
      function testDataOutput($data = array(), $output = Config::TEST_OUTPUT_OUT)
      {
            
            
            if ($output) {
                  return highlight_string(var_export($data, true));
            }
            
            return null;
            
      }
      
      /**
       * @param $data
       * @param $title
       * @param $message
       * @return array
       *
       * JQUERY input check Methods output yardimci
       */
      
      function prepareResponseVariableForInputCheck( $data, $title, $message )
      {
            return array(
                "found" => count($data),
                "alertTitle" => $title,
                "alertMessage" => $message
            );
            
      }

    function idEncoder($id)
    {
        return base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($id)))))))));
    }

    function idDecoder($hash)
    {
        $hash = preg_replace('/ /', null, $hash);
        return base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($hash)))))))));
    }

}