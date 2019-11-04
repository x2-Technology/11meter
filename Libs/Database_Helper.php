<?php

/*
 * Class all database proccess
 * Author:Süleyman Topaloglu
 * Created at:31.01.2014
 * Vertion:1.0
 */

class Database_Helper
{

        const ORDER_ASC         = "ASC";
        const ORDER_DESC        = "DESC";

        /*
         * Database
         */
        public $db = null;


        /** Table name of Database */
        // protected $table     = null;
        protected $tblName = null;
        protected $dbName = null;


        public $showErrorWithThrow = false;


        /*
         * Table name of Database
         */
        // public $table = null;

        /*
         * No Information
         */
        public $fields = array();


        var $assign = array();

        var $limit = array();

        /*
         * MySQL WHERE statesment prepare
         */
        var $where;

        var $orderBy = null;

        /**
         * <b>for statesment<br />
         * default always use;<br />
         * but if statesment only GROUP OR LIMIT requested <br />
         * then not nesseccery<br />
         * <br />
         * Use Default <br />
         * WHERE id=? ("AND,OR" or nothing assinger) "GROUP BY....."<br />
         * <br />
         * if not WHERE using than  by setConditionSpecial()<br />
         * FROM table "GROUP BY .... , LIMIT ....." can be use<b>
         */
        var $useWHERE = true;

        // Post extra variable with return
        var $extras = array();

        /**
         *
         * @var type
         * <b>Set Query condition<b>
         */
        protected $condition;

        /**
         * <b>query for Custom Query string<b>
         */
        protected $query = null;

        /**
         * <b>return Mysql Last Inserted id <b>
         */
        var $lastInsertId = null;


        /**
         * <b>select colums name as string<br />
         * delimiter by , *<b>
         */
        var $select = ""; //

        /**
         * <b>Default by single return of query<br />
         * without key<br />
         * example <br />
         * {"name":"xxx","surname":"xxx"}<br />
         * With <br />
         * $singleValueWithKey = TRUE ;<br />
         * return example<br />
         * {"195":{"name":"xxx","surname":"xxx"}}<b>
         */
        protected $singleValueWithKey = FALSE;


        /**
         * @var array
         * Future need For Update
         * INSET ON DUPLICATE UPDATE
         * Update for Table only desired columns for Table, or All Columns if array empty
         */
        private $updateColsByInsert = array();

        /**
         * @return array
         */
        public function getUpdateColsByInsert()
        {
                #print_r($this->updateColsByInsert);
                if( count($this->updateColsByInsert) ) {
                        return $this->updateColsByInsert;
                }

                return NULL;
        }

        /**
         * @param array $cols
         * @return string
         * This Future need INSERT ON DUPLICATE KEY ( UPDATE )
         */
        public function setUpdateColsByInsert( $updateColsByInsert = array() )
        {
                unset($this->assign["output"]);

                #print_r($updateColsByInsert);

                if( count($updateColsByInsert) ){

                        // Selected Assigned Cols
                        foreach ($this->assign as $key => $value) {
                                if( in_array($key, $updateColsByInsert) ){
                                        // $output .= $key . "=" . $this->typeof(gettype($value), $value) . ",";
                                        array_push($this->updateColsByInsert, $key . "=" . $this->typeof(gettype($value), $value));
                                }
                        }

                } else {

                        // All Assigned Cols
                        foreach ($this->assign as $key => $value) {
                                array_push($this->updateColsByInsert, $key . "=" . $this->typeof(gettype($value), $value));
                        }
                }


        }

        /**
         * @return mixed
         */
        public function getSingleValueWithKey()
        {
                return $this->singleValueWithKey;
        }

        /**
         * @param mixed $singleValueWithKey
         */
        public function setSingleValueWithKey($singleValueWithKey)
        {
                $this->singleValueWithKey = $singleValueWithKey;
        }

        // fetched Data set row key for fetches
        private $rowKey = "id";

        /**
         * @return string
         */
        public function getRowKey() { return $this->rowKey; }

        /**
         * @param string $rowKey
         */
        public function setRowKey($rowKey) { $this->rowKey = $rowKey;}



        // Eger Donen Deger Tek ise bu diziye key eklensin mi?

        /**
         *
         * @var Boolean <b>$executedQueryDataBack queryExecute() Yapilmadan önce bildirilir
         * <br /> Default FALSE'dir, TRUE ise o query'nin degerleri döner yani Data, Count vb. , degilse sadece query clistirilir
         * <b>
         */
        var $executedQueryDataBack = FALSE; //

        var $dataFromExecutedQuery = null;

        /**
         * <b>Set Query String Or Get Query String Only For Information string</b>
         */

        private $getQueryString = null;


        protected $queryString = null;


        // MYSQL_PDO Get Returns

        var $getFile;
        var $getLine;
        var $getMessage;
        var $getPrevious;
        var $getTrace;
        var $getTraceAsString;

        var $errInfo;
        var $errCode;
        var $PDOError = "";

        // var $fetch_style = "ASSOC";

        private $fetchType = FETCH_TYPE::ASSOC;

        /**
         * @return int
         */
        public function getFetchType()
        {
                return $this->fetchType;
        }

        /**
         * @param int $fetchType
         */
        public function setFetchType( $fetchType )
        {
                $this->fetchType = $fetchType;
        }

        private $fetchStructure = FETCH_STRUCTURE::FETCH_ARRAY;

        /**
         * @return int
         */
        public function getFetchStructure()
        {
                return $this->fetchStructure;
        }

        /**
         * @param int $fetchStructure
         */
        public function setFetchStructure(FETCH_STRUCTURE $fetchStructure)
        {
                $this->fetchStructure = $fetchStructure;
        }





        // setCondition Binding option
        const C_NULL = "";
        const C_OR = "OR";
        const C_AND = "AND";

        // MYSQL Default Data Fetch
        const DATA_FETCH = PDO::FETCH_ASSOC;


        // Module name
        var $moduleName = "";

        // Module Description
        var $moduleDescription = "";

        var $resultaFromCustomQuery = "";

        // database resulta storage
        var $resulta = false;

        // Database Process if Update delete insert was successful or error
        var $process = false;


        var $PDOExeption = null;


        function __construct()
        {

        }

        function __destruct()
        {
                // $this->setReturnedSingleValueWithKey();
        }

        /**
         * @param $key <p>Database'de Colon ismi<br/>
         * @param $value <p>Colona girecek deger bu deger 0 yada NULL</p>
         * <br/>
         * @return array <b>$key => $value</b>
         * Set ile Myslq Inseer ve edit Icin colonlar ve degerleri Hazirlanir
         */
        function set($key, $value)
        {

                // Filter and Kill, Base Params 'returnforjquery'
                if ($key === "returnforjquery") return false;


                if ($value === TRUE || $value === 1 || $value === "true" || $value === "TRUE") {
                        $value = 1;
                } elseif ($value === FALSE || $value === 0 || $value === "false" || $value === "FALSE") {
                        $value = 0;
                } elseif (empty($value) || !isset($value)) {
                        $value = "NULL";
                }

                $this->assign[$key] = trim($value);
        }



        function clearVariables()
        {
                $this->assign = array();
        }


        /**
         * @param $typeof <p>TypeOf deferi gettype methodu kullanilarak gonderilen Array key e gonderilen deger</p>
         * @param $value <p>Geri Dönüsüm yapilacak deger MYSQL'e nasil yazilacak</p>
         */
        function typeof($typeof, $value)
        {

                // Check out of the value have content integer ?
                if (ctype_digit($value)) {
                        // Change header to Integer for Stwitch
                        $typeof = "integer";
                        // Convert String-Integer to Integer
                        $value = intval($value);
                }

                // On/Off to true/False
                if ($value === "on") {
                        // Change header to Integer for Stwitch
                        $typeof = "boolean";
                        // Convert String-Integer to Integer
                        $value = true;
                }

                $output = "";
                switch ($typeof) {
                        case 'boolean':
                                $output = $value;
                                break;
                        case 'integer':
                                $output = $value;
                                break;
                        case 'double':
                                $output = $value;
                                break;
                        case 'array':
                                break;
                        case 'object':
                                break;
                        case 'resource':
                                break;
                        case 'NULL':
                                $output = "NULL";
                                break;
                        default://string
                                if (!empty($value)) {
                                        if ($value == "NULL") {
                                                $output = "NULL";
                                        } else {

                                                // If string is mysql Query assigned
                                                if (strpos($value, "SELECT") > -1 && strpos($value, "FROM") > -1) {
                                                        $output = "({$value})";
                                                } else {

                                                        #check string is date
                                                        if (DateTime::createFromFormat('d.m.Y', $value)) {
                                                                #it's date
                                                                $output = "'" . date('Y-m-d', strtotime($value)) . "'";
                                                        } else {
                                                                #It's not date

                                                                // recheck is numeric
                                                                if (is_numeric($value)) {
                                                                        $output = $value;
                                                                } else {
                                                                        $output = "'" . addslashes($value) . "'";

                                                                }


                                                        }

                                                }

                                        }


                                } else {
                                        $output = "";
                                }

                                break;
                }
                return $output;
        }

        function getInsert()
        {
                $cols = "";
                $values = "";
                unset($this->assign["output"]);

                foreach ($this->assign as $key => $value) {
                        #$cols .= "`{$this->dbName}`.`{$this->tblName}`.`{$key}`,"; // With Future
                        $cols .= $key . ",";
                        $values .= $this->typeof(gettype($value), $value) . ",";
                }

                $cols = rtrim($cols, ',');
                $values = rtrim($values, ',');


                #return array('cols' => $cols, 'values' => $values);
                return array('cols' => $cols, 'values' => $values);
        }

        function getUpdate()
        {
                $output = "";

                unset($this->assign["output"]);

                foreach ($this->assign as $key => $value) {
                        $output .= $key . "=" . $this->typeof(gettype($value), $value) . ",";
                }

                $output = rtrim($output, ',');


                return $output;
        }



        /*
         * Setting condition for SQL 'WHERE' Statesment
         * Using this method directly
         */
        function setCondition($key, $value, $opt = NULL)
        {
                switch ($value) {
                        case strval($value):

                                $this->where .= $key . "=" . $this->typeof(gettype($value), $value) . " " . $opt . " ";
                                break;
                        case is_null($value):
                                $this->where .= " ( " . $key . " IS NULL OR $key=0 ) " . $opt . " ";
                                break;
                        case TRUE:
                                $this->where .= $key . "=1" . " " . $opt . " ";
                                break;
                        case FALSE:
                                $this->where .= $key . "=0" . " " . $opt . " ";
                                break;
                        case 'NOT NULL':
                                $this->where .= $key . " IS NOT NULL " . $opt . " ";
                                break;
                }


        }

        function setShowErrorWithThrow($value)
        {
                $this->showErrorWithThrow = $value;
        }

        function getShowErrorWithThrow()
        {
                return $this->showErrorWithThrow;
        }

        function setLimit($from = null, $to = null)
        {

                if (!is_null($from)) {
                        $this->limit["from"] = $from;
                }

                if (!is_null($from)) {
                        $this->limit["to"] = $to;
                }

        }

        function getLimit()
        {
                $limit = "";
                if (count($this->limit)) {
                        if (isset($this->limit["from"])) {
                                $limit = $this->limit["from"];

                                if (isset($this->limit["to"])) {
                                        $limit = $limit . ", " . $this->limit["to"];
                                }

                                $limit = " LIMIT " . $limit;
                        }

                }

                return $limit;
        }


        function setConditionToNULL()
        {
                $this->where = NULL;
        }


        function setConditionSpecial($fullCondition, $opt = "")
        {
                #echo $fullCondition;

                // Filter Condition
                $fullCondition = preg_replace('/WHERE/', '', $fullCondition);
                #$fullCondition = trim( $fullCondition );
                $fullCondition = rtrim($fullCondition, "AND");
                $fullCondition = rtrim($fullCondition, "OR");
                $fullCondition = trim($fullCondition);

                $this->where .= " " . $fullCondition . " " . $opt . " ";
        }

        /**
         *
         * @param type $optimization
         * @return  <b>Use optimization as array $key(Column Name) $value(ASC OR DESC) ORDER BY is Fix Can be multiple Optimization<b>
         * @uses    <b>$this->db->setOrderBy(array("zIndex"=>SORT::ASC));<b>
         */
        function setOrderBy( array $optimization = array())
        {
                $opt = array();

                if( $this->isAssoc($optimization) ){

                        if (count($optimization)) {
                                foreach ($optimization as $key => $value) {
                                        if (is_null($value)) {
                                                array_push($opt, $key);
                                                #$opt .= "$key, ";
                                        } else {
                                                #$opt .= "$key $value, ";
                                                array_push($opt, "$key $value");
                                        }
                                }

                        } else {
                                $opt = NULL;
                        }

                } else {

                        if (count($optimization)) {
                                array_push($opt, "$optimization[0] $optimization[1]");
                        } else {
                                $opt = NULL;
                        }


                }


                $this->orderBy = $opt;
        }

        function getOrderBy(){
                if( !is_null($this->orderBy) ){
                        $opt = implode(",", $this->orderBy);
                        $opt = " ORDER BY $opt";
                        return $opt;
                }
                return null;
        }

        function isAssoc(array $arr)
        {
                if (array() === $arr || !is_array($arr)) return false;
                return array_keys($arr) !== range(0, count($arr) - 1);
        }

        /*
         * Getting condition for SQL 'WHERE' Statesment
         * This Method not using directly
         * Condition Work for AND or OR strings
         *
         */
        function getCondition()
        {

                $where = $this->where;
                $str = $where;

                #$str = "surname='ahmet' AND name='ALI' OR name='Veli' OR name='hasan' AND birthday='01.01.1970' AND country='GERMANY' OR country='FRANCE' OR country='ENGLAND' ";
                #$str = "surname='suleyman'";
                #$str = "surname='suleyman' OR surname='Osman' AND name='caroline'";

                $strANDs = explode(" AND ", $str);

                $AND = "";
                $OR = "";
                $finalStr = "";

                foreach ($strANDs as $valueAnd) {
                        $strORs = explode(" OR ", $valueAnd);

                        if (count($strORs) > 1) {
                                $OR = "(";
                                foreach ($strORs as $valueOr) {
                                        $OR .= $valueOr . " OR ";
                                }

                                $OR = rtrim($OR, " OR ");

                                $OR .= ")";
                                $finalStr .= " AND " . $OR;

                        } else {
                                $finalStr .= " AND " . $valueAnd . " AND ";

                        }
                        $finalStr = rtrim($finalStr, " AND ");


                }
                // Trim's
                $finalStr = trim($finalStr);
                $finalStr = ltrim($finalStr, " AND ");
                $finalStr = ltrim($finalStr, " OR ");
                $finalStr = rtrim($finalStr, " AND ");
                $finalStr = rtrim($finalStr, " OR ");


                $useWHERE = $this->useWHERE ? "WHERE" : "";
                return $finalStr != "" ? " " . $useWHERE . " " . $finalStr : null;

        }

        /*
         * The Method 2.Using
         * Either direct or with this method
         * Direct   = $this->db->query = "SELECT * FROM ..."
         * This     = $this->db->setQuery("SELECT * FROM ...")
         *
         */
        public function setQuery($query)
        {
                $this->query = $query;
        }

        /*
         * Replacing special chars with HTML codes
         * The must be while array no accept special chars
         * And
         * By Return in form absolute from array The HTML Codes known from PHP View Page
         * mean the codes not nesseccery converting again ;)
         */
        public function charReplace($subject)
        {
                $search = array('Ä', 'ä', 'Ö', 'ö', 'Ü', 'ü', 'ß', 'Ç', 'ç', 'Ğ', 'ğ', 'Ş', 'ş', '₤', '€', '\t');
                $replace = array('&#196;', '&#228;', '&#214;', '&#246;', '&#220;', '&#252;', '&#223;', '&#199;', '&#231;', '&#286;', '&#287;', '&#350;', '&#351;', '&#8356;', '&#8364;', '');
                return str_replace($search, $replace, $subject);
        }


        public function queryError($errCode, $string = NULL)
        {
                # echo $errCode;

                switch ($errCode) {

                        case '1050':
                                $o = "Mysql 1050 Error “Table already exists” when in fact, it does not";
                                $o = "Table already exists";
                                break;
                        case '1062':
                        case '23000':
                                /*$o = 'duplicate_Entry';

                                $d = explode("Duplicate entry", $string);
                                #highlight_string(var_export($d, true));
                                $d = explode("for key", $d[1]);
                                $d = preg_replace('/\s+|\'/', '', $d[0]);
                                // $o = array("duplicate_entry", $d);
                                $o = $string . "\n ist bereits vorhanden!";*/

                                $strpos = strpos($string, "Duplicate entry") + strlen("Duplicate entry");
                                $endpos = strpos($string, "for key");
                                $string = substr($string, $strpos, $endpos-$strpos);
                                $string = trim(preg_replace('/\s+|\'/', '', $string));
                                $o = $string . "\n ist bereits vorhanden!";


                                break;
                        case '1048':
                                $o = 'missing_data';
                                break;
                        case '1054':
                                $o = 'unknown_column';
                                break;
                        case '1046':
                                $o = 'no_database_selected';
                                break;
                        case '1049':
                                $o = 'unknown_database';
                                break;
                        case '42S02':
                        case '1146':
                                $o = "Base table or view not found";
                                break;
                        case '1072':
                                $o = "Unable to create foreign key in mysql";
                                break;
                        case '1045':
                                $o = "Critical problem <br />Access denied for user <br />Please contact with administrator";
                                break;
                        case '1044':
                                $o = "Critical Error <br />Access denied for user connection to database <br /> Please contact with administrator";
                                break;
                        case '1142':
                                $o = "Access denied for user <br /> Please contact with administrator";
                                break;

                        case '1364':

                                $d = explode(" Field ", $string);
                                $d = explode(" doesn't ", $d[1]);
                                $d = preg_replace('/\s+|\'/', '', $d[0]);
                                $o = array("have_not_a_default_value", $d);

                                break;

                        default:
                                $o = 'unexpected_error';
                                break;
                }

                return $o;


        }

        /**
         * @param $tbl
         * @param $colname
         * AMS FUNCTION
         */
        public function checkModule($tbl, $colname)
        {


        }


}

/**
 * MYSQL Data Types
 */
class DATA_TYPES
{


        #  Length in Bytes	Minimum Value(Signed)       Maximum Value(Signed)	Minimum Value(Unsigned)             Maximum Value(Unsigned)
        const TINYINT = "TINYINT";         #	1               -128                        127                         0                                   255
        const SMALLINT = "SMALLINT";        #	2               -32768                      32767                       0                                   65535
        const MEDIUMINT = "MEDIUMINT";       #	3               -8388608                    8388607 to                  0                                   16777215
        const INT = "INT";             #	4               -2147483648                 2147483647                  0                                   4294967295
        const BIGINT = "BIGINT";          #	8               -9223372036854775808        9223372036854775807         0                                   18446744073709551615

        const FLOAT = "FLOAT";           #	4               -3.402823466E+38            -1.175494351E-38            1.175494351E-38                     3.402823466E+38
        ##  A precision from 0 to 23 results in a four-byte single-precision FLOAT column
        const DOUBLE = "DOUBLE";          #	8               -1.7976931348623157E+ 308   -2.2250738585072014E- 308	0, and 2.2250738585072014E- 308     1.7976931348623157E+ 308
        ##  A precision from 24 to 53 results in an eight-byte double-precision DOUBLE column.
        # Types	Description                                                                                                                                             Display Format          Range
        const DATETIME = "DATETIME";   # Use when you need values containing both date and time information.                                                                           YYYY-MM-DD HH:MM:SS	'1000-01-01 00:00:00' to '9999-12-31 23:59:59'.
        const DATE = "DATE";       # Use when you need only date information.                                                                                                      YYYY-MM-DD              '1000-01-01' to '9999-12-31'.
        const TIMESTAMP = "TIMESTAMP";  # Values are converted from the current time zone to UTC while storing, and converted back from UTC to the current time zone when retrieved.	YYYY-MM-DD HH:MM:SS	'1970-01-01 00:00:01' UTC to '2038-01-19 03:14:07' UTC

        const CHAR = "CHAR";       # Contains non-binary strings. Length is fixed as you declare while creating a table. When stored, they are right-padded with spaces to the specified length.	Trailing spaces are removed.	The length can be any value from 0 to 255.
        const VARCHAR = "VARCHAR";    # Contains non-binary strings. Columns are variable-length strings.

        # Types         Description                     Range in bytes
        const BINARY = "BINARY";     # Contains binary strings.	0 to 255
        const VARBINARY = "VARBINARY";  # Contains binary strings.	A value from 0 to 255 before MySQL 5.0.3, and 0 to 65,535 in 5.0.3 and later versions.


        # Types	Description	Categories	Range
        const BLOB = "BLOB";       # Large binary object that containing a variable amount of data. Values are treated as binary strings.You don't need to specify length while creating a column.
        # TINYBLOB	Maximum length of 255 characters.
        # MEDIUMBLOB";  Maximum length of 16777215 characters.
        # LONGBLOB";	Maximum length of 4294967295 characters
        const TEXT = "TEXT";       # Values are treated as character strings having a character set.
}

