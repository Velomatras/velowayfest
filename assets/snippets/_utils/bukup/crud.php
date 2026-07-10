<?php


// CRUD with PHP functions for ModX
class MyCRUD_Modx {
	

    //private $link = null;
    private $DBTableName = '';
	private $sql2 = '';
	//private $mysqli;

    public function __construct($tabName) {
		
        $this->DBTableName = $tabName;
		//global $mysqli;
		$sql = new connection();
		$this->sql2 = $sql->getConnect();
		//$mysqli = new mysqli($database_server, $database_user, $database_password, $dbase);
        /* $link = mysql_connect('localhost', 'root', '');// ModX connects the database, so we don't need this
          if (!$link)
          die('Error: ' . mysql_error());
          $this->link = $link; */
		  
    }

    public function __destruct() {
        //mysql_close($this->link);
    }

    // замена ф-ции mysql_escape, чтобы была хоть какая-то защита от SQL-injection
    // в отличие от нее, не обрабатывает /r и /n, т.к. с ними возникает глюк при записи многострочных текстовых значений
    private function sanitizeStr($inp) {
        //return $inp;/// don't work yet
        if (!empty($inp) && is_string($inp)) {
            return str_replace(
                array("\0", "'", '"', "\x1a"),
                array('\\0', "", "", ""), $inp);
                //array('\\0', "\\'", '\\"', '\\Z'), $inp);
        }
        return $inp;
    }

    private function prepareSQLQueryCondition($conditions, $conditionWithLike = false) {
        if (empty($conditions) || !is_array($conditions)) {
            return '';
        }

        $q = '';
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
        $qParams = Array();
        foreach ($fieldsAndValues as $field => $value){
            $qParams[] =' `' . $field . "`='" . $this->sanitizeStr($value) . "'";
        }
        return implode(',', $qParams);
    }

    public function doSQLQuery($q) {
		
		       printDebugLog($q);
			   
			   //Было так
			   //$result = mysql_query($q);
			   //$database_server = 'localhost';
//$database_user = 'u1561280_lion';
//$database_password = 'slavka04072015!';
//$dbase = 'u1561280_veloway-test';
			    
			    //  global $mysqli;
			      $result = $this->sql2->query($q);
        if ($result === FALSE) {
            throw new Exception("MYSQL error: " . mysql_error() . " Query: " . $q);
        }
        return $result;
    }

    public function doRawSQLQuery($q) {
        $result = $this->doSQLQuery($q);
        if ($result === FALSE) {
            return Array();
        }
        $data = Array();
        for ($i = 0; $i < mysqli_num_rows($result); $i++) {
            $data[] = mysqli_fetch_array($result);
        }
        return $data;
    }

    public function getRowsNum($conditions = Array()) {
        $q1 = $this->prepareSQLQueryCondition($conditions);
        if ($q1 !== '') {
            $q1 = ' WHERE ' . $q1;
        }
        $q = "SELECT COUNT(*) AS rowsNum FROM `$this->DBTableName`" . $q1;
        $r = $this->doSQLQuery($q);
        $data[] = empty($r) ? null : mysqli_fetch_array($r);
        return empty($data) ? 0 : $data[0]['rowsNum'];
    }

    public function getRecords($conditions = Array(), $sortField = '', $conditionWithLike = false, $sortOrder = '') {
        $q1 = $this->prepareSQLQueryCondition($conditions, $conditionWithLike);
        if ($q1 !== '') {
            $q1 = ' WHERE ' . $q1;
        }
        $q = "SELECT * FROM " . $this->DBTableName . $q1;
        if (!empty($sortField)){
            $q.= " ORDER BY `$sortField`";
        }
        if (!empty($sortOrder) && $sortOrder = 'desc'){
            $q.= " DESC";
        }
        printDebugLog($q);
        $result = $this->doSQLQuery($q);

        if (!$result){
            return Array();
        }

        $data = Array();
        for ($i = 0; $i < mysqli_num_rows($result); $i++) {
            $data[] = mysqli_fetch_array($result);
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
        for ($i = 0; $i < mysqli_num_rows($result); $i++) {
            $data[] = mysqli_fetch_array($result);
        }
        return $data;
    }

    public function getRow($conditions = Array()) {
        $r = $this->getRecords($conditions);
        return (count($r) == 0) ? null : $r[0];
    }

    public function haveRow($conditions = Array()) {
        $r = $this->getRow($conditions);
        return $r !== null;
    }

    public function getAllRecords($sortField = '') {
        return $this->getRecords(Array(), $sortField);
    }

    public function delete($conditions) {
        if (empty($conditions)) {
            return;
        }
        $q = $this->prepareSQLQueryCondition($conditions);
        if (empty($q)) {
            return;
        }
        $q = "DELETE FROM " . $this->DBTableName . " WHERE" . $q;
        printDebugLog($q, __function__);
        $this->doSQLQuery($q);
    }

    public function insert($fieldsAndValues) {
        $q1 = $this->prepareSQLQueryData($fieldsAndValues);
        $q = "INSERT INTO $this->DBTableName SET $q1";
        $this->doSQLQuery($q);//echo $q.mysql_insert_id().$r;
        printDebugLog($q);//echo $q;
        return mysqli_insert_id();
    }

    public function update($conditions, $fieldsAndValues) {
//        print_r($fieldsAndValues);
        $q1 = $this->prepareSQLQueryData($fieldsAndValues);
        $q = $this->prepareSQLQueryCondition($conditions);
        if (empty($q)) {
            return;
        }
        $q = "UPDATE " . $this->DBTableName . " SET $q1" . " WHERE" . $q;
        $this->doSQLQuery($q);//        echo $q; die();
        printDebugLog($q);
    }

    public function upsert($conditions, $fieldsAndValues) {
        if ($this->getRow($conditions) === null) {
            $this->insert($fieldsAndValues);
            return mysqli_insert_id();
        } else {
            $this->update($conditions, $fieldsAndValues);
            return null;
        }
    }

    public function getAutoincrementValue() {
        $q = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE `TABLE_NAME` = '$this->DBTableName'";
        $result = $this->doSQLQuery($q);
        $data = mysqli_fetch_array($result);
        return $data['AUTO_INCREMENT'];
    }

    public function setAutoincrementValue($value) {
        $q = "ALTER TABLE `$this->DBTableName` AUTO_INCREMENT = $value";
        $this->doSQLQuery($q);
    }
}
