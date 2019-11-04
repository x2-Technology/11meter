<?php

/*
 * Class all database proccess
 * Author:Süleyman Topaloglu
 * Created at:31.01.2014
 * Version:1.0
 */

class Database extends Database_Helper
{

        function __construct($dbName = null, $username = NULL, $password = NULL )
        {
                parent::__construct();

                /*$helper = new Helper();

                if( !$helper->sessionResulta() )
                {
                    return false;
                }*/

                /*
                 * dfb Database
                 * username     :11meter
                 * password     :adler299
                 * *
                 * */

                $this->setDatabaseName((is_null($dbName) ? Config::DB_Name : $dbName));

                $attributes = array(
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
                        #PDO::ATTR_ERRMODE               => PDO::ERRMODE_WARNING,
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //with throw new ...
                        PDO::ATTR_TIMEOUT => Config::MYSQL_CONN_TIMEOUT,
                        PDO::ATTR_EMULATE_PREPARES => TRUE,
                        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => TRUE
                );

                // !!!!!! Önemli
                // Database Yapilan Istekler Ortalama her Sayfada 5 - 15 Arasi cok Fazla
                // Nedeni Sürekli Globala Baglanip degisiik istekler icin database acilmasi!
                #echo "<script type='text/javascript'>console.log('Database Requested', '" . date() . "')</script>";


                #echo "Database requested: " . $db_name . " " . $this->getTable() . "<br/>";

                /*
                 * Eger kullanici sayfayi yeni acmis ise mysql baglati degerleleri
                 * Default olarak verilir
                 * login isleminden sonra kullanici kendisine ait parent kullanicinin mysql baglati degerlerini kullanarak database'e
                 * baglanir buda baglantiyi kullaniciya kisitlar
                 */
                $DB_USER = Config::DB_Username;
                $DB_PASS = Config::DB_Password;

                /*if (isset($_POST["conn_uname"])) {
                        $DB_USER = $_POST["conn_uname"];
                }
                if (isset($_POST["conn_passw"])) {
                        $DB_USER = $_POST["conn_passw"];
                }*/

                if( !is_null($username) ){
                        $DB_USER        = $username;
                }

                if( !is_null($password) ){
                        $DB_PASS        = $password;
                }


                try {


                        $this->db = new PDO(
                        #"mysql:host=" . Config::DB_Host
                                "mysql:host=" . Config::DB_Host . ";port=" . Config::DB_Port . ";dbname=" . $this->getDatabaseName()
                                , $DB_USER //Config::DB_Username
                                , $DB_PASS //Config::DB_Password
                                , $attributes
                        );


                } catch (PDOException $exc) {


                        /*$this->resulta = FALSE;
                        $this->errCode = $exc->getCode();
                        $this->getFile = $exc->getFile();
                        $this->getLine = $exc->getLine();
                        $this->getMessage = $exc->getMessage();
                        $this->getPrevious = $exc->getPrevious();
                        $this->getTrace = $exc->getTrace();
                        $this->getTraceAsString = $exc->getTraceAsString();
                        $this->PDOError = $this->queryError($exc->getCode()) . "<br />" . $exc->getMessage();*/


                        $this->errCode = $exc->getCode();
                        $this->errInfo = $exc->getMessage();
                        $this->PDOError = $exc->getMessage();
                        $this->resulta = FALSE;

                        // die("Error" . $exc->getMessage());

                        // $this->traceMonitoring($exc);
                }
        }

        function getPDO()
        {
                return $this->db;
        }

        function setSingleValueWithKey($val)
        {
                $this->singleValueWithKey = $val;
        }

        function getSingleValueWithKey()
        {
                return $this->singleValueWithKey;
        }


        /*
         * DB set be null
         */

        function __destruct()
        {
                // $this->table = null;
                $this->setTable(null);
                $this->db = null;
                $this->PDOError = "";
                $this->resulta = FALSE;
                $this->setSingleValueWithKey(false);


        }

        /**
         * @param $table 'as'
         *
         */
        function setTable($table)
        {
                $this->tblName = $table;
        }

        function getTable()
        {
                return $this->tblName;
        }

        function setDatabaseName($name)
        {
                $this->dbName = $name;
        }

        function getDatabaseName()
        {
                return $this->dbName;
        }


        /*
         * Insert Record
         */

        public function Insert()
        {


                try {


                        /*
                         * By Custom Query no need table declaration or another statesment
                         */
                        if (!is_null($this->query)) {
                                $sql = $this->query;
                        } else {
                                $_ = $this->getInsert();
                                $sql = "INSERT INTO " . $this->getTable() . "(" . $_['cols'] . ") VALUES(" . $_['values'] . ")" . $this->getCondition();
                        }

                        // $this->setQueryString = $sql;
                        $this->setQueryString($sql);
                        $stmt = $this->db->prepare($sql);

                        if ($stmt->execute()) {

                                // $this->lastInsertId = $this->db->lastInsertId();
                                $this->setLastInsert($this->db->lastInsertId());
                                $this->resulta = TRUE;
                                $this->process = TRUE;
                                $this->assign = NULL; // ->set($key, $value) to NULL
                                return TRUE;
                        } else {

                                $this->errCode = 0;
                                $this->errInfo = "Unknown Error with insert";
                                $this->resulta = FALSE;
                                $this->assign = NULL; // ->set($key, $value) to NULL
                                return FALSE;
                        }


                } catch (PDOException $exc) {

                        $this->errCode = $exc->errorInfo[1];
                        $this->errInfo = $exc->getMessage();
                        $this->PDOError = $exc->getMessage();
                        $this->resulta = FALSE;
                        $this->PDOExeption = $exc;

                        $this->traceMonitoring($exc);

                }

                // Added 13.12.2017 11:31
                $this->clearVariables();
        }

        public function InsertOrUpdate()
        {


                try {


                        /*
                         * By Custom Query no need table declaration or another statesment
                         */
                        if (!is_null($this->query)) {
                                $sql = $this->query;
                        } else {
                                $_ = $this->getInsert();
                                $sql = "INSERT INTO " . $this->getTable() . "(" . $_['cols'] . ") VALUES(" . $_['values'] . ") ON DUPLICATE KEY UPDATE " . implode(", ", $this->getUpdateColsByInsert()) . " " . $this->getCondition();
                        }

                        // $this->setQueryString = $sql;
                        $this->setQueryString($sql);
                        $stmt = $this->db->prepare($sql);

                        if ($stmt->execute()) {

                                // $this->lastInsertId = $this->db->lastInsertId();
                                $this->setLastInsert($this->db->lastInsertId());
                                $this->resulta = TRUE;
                                $this->process = TRUE;
                                $this->assign = NULL; // ->set($key, $value) to NULL
                                return TRUE;
                        } else {

                                $this->errCode = 0;
                                $this->errInfo = "Unknown Error with insert";
                                $this->resulta = FALSE;
                                $this->assign = NULL; // ->set($key, $value) to NULL
                                return FALSE;
                        }


                } catch (PDOException $exc) {

                        $this->errCode = $exc->errorInfo[1];
                        $this->errInfo = $exc->getMessage();
                        $this->PDOError = $exc->getMessage();
                        $this->resulta = FALSE;
                        $this->PDOExeption = $exc;

                        $this->traceMonitoring($exc);

                }

                // Added 13.12.2017 11:31
                $this->clearVariables();
        }

        /*
         * Update record
         */

        public function Update()
        {

                try {

                        /*
                         * By Custom Query no need table declaration or another statesment
                         */
                        if (!is_null($this->query)) {
                                $sql = $this->query;
                        } else {
                                $sql = "UPDATE " . $this->getTable() . " SET " . $this->getUpdate() . $this->getCondition();
                        }

                        // $this->setQueryString($sql);
                        $this->setQueryString($sql);
                        $stmt = $this->db->prepare($sql);
                        if ($stmt->execute()) {

                                $this->resulta = TRUE;

                                if ($stmt->rowCount()) {
                                        $this->process = TRUE;
                                } else {
                                        $this->process = FALSE;
                                }
                        } else {

                                $this->resulta = FALSE;

                                $this->errCode = $stmt->errorInfo()[1];
                                $this->errInfo = $stmt->errorInfo()[2];
                                $this->PDOError = $stmt->errorInfo()[2];

                        }

                        $this->assign = NULL;
                        #$this->assign = NULL; // ->set($key, $value) to NULL
                        $this->setQuery(NULL);
                        $this->setConditionToNULL();

                } catch (PDOException $exc) {

                        // Error with query

                        $this->errCode = $exc->getCode();
                        $this->errInfo = $exc->getMessage();
                        $this->PDOError = $exc->getMessage();
                        $this->resulta = FALSE;

                        $this->traceMonitoring($exc);
                }

                return $this->resulta;
        }

        /*
         * Delete record
         */

        public function Delete()
        {
                try {
                        if (!is_null($this->query)) {
                                $sql = $this->query;
                        } else {
                                $sql = "DELETE FROM " . $this->getTable() . $this->getCondition();
                        }

                        // $this->setQueryString($sql);
                        $this->setQueryString($sql);
                        $stmt = $this->db->prepare($sql);
                        if ($stmt->execute()) {


                                $this->assign = NULL; // ->set($key, $value) to NULL
                                $this->resulta = TRUE;
                                // return TRUE;

                                if ($stmt->rowCount()) {
                                        $this->process = TRUE;
                                } else {
                                        $this->process = FALSE;
                                }


                        } else {
                                $this->assign = NULL; // ->set($key, $value) to NULL
                                $this->errCode .= $stmt->errorInfo()[1];
                                $this->errInfo .= $stmt->errorInfo()[2];
                                $this->resulta = FALSE;
                                // return FALSE;
                        }
                } catch (PDOException $exc) {

                        $this->errCode = $exc->getCode();
                        $this->errInfo = $exc->getMessage();
                        $this->PDOError = $exc->getMessage();
                        $this->resulta = FALSE;

                        $this->traceMonitoring($exc);


                }
        }


        public function getRecord($keyCol = "id", $associative = true) // $keyCol ist key for array default = id
        {

                $keyCol = explode(",", $keyCol);

                try {


                        if (!is_null($this->query)) {
                                $sql = $this->query . $this->orderBy . $this->getLimit();
                        } else {
                                $fields = $this->select == "" ? '*' : $this->select;
                                $sql = "SELECT $fields FROM " . $this->getTable() . $this->getCondition() . $this->orderBy . $this->getLimit();
                        }

                        $this->setQueryString($sql);

                        #echo $sql;

                        $stmt = $this->db->prepare($sql);
                        if ($stmt->execute()) {
                                $this->resulta = TRUE;
                        }


                        if ($stmt->rowCount() !== 0) {

                                if (!is_null($this->getCondition()) || !is_null($this->query)) {

                                        if ($stmt->rowCount() > 1) {


                                                if ($this->getFetchType() === FETCH_TYPE::ASSOC) {

                                                        while ($row = $stmt->fetch(self::DATA_FETCH)) {

                                                                if (count($keyCol) > 1) {
                                                                        // Assign multiple keycol
                                                                        $_ = "";
                                                                        foreach ($keyCol as $key) {
                                                                                $_ .= $row[$key] . "_";
                                                                        }
                                                                        // trim char from right side
                                                                        $_ = rtrim($_, "_");
                                                                        $output[$_] = $row;
                                                                } else {
                                                                        $output[$row[$keyCol[0]]] = $row;
                                                                }

                                                                #$output[$row[$keyCol]] = $row;
                                                        }

                                                } else if ($this->getFetchType() === FETCH_TYPE::INDEXED) {

                                                        $output = $stmt->fetchAll();

                                                }


                                                $return = $output;
                                        } else {


                                                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                                        if ($this->getSingleValueWithKey()) {

                                                                if (count($keyCol) > 1) {
                                                                        // Assign multiple keycol
                                                                        $_ = "";
                                                                        foreach ($keyCol as $key) {
                                                                                $_ .= $row[$key] . "_";
                                                                        }
                                                                        // trim char from right side
                                                                        $_ = rtrim($_, "_");
                                                                        $output[$_] = $row;
                                                                } else {
                                                                        $output[$row[$keyCol[0]]] = $row;
                                                                }
                                                                #$output[$row[$keyCol]] = $row;
                                                        } else {

                                                                $output = $row;
                                                        }
                                                        $return = $output;
                                                        #print_r($return);
                                                } else {
                                                        $return = $sql;
                                                }
                                        }
                                } else {
                                        $output = array();

                                        if ($this->getFetchType() === FETCH_TYPE::ASSOC) {

                                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                        if (count($keyCol) > 1) {
                                                                // Assign multiple keycol
                                                                $_ = "";
                                                                foreach ($keyCol as $key) {
                                                                        $_ .= $row[$key] . "_";
                                                                }
                                                                // trim char from right side
                                                                $_ = rtrim($_, "_");
                                                                $output[$_] = $row;
                                                        } else {

                                                                if ($this->getSingleValueWithKey()) {
                                                                        $output[$row[$keyCol[0]]] = $row;
                                                                } else {
                                                                        $output = $row;
                                                                }
                                                        }
                                                        #$output[$row[$keyCol[0]]] = $row;
                                                        #array_push($output, $row);
                                                }


                                        } else if ($this->getFetchType() === FETCH_TYPE::INDEXED) {


                                                $output = $stmt->fetchAll();

                                        }


                                        //print_r($output);
                                        $return = $output;
                                }
                        } else {
                                $return = null; //No any data found" . "<br />" . $sql;
                        }


                        // Destroy where Statement
                        #$this->where = NULL;

                        // Query Destroy
                        $this->setQuery(NULL);
                        $this->setConditionToNULL();
                        $this->setSingleValueWithKey(false);


                        /*if ($this->fetch_style === Config::FETCH_OBJ) {
                              $return = (object)$return;

                        }*/
                        if ($this->getFetchStructure() === FETCH_STRUCTURE::OBJECT) {
                                $return = (object)$return;

                        }

                        if (!$associative) {

                                $return = array_values($return);

                        }

                        return $return;


                } catch (PDOException $exc) {

                        /*
                        $err = $this->queryError($exc->getCode());
                        $err .= "<br />";
                        $err .= "File:<span style='font-weight:bold;color:red;' >{$exc->getFile()}</span> line:<span style='font-weight:bold;color:red;' >{$exc->getLine()}</span>";
                        $err .= "<br />";
                        $err .= $exc->getMessage();
                        die( $err );
                        */


                        $this->errCode = $exc->getCode();
                        $this->errInfo = $exc->getMessage();
                        $this->PDOError = $exc->getMessage();
                        $this->resulta = FALSE;

                        $this->traceMonitoring($exc);


                }
        }


        // public function fetch($keyCol = "id", $associative = true) // $keyCol ist key for array default = id
        public function fetch() // $keyCol ist key for array default = id
        {
                $keyCol = explode(",", $this->getRowKey());

                try {


                        if (!is_null($this->query)) {
                                $sql = $this->query . $this->getOrderBy() . $this->getLimit();
                        } else {
                                $fields = $this->select == "" ? '*' : $this->select;
                                $sql = "SELECT $fields FROM " . $this->getTable() . $this->getCondition() . $this->getOrderBy() . $this->getLimit();
                        }

                        $this->setQueryString($sql);

                        #echo $sql;

                        $stmt = $this->db->prepare($sql);
                        if ($stmt->execute()) {
                                $this->resulta = TRUE;
                        }



                        if ($stmt->rowCount() !== 0) {

                                if (!is_null($this->getCondition()) || !is_null($this->query)) {

                                        if ($stmt->rowCount() > 1) {
                                                while ($row = $stmt->fetch(self::DATA_FETCH)) {

                                                        if (count($keyCol) > 1) {
                                                                // Assign multiple keycol
                                                                $_ = "";
                                                                foreach ($keyCol as $key) {
                                                                        $_ .= $row[$key] . "_";
                                                                }
                                                                // trim char from right side
                                                                $_ = rtrim($_, "_");
                                                                $output[$_] = $row;
                                                        } else {
                                                                $output[$row[$keyCol[0]]] = $row;
                                                        }

                                                        #$output[$row[$keyCol]] = $row;
                                                }
                                                $return = $output;
                                        } else {


                                                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                                        if ($this->getSingleValueWithKey()) {

                                                                if (count($keyCol) > 1) {
                                                                        // Assign multiple keycol
                                                                        $_ = "";
                                                                        foreach ($keyCol as $key) {
                                                                                $_ .= $row[$key] . "_";
                                                                        }
                                                                        // trim char from right side
                                                                        $_ = rtrim($_, "_");
                                                                        $output[$_] = $row;
                                                                } else {
                                                                        $output[$row[$keyCol[0]]] = $row;
                                                                }
                                                                #$output[$row[$keyCol]] = $row;
                                                        } else {

                                                                $output = $row;
                                                        }
                                                        $return = $output;
                                                        #print_r($return);
                                                } else {
                                                        $return = $sql;
                                                }
                                        }
                                } else {
                                        $output = array();

                                        #echo $this->getQueryString();

                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                if (count($keyCol) > 1) {
                                                        // Assign multiple keycol
                                                        $_ = "";
                                                        foreach ($keyCol as $key) {
                                                                $_ .= $row[$key] . "_";
                                                        }
                                                        // trim char from right side
                                                        $_ = rtrim($_, "_");
                                                        $output[$_] = $row;
                                                } else {

                                                        if ($this->getSingleValueWithKey()) {
                                                                $output[$row[$keyCol[0]]] = $row;
                                                        } else {
                                                                $output = $row;
                                                        }
                                                }
                                                #$output[$row[$keyCol[0]]] = $row;
                                                #array_push($output, $row);
                                        }
                                        //print_r($output);
                                        $return = $output;
                                }
                        } else {
                                $return = null; //No any data found" . "<br />" . $sql;
                        }


                        // Destroy where Statement
                        #$this->where = NULL;

                        // Query Destroy
                        $this->setQuery(NULL);
                        $this->setConditionToNULL();
                        $this->setSingleValueWithKey(false);


                        /* if ($this->fetch_style === Config::FETCH_OBJ) {
                             $return = (object)$return;

                         }*/

                        if ($this->getFetchStructure() === FETCH_STRUCTURE::FETCH_OBJECT) {
                                $return = (object)$return;

                        }

                        /*
                         * Bu özelligi FETCH_INDEXED YAPIO
                        if (!$associative) {

                                $return = array_values($return);

                        }
                        */

                        return $return;


                } catch (PDOException $exc) {

                        /*
                        $err = $this->queryError($exc->getCode());
                        $err .= "<br />";
                        $err .= "File:<span style='font-weight:bold;color:red;' >{$exc->getFile()}</span> line:<span style='font-weight:bold;color:red;' >{$exc->getLine()}</span>";
                        $err .= "<br />";
                        $err .= $exc->getMessage();
                        die( $err );
                        */


                        $this->errCode = $exc->getCode();
                        $this->errInfo = $exc->getMessage();
                        $this->PDOError = $exc->getMessage();
                        $this->resulta = FALSE;

                        $this->traceMonitoring($exc);


                }
        }

        /**
         *
         * @param type $keyCol key column for array key as string explode with , for multiple key name assign
         * @return "process" <b>Return array param TRUE FALSE<b>
         * @return "count"   <b>Return array param count of resulta<b>
         * @return "resulta" <b>Return array param resulta of query as array<b>
         * @return "error"   <b>Return array param Erro of PDO<b>
         */
        public function queryExecute()
        {
                $this->resulta = false;
                $this->process = false;


                try {

                        // $this->setQueryString = $this->query;
                        $this->setQueryString($this->query);
                        $stmt = $this->db->prepare($this->query);


                        if ($stmt->execute()) {
                                // $this->resulta = true;
                                $this->resulta = TRUE;
                                $this->process = $stmt->rowCount();
                                //$this->lastInsertId = $this->db->lastInsertId();
                                $this->setLastInsert($this->db->lastInsertId());



                        } else {

                                $this->assign = NULL; // ->set($key, $value) to NULL
                                $this->errCode .= $stmt->errorInfo()[1];
                                $this->errInfo .= $stmt->errorInfo()[2];
                                $this->resulta = FALSE;
                        }

                        $this->setQuery(NULL);
                        $this->setConditionToNULL();

                        #$return = TRUE;
                } catch (PDOException $exc) {


                        $this->errCode = $exc->getCode();
                        $this->errInfo = $exc->getMessage();
                        $this->PDOError = $exc->getMessage();
                        $this->resulta = false;

                        $this->traceMonitoring($exc);

                }


                // Return
                return $this->resulta;
        }


        /**
         * @param string $keyCol
         * @return array|bool
         *
         * @deprecated
         */
        public function queryExecute_deprecated($keyCol = "id")
        {
                try {

                        #$this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                        $sql = "";
                        $keyCol = explode(",", $keyCol);

                        $this->setQueryString($this->query);
                        if ($this->executedQueryDataBack) {
                                #echo 1;

                                $this->query = rtrim($this->query, ";");
                                $this->query .= "; SELECT * FROM contact WHERE cid=114";
                        }
                        $stmt = $this->db->prepare($this->query);


                        if ($stmt->execute()) {


                                $this->resulta = TRUE;

                                if ($this->executedQueryDataBack) {

                                        #echo $this->query . "<br />" . $stmt->rowCount();
                                        #echo $stmt->fetch(PDO::FETCH_ASSOC);
                                        // $stmt->nextRowset();

                                        if ($stmt->rowCount()) {

                                                $count = $stmt->rowCount();

                                                if ($stmt->rowCount() == 1) {
                                                        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                if ($this->getSingleValueWithKey()) {
                                                                        if (count($keyCol) > 1) {
                                                                                // Assign multiple keycol
                                                                                $_ = "";
                                                                                foreach ($keyCol as $key) {
                                                                                        $_ .= $row[$key] . "_";
                                                                                }
                                                                                // trim char from right side
                                                                                $_ = rtrim($_, "_");
                                                                                $resulta[$_] = $row;
                                                                        } else {
                                                                                $resulta[$row[$keyCol[0]]] = $row;
                                                                        }
                                                                } else {
                                                                        $resulta = $row;
                                                                }
                                                        } else {
                                                                $resulta = "Error:" . $sql;
                                                        }
                                                } else {
                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                                                if (count($keyCol) > 1) {
                                                                        // Assign multiple keycol
                                                                        $_ = "";
                                                                        foreach ($keyCol as $key) {
                                                                                $_ .= $row[$key] . "_";
                                                                        }
                                                                        // trim char from right side
                                                                        $_ = rtrim($_, "_");
                                                                        $resulta[$_] = $row;
                                                                } else {
                                                                        $resulta[$row[$keyCol[0]]] = $row;
                                                                }
                                                        }
                                                }
                                        } else {

                                        }
                                } else {
                                        // Return Only $process variable
                                }
                        } else {
//
                                echo "Error";

                                $this->assign = NULL; // ->set($key, $value) to NULL
                                $this->errCode .= $stmt->errorInfo()[1];
                                $this->errInfo .= $stmt->errorInfo()[2];
                                $this->resulta = FALSE;
                        }

                        $this->setQuery(NULL);
                        $this->setConditionToNULL();

                        #$return = TRUE;
                } catch (PDOException $exc) {


                        $this->errCode = $exc->getCode();
                        $this->errInfo = $exc->getMessage();
                        $this->PDOError = $exc->getMessage();
                        $this->resulta = FALSE;

                        $this->traceMonitoring($exc);


                }


                // Return
                if ($this->executedQueryDataBack) {
                        return array(
                                "data" => $resulta,
                                "count" => $count,
                                "sql" => $stmt->queryString
                        );
                } else {
                        return $this->resulta;
                }
        }

        public function ShowGrants($User)
        {

                $this->setTable("tables_priv");
                $this->setCondition("User", $User);
                $data = $this->getGroups("Db", "Table_name");

                return $data;
        }


        // Report PDO Error's on Details
        public function traceMonitoring(PDOException $exc)
        {
                /*if (!$this->getShowErrorWithThrow()) {
                        return false;
                }*/




                $console = "";
                #$console = $this->queryError($exc->getCode());
                #$console .= "<br />";
                $console .= "Error message:";
                $console .= "<br />";
                $console .= $exc->getMessage();
                $console .= "<br />";

                #$console .= $this->queryError($exc->getCode());
                #$console .= "<br />";

                $console .= "<br />";
                $console .= "<u><font color='red'>Error sql line:</font></b></u>";
                $console .= "<br />";
                $console .= "<code>" . $this->getQueryString() . "</code>";
                $console .= "<br />";
                $console .= "<br />";

                $console .= "<u>Error files and lines:</u>";
                $console .= "<br />";

                $console .= "";
                $console .= "<table class='table table-bordered table-sm'>";
                $console .= "<thead>";
                $console .= "<tr><th class='min-width'>File</th><th class='min-width'>Line</th><th>Function</th></tr>";
                $console .= "</thead>";

                $errors = array();

                foreach (array_reverse($exc->getTrace()) as $value) {

                        // Filename
                        $file = pathinfo($value["file"]);
                        $file = $file["basename"];
                        $console .= "<tr>";
                        $console .= "<td title='{$value["file"]}' >{$file}</td>";
                        $console .= "<td>{$value["line"]}</td>";
                        $console .= "<td>{$value["function"]}</td>";
                        $console .= "</tr>";

                        array_push($errors, array(
                                "file"=>$file,
                                "line"=>$value["line"],
                                "function"=>$value["function"],
                        ));



                }
                $console .= "</table>";
                // die($console);




                REPOSITORY::writes (REPOSITORY::CURRENT_LAST_MYSQL_ERROR, array(
                        "message_user"=>$this->queryError($exc->getCode(), $exc->getMessage()),
                        "message_developer"=>$exc->getMessage(),
                        "query"=>$this->getQueryString(),
                        "errors"=>$errors,
                        "exc"=>$exc
                ));

                return $console;

                /*return array(
                        "resulta"=>false,
                        "messageHTML" => $console,
                        "messageAjax" => $exc->getMessage()
                );*/

                //
                // throw new($console);

        }


        /*
         * Get Colls for table remove banned cols from string, prepare cols for query
         * @params['database'] => Cols in which database
         * @params['table'] => Cols in which table
         * @params['banned_cols'] => Banned_cols remove cols from prepared string
         * @params['sortcut'] => Col name Concat with shortcut
         * @desciription => Example = for shortcut = sohortcut is _t colname is name => _t.name
         * It is for JOIN method in MySQL
         * Example
         * Method:
         * $this->selectTableColumnsForQuery(array("database"=>"_global", "table"=>"_software_versions","shortcut"=>"_sv", banned_cols=>"software_key" ));
         *
         * Query
         * SELECT _s.*, _sv.id,_sv.version_major,_sv.version_minor,_sv.published,_sv.published_date,_sv.published_by,_sv.comment
         *  FROM _softwares as _s LEFT JOIN _software_versions as _sv ON ( _s.software_key=_sv.software_key AND _sv.published=1 ) WHERE _s.software_key='software_key';
         */

        function getCustomCols($params = NULL)
        {
                if (is_null($params["shortcut"])) {
                        $qry = "SELECT REPLACE( GROUP_CONCAT( COLUMN_NAME ),'{$params["banned_cols"]},', '' ) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='{$params["table"]}' AND TABLE_SCHEMA='{$params["database"]}' LIMIT 1;";
                } else {
                        #$qry = "SELECT REPLACE( GROUP_CONCAT('" . $params["shortcut"] . ".', COLUMN_NAME ),'{$params["banned_cols"]},', '' ) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='{$params["table"]}' AND TABLE_SCHEMA='{$params["database"]}' LIMIT 1;";

                        if (is_null($params["banned_cols"])) {
                                # $qry = "SELECT GROUP_CONCAT('" . $params["shortcut"] . ".', COLUMN_NAME ) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='{$params["table"]}' AND TABLE_SCHEMA='{$params["database"]}' LIMIT 1;";
                                $qry = $params["shortcut"] . ".*";
                        } else {
                                $qry = "SELECT REPLACE( GROUP_CONCAT('" . $params["shortcut"] . ".', COLUMN_NAME ),'{$params["banned_cols"]},', '' ) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='{$params["table"]}' AND TABLE_SCHEMA='{$params["database"]}' LIMIT 1;";
                        }
                }


                if (is_null($params["banned_cols"])) {
                        return array("string" => $qry, "PDOError" => NULL);
                } else {
                        $stmt = $this->db->prepare($qry);
                        $stmt->execute();
                        return array("string" => array_values($stmt->fetch(PDO::FETCH_ASSOC))[0], "PDOError" => $this->db->errInfo);
                }
        }

        /*
         * Return query String for Info
         */

        public function getQueryString()
        {


                if (!is_null($this->query)) {
                        $qry = $this->query;
                } else {
                        $qry = $this->queryString;
                }

                return $qry;
        }

        function setQueryString($query)
        {
                $this->queryString = $query;
        }


        function getLastInsert()
        {
                return $this->lastInsertId;
        }

        function getLastInsertID()
        {
                return $this->lastInsertId;
        }

        function setLastInsert($lastInsertId)
        {
                $this->lastInsertId = $lastInsertId;// $this->db->lastInsertId();
        }

        /*
         * This function if more record exist in table with same key
         * this key wtire to array key and another values writing as values
         * + the values is in array
         */

        /**
         * @deprecated
         * @use instead of fetchGroups
         * @param $groupColAsKey
         * @param string $colKey
         * @return array|string
         */
        public function getGroups($groupColAsKey, $colKey = 'id')
        {
                try {

                        $fields = $this->select == "" ? '*' : $this->select;
                        if (!is_null($this->query)) {
                                $sql = $this->query . $this->orderBy . $this->getLimit();
                        } else {
                                $sql = "SELECT $fields FROM " . $this->getTable() . $this->getCondition() . $this->orderBy;
                        }
                        // $this->setQueryString = $sql;
                        $this->setQueryString($sql);
                        $stmt = $this->db->prepare($sql);
                        if ($stmt->execute()) {
                                $this->resulta = TRUE;
                        }
                        $output = array();
                        $_ = array();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $output[$row[$groupColAsKey]][$row[$colKey]] = $row;
                        }
                        return $output;
                } catch (PDOException $exc) {
                        $this->errCode = $exc->getCode();
                        $this->errInfo = $exc->getMessage();
                        $this->PDOError = $exc->getMessage();
                        $this->resulta = FALSE;
                        return $this->errInfo;
                }
        }

        public function fetchGroups($groupColAsKey, $colKey = 'id')
        {
                try {

                        $fields = $this->select == "" ? '*' : $this->select;
                        if (!is_null($this->query)) {
                                $sql = $this->query . $this->orderBy . $this->getLimit();
                        } else {
                                $sql = "SELECT $fields FROM " . $this->getTable() . $this->getCondition() . $this->orderBy;
                        }
                        // $this->setQueryString = $sql;
                        $this->setQueryString($sql);
                        $stmt = $this->db->prepare($sql);
                        if ($stmt->execute()) {
                                $this->resulta = TRUE;
                        }
                        $output = array();
                        $_ = array();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $output[$row[$groupColAsKey]][$row[$colKey]] = $row;
                        }
                        return $output;
                } catch (PDOException $exc) {
                        $this->errCode = $exc->getCode();
                        $this->errInfo = $exc->getMessage();
                        $this->PDOError = $exc->getMessage();
                        $this->resulta = FALSE;
                        return $this->errInfo;
                }
        }


        // Count of row
        public function recordCount()
        {

                if (!is_null($this->query)) {
                        $sql = $this->query;
                } else {
                        $fields = $this->select == "" ? '*' : $this->select;
                        $sql = "SELECT $fields FROM " . $this->getTable() . $this->getCondition();
                }

                // $this->setQueryString = $sql;
                $this->setQueryString($sql);

                $stmt = $this->db->prepare($sql);
                try {
                        if ($stmt->execute()) {
                                $this->resulta = TRUE;
                                return $stmt->rowCount();
                        } else {
                                $this->resulta = FALSE;
                                $this->errCode .= $stmt->errorInfo()[1];
                                $this->errInfo .= $stmt->errorInfo()[2];
                                $this->PDOError = $stmt->errorInfo()[2];
                                $return = FALSE;
                        }
                } catch (PDOException $exc) {

                        // throw new Exception($exc->getMessage());
                        $this->errCode = $exc->getCode();
                        $this->errInfo = $exc->getMessage();
                        $this->PDOError = $exc->getMessage();

                        $this->traceMonitoring($exc);
                }

        }

        public function setTableField($field, $propertys = array())
        {
                array_push($this->fields, array($field => $propertys));
        }


        // Requested Table Columns
        public function getColumnsPropertys()
        {
                #echo "SHOW FULL COLUMNS FROM " . $this->getTable();
                $query = $this->db->query("SHOW FULL COLUMNS FROM " . $this->getTable());
                $columns = $query->fetchAll(PDO::FETCH_ASSOC);

                $_ = array();

                foreach ($columns as $key => $value) {
                        // Append index element to current array
                        $value["index"] = $key;
                        // Create new Array
                        $_[$value["Field"]] = $value;
                }
                return $_;
        }


        /*
         * All Table of Schemata
         */
        public function SchemaTables()
        {
                #echo "SHOW FULL COLUMNS FROM " . $this->getTable();
                $query = $this->db->query("SHOW TABLE STATUS");
                $tables = $query->fetchAll(PDO::FETCH_ASSOC);

                $_ = array();

                foreach ($tables as $table) {

                        $table["Schema"] = $this->getDB();

                        // Create new Array
                        $_[$table["Name"]] = $table;
                }

                return $_;
        }


        // Requested Table Indexes
        public function TableIndexes()
        {
                $query = $this->db->query("SHOW INDEXES FROM " . $this->getDB() . "." . $this->getTable());
                $Indexes = $query->fetchAll(PDO::FETCH_ASSOC);

                //print_r($Indexes);

                $_ = array();

                foreach ($Indexes as $Index) {
                        if ($Index["Key_name"] !== "PRIMARY")
                                if (is_null($_[$Index["Key_name"]])) {
                                        #$_[$Index["Key_name"]] = array("Column_name" => array($Index["Column_name"]), "Non_unique"=>$Index["Non_unique"]);
                                        $_[$Index["Key_name"]] = $Index;
                                } else {
                                        #array_push($_[ $Index["Key_name"] ]["Column_name"], $Index["Column_name"] );
                                        $_[$Index["Key_name"]]["Column_name"] .= "," . $Index["Column_name"];
                                }
                }

                return $_;

        }


        function TableConstraints($SCHEMA, $TABLE)
        {


                // Get FKEYS <-- Combined with 2 Tables REFERENTIAL_CONSTRAINTS <=> KEY_COLUMN_USAGE
                $specificSQL = "";
                $specificSQL .= "SELECT ref.*, kcu.*, ";
                $specificSQL .= "GROUP_CONCAT(kcu.COLUMN_NAME) as CONSTRAINT_FIELDS, ";
                $specificSQL .= "GROUP_CONCAT(kcu.REFERENCED_COLUMN_NAME) as REFERENCED_CONSTRAINT_FIELDS ";
                $specificSQL .= "FROM REFERENTIAL_CONSTRAINTS as ref ";
                $specificSQL .= "LEFT JOIN KEY_COLUMN_USAGE as kcu ";
                $specificSQL .= "ON ";
                $specificSQL .= "ref.CONSTRAINT_SCHEMA  = kcu.CONSTRAINT_SCHEMA AND ";
                $specificSQL .= "ref.TABLE_NAME         = kcu.TABLE_NAME AND ";
                $specificSQL .= "ref.CONSTRAINT_NAME    = kcu.CONSTRAINT_NAME ";
                $specificSQL .= "WHERE ref.CONSTRAINT_SCHEMA='{$SCHEMA}' AND ref.TABLE_NAME='{$TABLE}' ";
                $specificSQL .= "GROUP BY ref.CONSTRAINT_NAME;";

                $this->setQuery($specificSQL);
                $this->setSingleValueWithKey(true);
                return $this->getRecord("CONSTRAINT_NAME");

        }

        function TableTriggers($SCHEMA, $TABLE)
        {

                $this->setTable("TRIGGERS");
                $this->setCondition("EVENT_OBJECT_SCHEMA", $SCHEMA, "AND");
                $this->setCondition("EVENT_OBJECT_TABLE", $TABLE, "AND");
                $this->setSingleValueWithKey(true);
                return $this->getRecord("TRIGGER_NAME");

        }


        /*
         * On working time nor finish ( MANUELLE )
         */

        public function createTable($tbl)
        {
                $isNull = "";
                $sql = "CREATE TABLE IF NOT EXIST $tbl(";
                $pri_key = "";
                foreach ($this->fields as $field) {
                        foreach ($field as $name => $propertys) {
                                //echo $propertys['IS_NULL'];
                                if (array_key_exists('AUTO_INCREMENT', $propertys)) {
                                        $sql .= $name . " " . $propertys['type'] . "( " . $propertys['length'] . " ) " . " AUTO_INCREMENT PRIMARY KEY,";
                                } else {
                                        $isNull = $propertys['IS_NULL'] ? "NULL" : "NOT NULL";
                                        $sql .= $name . " " . $propertys['type'] . "( " . $propertys['length'] . " ) " . $isNull . ",";
                                }
                        }
                }

                $sql = rtrim($sql, ',') . " CHARACTER SET utf8 COLLATE utf8_general_ci; ";
                //$sql = $sql . " PRIMARY KEY (" . $pri_key . ")";
                //return $sql;
                $this->db->exec($sql);


                /*
                  ID INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                  Prename VARCHAR( 50 ) NOT NULL,
                  Name VARCHAR( 250 ) NOT NULL,
                  StreetA VARCHAR( 150 ) NOT NULL,
                  StreetB VARCHAR( 150 ) NOT NULL, StreetC VARCHAR( 150 ) NOT NULL,
                  County VARCHAR( 100 ) NOT NULL,
                  Postcode VARCHAR( 50 ) NOT NULL,
                  Country VARCHAR( 50 ) NOT NULL);" ;
                  $this->db->exec($sql);
                 *
                 *
                 */
        }

        //--------------------------------------------------------------------------

        public function createModule()
        {

                if (!empty($this->moduleName)) {
                        $report = "";
                        $sql = "INSERT INTO _modules (name,description) VALUES ('$this->moduleName','$this->moduleDescription')";
                        // $this->setQueryString = $sql;
                        $this->setQueryString($sql);
                        $stmt = $this->db->prepare($sql);
                        if ($stmt->execute()) {

//                if(!$this->checkModule("_modules_default","mod_{$this->moduleName}")){
                                $sql = "ALTER TABLE _modules_default ADD COLUMN mod_{$this->moduleName} TINYINT(1) DEFAULT 0";
                                $stmt = $this->db->prepare($sql);
                                if ($stmt->execute()) {
                                        $report .= "_modules_default Added";
                                } else {
                                        $report .= "_modules_default Not Added";
                                }
//                }
//                if(!$this->checkModule("company_modules","mod_{$this->moduleName}")){
                                $sql = "ALTER TABLE company_modules ADD COLUMN mod_{$this->moduleName} TINYINT(1) DEFAULT 0";
                                $stmt = $this->db->prepare($sql);
                                if ($stmt->execute()) {
                                        $report .= "company_modules Added";
                                } else {
                                        $report .= "company_modules Not Added";
                                }
//                }
//                if(!$this->checkModule("user_modules","user_mod_{$this->moduleName}")){
                                $sql = "ALTER TABLE user_modules ADD COLUMN user_mod_{$this->moduleName} TINYINT(1) DEFAULT 0";
                                $stmt = $this->db->prepare($sql);
                                if ($stmt->execute()) {
                                        $report .= "user_modules Added";
                                } else {
                                        $report .= "user_modules Not Added";
                                }
//                }
                        } else {
                                $report .= "Module can't be Added to _modules";
                        }
                } else {
                        $report = "";
                        $report .= "Add module name `test`, `mail`,`shopping` uzw.";
                }
        }

        public function dropModule()
        {
                if (!empty($this->moduleName)) {
                        $report = "";
                        $sql = "DELETE FROM _modules WHERE name='{$this->moduleName}'";
                        // $this->setQueryString = $sql;
                        $this->setQueryString($sql);
                        $stmt = $this->db->prepare($sql);
                        if ($stmt->execute()) {
//                if($this->checkModule("_modules_default","mod_{$this->moduleName}")){
                                $sql = "ALTER TABLE _modules_default DROP COLUMN mod_{$this->moduleName}";
                                $stmt = $this->db->prepare($sql);
                                if ($stmt->execute()) {
                                        $report .= "_modules_default Added";
                                } else {
                                        $report .= "_modules_default Not Added";
                                }
//                }
//
//                if($this->checkModule("company_modules","mod_{$this->moduleName}")){
                                $sql = "ALTER TABLE company_modules DROP COLUMN mod_{$this->moduleName}";
                                $stmt = $this->db->prepare($sql);
                                if ($stmt->execute()) {
                                        $report .= "company_modules Added";
                                } else {
                                        $report .= "company_modules Not Added";
                                }
//                }
//
//                if($this->checkModule("user_modules","user_mod_{$this->moduleName}")){
                                $sql = "ALTER TABLE user_modules DROP COLUMN user_mod_{$this->moduleName}";
                                $stmt = $this->db->prepare($sql);
                                if ($stmt->execute()) {
                                        $report .= "user_modules Added";
                                } else {
                                        $report .= "user_modules Not Added";
                                }
//                }
                        } else {
                                $report .= "Module can't be Added to _modules";
                        }
                } else {
                        $report = "Add module name `test`, `mail`,`shopping` uzw.";
                }
        }

        function getTableColumns()
        {
                $stmt = $this->db->prepare("DESCRIBE " . $this->getTable());
                $stmt->execute();
                return $stmt->fetchALL(PDO::FETCH_COLUMN);
        }

        function checkColumnOfTable($columnName = "")
        {
                if (!empty($columnName)) {
                        $stmt = $this->db->prepare("DESCRIBE " . $this->getTable());
                        $stmt->execute();
                        if (in_array($columnName, $stmt->fetchALL(PDO::FETCH_COLUMN))) {
                                return TRUE;
                        } else {
                                return FALSE;
                        }
                }
        }

        /**
         *
         * @param type $columnName <p>Colon Adi</p>
         * @param type $type
         * @param type $lenght
         * @param type $default
         * @return string
         */
        function addColumnToTable($columnName = "", $type = "VARCHAR", $lenght = "255", $default = "")
        {

                if (!empty($columnName)) {
                        $stmt = $this->db->prepare("ALTER TABLE {$this->getTable()} ADD COLUMN {$columnName} {$type}({$lenght}) DEFAULT {$default}");
                        $stmt->execute();
                        return true;
                } else {
                        return false;
                }
        }

        function deleteColumnFromTable($columnName = "")
        {
                if (!empty($columnName)) {

                } else {
                        return "Missing Column Name";
                }
        }

}
