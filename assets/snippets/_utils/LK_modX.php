<?php

class LK_modX {
//Функция получения массива кодов закладок
public function bookmark ($book){
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
public function addMark ($trip_id, $book, $userId, $mysqli, $db_table_name){
	
	//проверка существования отчёта в библиотеке
if (empty($trip_id)) return 0;

    //проверка не добавляется ли отчёт повторно
$mark = bookmark ($book);
$unicum = unicumMark ($trip_id, $mark);
if ($unicum == false) return 0;	

if (!empty($book)) $newBook = "$book,$trip_id";
else $newBook = $trip_id;
//$newBook = $mysqli->real_escape_string($newBook);

$q3 = "UPDATE $db_table_name SET bookmarks = \"$newBook\" WHERE id = \"$userId\"";
//$q3 = "UPDATE '$db_table_name' SET bookmarks = '$newBook' WHERE id = '$userId'";
$mysqli->query($q3);

return 1;
}

//функция удаления всех закладок
public function delMarkAll ($userId, $mysqli, $db_table_name){
	
$q4 = "UPDATE $db_table_name SET bookmarks = '' WHERE id = \"$userId\"";
$text = $mysqli->query($q4);

if ($text === true) $text = "<br>закладки успешно удалены!";
else $text = "<br>запрос не выполнен!!";
return $text;	
}

//функция удаления одной закладки
public function delMark ($trip_id, $book, $userId, $mysqli, $db_table_name){
	
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
	
$q = "UPDATE $db_table_name SET bookmarks = \"$newBook\" WHERE id = \"$userId\"";
$text = $mysqli->query($q);

if ($text === true) $text = "<br>закладка успешно удалена!";
else $text = "<br>запрос не выполнен!!";
return $text;	
}

//функция проверки уникальности закладки
public function unicumMark ($trip_id, $mark){
 foreach ($mark as $row){
	 if ($row == $trip_id) return false;
 }
 return true;
}  	

//функция подсчёта числа закладок
public function counMark ($userId, $mysqli, $db_table_name){
$q = "SELECT id, bookmarks FROM $db_table_name WHERE id = $userId";	
$result = $mysqli->query($q);
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