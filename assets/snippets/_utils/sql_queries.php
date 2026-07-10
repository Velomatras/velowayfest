<?php
// SQL DB helper functions
function get_sql_search_str_for_one_field_strict($fieldName, $searchValue){
	$sql_search_str = '';
	if ($searchValue !== '')
		$sql_search_str.=' ('.$fieldName.' = '."'$searchValue')";
	return $sql_search_str;
}

function get_sql_search_str_for_one_field($fieldName, $searchValue){
	$sql_search_str = '';
	if ($searchValue !== '')
		$sql_search_str.=' ('.$fieldName.' LIKE '."'%$searchValue%')";
	return $sql_search_str;
}
function get_sql_search_str_for_many_fields($field_and_strings){
	$sql_search_str = '';
	foreach ($field_and_strings as $field => $string)
		if ($string !== '')
			$sql_search_str.=' ('.$field.' LIKE '."'%$string%'".') AND';
	if ($sql_search_str !== ''){
		$sql_search_str = substr($sql_search_str, 0, strlen($sql_search_str)-3); // delete last AND
		$sql_search_str = '('.$sql_search_str.')';
	}
	return $sql_search_str;
}
function get_sql_search_str_for_all_fields($db_table_name, $search_str){
	$sql_search_str = '';
	if ($search_str !== ''){
		$q = "SHOW COLUMNS FROM $db_table_name";
		global $mysqli;
		$result = $mysqli->query ($q);
		for($i=0; $i<mysql_num_rows($result); $i++){
			$array = mysql_fetch_array($result);
			$sql_search_str.=' '.$array['Field'].' LIKE '."'%$search_str%' OR";
		}
		$sql_search_str = substr($sql_search_str, 0, strlen($sql_search_str)-2); // delete last OR
		$sql_search_str = '('.$sql_search_str.')';
	}
	return $sql_search_str;
}

function combine_sql_search_str($sql_search_str, $sql_search_str2){
	if ($sql_search_str2 !== '')
		if ($sql_search_str !== '')
			$sql_search_str = "($sql_search_str) AND ($sql_search_str2)";
		else
			$sql_search_str = $sql_search_str2;
	return $sql_search_str;
}

function get_sql_search_str_for_month($month){
	if (($month !== '') and ($month !== '00'))
// запрос заменяет месяц в начальной и текущей дате на интересующий нас, и проверяет - лежат ли эти даты внутри временного интервала похода
// сделано так хитро, чтобы обрабатывать ситуации, связанные, например, со сменой года во время похода
		$sql_search_str=" (DATEDIFF((date1 + INTERVAL $month - EXTRACT(MONTH FROM date1) MONTH), date1) >= 0) AND
			(DATEDIFF((date2 + INTERVAL $month - EXTRACT(MONTH FROM date2) MONTH), date2) <= 0)";
//		$sql_search_str=" (period LIKE '%.$month.%')";
	else
		$sql_search_str = '';
	return $sql_search_str;
}

function get_sql_search_str_for_onlyWinners($onlyWinners){
	if (isset($onlyWinners) and $onlyWinners)
		$sql_search_str=" ((prises IS NOT NULL) AND (prises<>''))";
	else
		$sql_search_str = '';
	return $sql_search_str;
}

function get_sql_search_str_for_TripWithOwners($flg){
	if (isset($flg) and $flg)
		$sql_search_str=" (ownerid IS NOT NULL) AND (ownerid != 0) ";
	else
		$sql_search_str = '';
	return $sql_search_str;
}

function get_sql_search_str_for_ownerID($ownerid){
	if (isset($ownerid) and $ownerid)
		$sql_search_str=" (ownerid = $ownerid) ";
	else
		$sql_search_str = '';
	return $sql_search_str;
}

function get_sql_search_str_for_year($year){
	if (($year !== '') and ($year !== '0000'))
		$sql_search_str=" (($year >= EXTRACT(YEAR FROM date1)) AND ($year <= EXTRACT(YEAR FROM date2)))";
	else
		$sql_search_str = '';
	return $sql_search_str;
}

function get_sql_search_str_for_name($name){
	if ($name !== '')
		//$sql_search_str=" (name LIKE '%$name%') ";
		$sql_search_str=" (( (TRIM(name) = '$name') OR name LIKE '% $name %') OR (TRIM(name) LIKE '$name %') OR (TRIM(name) LIKE '% $name') OR (TRIM(name) LIKE '%.$name')) ";
	else
		$sql_search_str = '';
	return $sql_search_str;
}

function get_sql_search_str_for_author($author){
	if ($author !== '')
		//$sql_search_str=" (name LIKE '%$name%') ";
		$sql_search_str=" (( (TRIM(author) = '$author') OR author LIKE '% $author %') OR (TRIM(author) LIKE '$author %') OR (TRIM(author) LIKE '% $author') OR (TRIM(author) LIKE '%.$author')) ";
	else
		$sql_search_str = '';
	return $sql_search_str;
}

?>