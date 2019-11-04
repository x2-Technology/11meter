<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 11.02.19
 * Time: 11:18
 */

class TEXT_LANGUAGE{
        const LANGUAGE_GERMAN = "de";
        const LANGUAGE_ENGLISH = "en";
}

class TEXT_GROUPS{
        const GROUP_INFORMATION = "Information";
}

class TEXT_FILES{
        const FILE_WAIT_FOR_PUBLIC = "waitforpublic";
}

class FILE_EXTENSIONS{
        const FILE_EXTENSION_TXT = "txt";
        const FILE_EXTENSION_JSON = "json";
}


class Texts
{
        function __construct() {
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

                $path = "Texts/" . strtolower($language) . "/{$folder}/{$file}.{$ext}";

                if (!file_exists($path)) {

                        $path = "Texts/en/{$folder}/{$file}.{$ext}";

                        if (!file_exists($path)) {
                                $path = "Texts/en/nofile.txt";
                        }

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

                                        $path = fopen($path, 'r');
                                        while (!feof($path)) {
                                                $o .= fgets($path) . "<br />";
                                        }
                                        fclose($path);

                                        // Replacement on String
                                        if (count($replaceWords)) {
                                                foreach ($replaceWords as $index => $replaceWord) {

                                                        $o = preg_replace('/\%' . $index . '\%/', $replaceWord, $o);

                                                }
                                        }


                                        $o .= "<br />\nFile Code:" . $file;


                                        break;


                        }


                } else {

                        $o = "No file found! {$path}";


                }

                return $o;

        }




        public function __destruct()
        {
                // TODO: Implement __destruct() method.
        }
}



