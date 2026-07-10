<?php

// CRUD with PHP functions for ModX
class MyCRUD_Modx {
    //private $link = NULL;
    private $DBTableName = '';
    private $DBTableName = '';
    private $dbname = '';
    private $host = '';
    private $charset = '';
    private $pdo;

    public function __construct($tabName) {
        $this->DBTableName = $tabName;
        $user = '';
        $pass = '';

        $dsn = "mysql:host=$this->host;dbname=$this->dbname;charset=$charset";
        $opt = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $this->pdo = new PDO($dsn, $user, $pass, $opt);
    }

    public function __destruct() {
        //mysql_close($this->link);
    }

    // замена ф-ции mysql_escape, чтобы была хоть какая-то защита от SQL-injection
    // в отличие от нее, не обрабатывает /r и /n, т.к. с ними возникает глюк при записи многострочных текстовых значений
    private function sanitizeStr($inp) {
        //return $inp;/// don't work yet

        //return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
        if (!empty($inp) && is_string($inp)) {
            return str_replace(
                array("\0", "'", '"', "\x1a"),
                array('\\0', "\\'", '\\"', '\\Z'), $inp);
        }

        return $inp;
    }

    private function delLastSym(&$s, $symsDelNum = 1) {
        $s = substr($s, 0, -$symsDelNum);
        return $s;
    }

    private function prepareSQLQueryCondition($conditions, $conditionWithLike = false) {
        $q = '';
        if (!isset($conditions) || empty($conditions))
            return $q;
        $getConditionFunc = $conditionWithLike ? get_sql_search_str_for_one_field : get_sql_search_str_for_one_field_strict;
        foreach ($conditions as $field => $value){
            $q = combine_sql_search_str($q, $getConditionFunc($field, $this->sanitizeStr($value))); //here shoul be mysqlescape
        }
        return $q;
    }

    private function array_to_obj($array, &$obj) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $obj->$key = new stdClass();
                array_to_obj($value, $obj->$key);
            } else {
                $obj->$key = $value;
            }
        }
        return $obj;
    }

    private function arrayToObject($array) {
        $object = new stdClass();
        return $this->array_to_obj($array, $object);
    }

    // making some kind of Active Records
    private function prepareSQLQueryData($fieldsAndValues) {
        $q = '';
        foreach ($fieldsAndValues as $field => $value){
            $q.=' `' . $field . "`='" . $this->sanitizeStr($value) . "',"; //here shoul be mysqlescape
        }
        return self::delLastSym($q);
    }

    public function doSQLQuery($q) {
        global $mysqli;
		printDebugLog($q);
        return $mysqli->query($q);
    }

    public function getRowsNum($conditions = Array()) {
        $q1 = $this->prepareSQLQueryCondition($conditions);
        if ($q1 !== '')
            $q1 = ' WHERE ' . $q1;
        $q = "SELECT COUNT(*) AS rowsNum FROM `$this->DBTableName`" . $q1;
        $r = $this->doSQLQuery($q);
        $data[] = empty($r) ? NULL : mysql_fetch_array($r);
        return empty($data) ? 0 : $data[0]['rowsNum'];
    }

    public function getRecords($conditions = Array(), $sortField = '', $conditionWithLike = false) {
        $q1 = $this->prepareSQLQueryCondition($conditions, $conditionWithLike);
        if ($q1 !== '')
            $q1 = ' WHERE ' . $q1;
        $q = "SELECT * FROM " . $this->DBTableName . $q1;
        if ($sortField !== ''){
            $q.= " ORDER BY `$sortField`";
        }
        printDebugLog($q);
        $result = $this->doSQLQuery($q);

        if (!$result){
            return Array();
        }

        $data = Array();
        for ($i = 0; $i < mysql_num_rows($result); $i++) {
            $data[] = mysql_fetch_array($result);
        }
        return $data;
    }

    public function getRecordsUsingQuery($query) {

        printDebugLog($query);
        $result = $this->doSQLQuery($query);

        if (!$result){
            return Array();
        }

        $data = Array();
        for ($i = 0; $i < mysql_num_rows($result); $i++) {
            $data[] = mysql_fetch_array($result);
        }
        return $data;
    }

    public function getRow($conditions = Array()) {
        $r = $this->getRecords($conditions);
        return (count($r) == 0) ? NULL : $r[0];
    }

    public function haveRow($conditions = Array()) {
        $r = $this->getRow($conditions);
        return $r !== NULL;
    }

    public function getAllRecords($sortField = '') {
        return $this->getRecords(Array(), $sortField);
    }

    public function delete($conditions) {
        if (empty($conditions))
            return;
        $q = $this->prepareSQLQueryCondition($conditions);
        if (empty($q))
            return;
        $q = "DELETE FROM " . $this->DBTableName . " WHERE" . $q;
        printDebugLog($q, __function__);
        $this->doSQLQuery($q);
    }

    public function insert($fieldsAndValues) {
        $q1 = $this->prepareSQLQueryData($fieldsAndValues);
        $q = "INSERT INTO $this->DBTableName SET $q1";
        $this->doSQLQuery($q);//echo $q.mysql_insert_id().$r;
        printDebugLog($q); echo $q;
        return mysql_insert_id();
    }

    public function update($conditions, $fieldsAndValues) {
//        print_r($fieldsAndValues);
        $q1 = $this->prepareSQLQueryData($fieldsAndValues);
        $q = $this->prepareSQLQueryCondition($conditions);
        if ($q === '')
            return;
        $q = "UPDATE " . $this->DBTableName . " SET $q1" . " WHERE" . $q;
        $this->doSQLQuery($q);
        printDebugLog($q);
    }

    public function upsert($conditions, $fieldsAndValues) {
        $q1 = $this->prepareSQLQueryData($fieldsAndValues);
        $q2 = $this->prepareSQLQueryCondition($conditions);
        $q = "INSERT INTO $this->DBTableName SET $q1
        ON DUPLICATE KEY UPDATE SET $q1 "  . " WHERE $q2";
        $this->doSQLQuery($q);echo $q.mysql_insert_id();
        printDebugLog($q);
        return mysql_insert_id();
    }

    public function getAutoincrementValue() {
        $q = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE `TABLE_NAME` = '$this->DBTableName'";
        $result = $this->doSQLQuery($q);
        $data = mysql_fetch_array($result);
        return $data['AUTO_INCREMENT'];
    }

    public function setAutoincrementValue($value) {
        $q = "ALTER TABLE `$this->DBTableName` AUTO_INCREMENT = $value";
        $this->doSQLQuery($q);
    }
}
