<?php 

class Bookmark{
	private $userId = NULL;
	private $db_table_name = NULL;
	private $mysqli = NULL;
	public function __construct($userId, $mysqli, $db_table_name) {
        $this->userId = $userID;
		$this->mysqli = $mysqli;
		$this->db_table_name = $db_table_name;
    }
//Функция получения массива кодов закладок
function bookmark ($book){
$mark = explode("," , $book);
return $mark;
}

//обратная функция получения строчного представления массива
//function markbook ($trip_id, $mark){

//	foreach ($mark as $row => $result ){
//	$book ="";
//    if ($trip_id != $result && isset($book))	$book = "$book" . "," . "$result";	
//	if ($trip_id != $result && empty($book))	$book = $result;
	
//	}
//	return $book;
//}

//функция добавления новой закладки
function addMark ($trip_id, $book){
	
	//проверка существования отчёта в библиотеке
if (empty($trip_id)) return 0;

    //проверка не добавляется ли отчёт повторно
$mark = bookmark ($book);
$unicum = unicumMark ($trip_id, $mark);
if ($unicum == false) return 0;	

if (!empty($book)) $newBook = "$book,$trip_id";
else $newBook = $trip_id;
//$newBook = $mysqli->real_escape_string($newBook);

$q3 = "UPDATE $this->db_table_name SET bookmarks = \"$newBook\" WHERE id = \"$this->userId\"";
//$q3 = "UPDATE '$this->db_table_name' SET bookmarks = '$newBook' WHERE id = '$this->userId'";
$this->mysqli->query($q3);

return 1;
}

//функция удаления всех закладок
function delMarkAll (){
	
$q4 = "UPDATE $this->db_table_name SET bookmarks = '' WHERE id = \"$this->userId\"";
$text = $this->mysqli->query($q4);

if ($text === true) $text = "<br>закладки успешно удалены!";
else $text = "<br>запрос не выполнен!!";
return $text;	
}

//функция удаления одной закладки
function delMark ($trip_id, $book){
	
	//проверка существования отчёта в библиотеке
if (empty($trip_id)) return 0;

$mark = bookmark ($book);
$newBook = '';
foreach ($mark as $row){
	if ($row == $trip_id) continue;
	if (!empty($newBook)) $newBook .= "," . $row ;
	else $newBook = $row ;
	}
//$newBook = markbook ($trip_id, $mark)
	
$q = "UPDATE $this->db_table_name SET bookmarks = \"$newBook\" WHERE id = \"$this->userId\"";
$text = $this->mysqli->query($q);

if ($text === true) $text = "<br>закладка успешно удалена!";
else $text = "<br>запрос не выполнен!!";
return $text;	
}

//функция проверки уникальности закладки
function unicumMark ($trip_id, $mark){
 foreach ($mark as $row){
	 if ($row == $trip_id) return false;
 }
 return true;
}  	

//функция подсчёта числа закладок
function counMark (){
$q = "SELECT id, bookmarks FROM $this->db_table_name WHERE id = $this->userId";	
$result = $this->mysqli->query($q);
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$book = $row[bookmarks];
	}
	$mark = bookmark ($book);
	if (empty($mark)) return 0;
	$coun = count($mark);
	return $coun;
}
}
?>