<?php 
//require_once 'assets/snippets/_utils/regions_work.php';

class Progress{
	private $userId = NULL;
	private $db_table_name = NULL;
	private $db_table_zayavka = NULL;
	private $mysqli = NULL;
	
	
	public function __construct($userId, $mysqli, $db_table_name, $db_table_zayavka) {
        $this->userId = $userId;
		$this->mysqli = $mysqli;
		$this->db_table_name = $db_table_name;
		$this->db_table_zayavka = $db_table_zayavka;
    }
	
// получает массив регионов, возвращает ID стран похода.
public function getRegionID($regionsNumsStr) {
    $s = '';
	$rus = 0;
	$ukr = 0;
    $reg = explode(',', $regionsNumsStr);
    foreach ($reg as $region) {
        $q = "SELECT id, TRIM(name) as name FROM way_regions WHERE id = '$region'";
		$result = $this->mysqli->query($q);
        //$result = mysql_query($q);
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
        //$row = mysql_fetch_array($result);
		if (($row['id'] >= 7 && $row['id'] <= 26) || ($row['id'] >= 40 && $row['id'] <= 43) || ($row['id'] >= 56 && $row['id'] <= 57) ) $rus = 1;
			else {
				if ($row['id'] == 33 || $row['id'] == 32) $ukr = 1; 
				else	$s.= $row['id'] . ',';
			}
        /* if (strlen($s)>160){
          $s = substr($s, 0, -2).' ...  '; // убираем последнюю запятую и добавляем многоточие
          break;
          } */
    }
	if ( $rus == 1) $s.= '7' . ','; 
	if ( $ukr == 1) $s.= '32' . ','; 
    $s = substr($s, 0, -1); // убираем последнюю запятую
	}
    return $s;
}

//Получение суммарного километража юзера
public function getMile(){
	$q = "SELECT mileage FROM $this->db_table_name WHERE ownerid = $this->userId "; 
	$result = $this->mysqli->query($q);
	$sumMile = 0;
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		if (!empty($row['mileage'])) $sumMile = $sumMile + $row['mileage'];
			}
			
			if (!empty($this->db_table_zayavka)){
			$q2 = sprintf("SELECT  mileage FROM $this->db_table_zayavka WHERE ownerid = $this->userId ");
	$result2 = $this->mysqli->query($q2);
	while($row = $result2->fetch_array(MYSQLI_ASSOC)){
	if (!empty($row['mileage'])) $sumMile = $sumMile + $row['mileage'];
 }
			}
			return $sumMile;
}

//Подсчёт числа посещённых стран
public function getRegions(){
	$region = $this->getRegNames();
	
$countRegions = count($region);
return $countRegions;
}

//возвращает массив имён посещённых стран
public function getRegNames(){
	$q = sprintf("SELECT region FROM $this->db_table_name WHERE ownerid = $this->userId "); 
	$result = $this->mysqli->query($q);
	$sumRegion = "";
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
	if (!empty($sumRegion))$sumRegion .= ",".$row['region'];
else $sumRegion .= $row['region'];
	}
	
	if (!empty($this->db_table_zayavka)){
	$q2 = sprintf("SELECT  region FROM $this->db_table_zayavka WHERE ownerid = $this->userId ");
	$result2 = $this->mysqli->query($q2);
	while($row = $result2->fetch_array(MYSQLI_ASSOC)){
	if (!empty($sumRegion))$sumRegion .= ",".$row['region'];
else $sumRegion .= $row['region'];
 }
	}
	$regStroke = $this->convRegionName($sumRegion);
	$regions = explode(',' , $regStroke);
$regionsUni = array_unique($regions);

return $regionsUni;
}

//возвращает массив имён посещённых регионов России
public function getRegNamesRussia(){
	$q = sprintf("SELECT region FROM $this->db_table_name WHERE ownerid = $this->userId "); 
	$result = $this->mysqli->query($q);
	$sumRegion = "";
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
	if (!empty($sumRegion))$sumRegion .= ",".$row['region'];
else $sumRegion .= $row['region'];
	}
	
	if (!empty($this->db_table_zayavka)){
	$q2 = sprintf("SELECT  region FROM $this->db_table_zayavka WHERE ownerid = $this->userId ");
	$result2 = $this->mysqli->query($q2);
	while($row = $result2->fetch_array(MYSQLI_ASSOC)){
	if (!empty($sumRegion))$sumRegion .= ",".$row['region'];
else $sumRegion .= $row['region'];
 }
	}
	$regStroke = $this->convRegionNameRussia($sumRegion);
	$regions = explode(',' , $regStroke);
$regionsUni = array_unique($regions);

return $regionsUni;
}

//преобразует массив кодов регионов в массив имён
public function convRegionName($regStroke) {
    $s = '';
	$rus = 0;
	$ukr = 0;
    
			$regFlag = explode(',', $regStroke);
    foreach ($regFlag as $region) {
        $q = "SELECT id, TRIM(name) as name FROM way_regions WHERE id = '$region'";
        $result = $this->mysqli->query($q);
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
        //$row = mysql_fetch_array($result);
		if (($row['id'] >= 7 && $row['id'] <= 26) || ($row['id'] >= 40 && $row['id'] <= 43) || ($row['id'] >= 56 && $row['id'] <= 57) ) $rus = 1;
			else {
				if ($row['id'] == 33 || $row['id'] == 32) $ukr = 1; 
				else	$s.= $row['name'] . ',';
			}
        /* if (strlen($s)>160){
          $s = substr($s, 0, -2).' ...  '; // убираем последнюю запятую и добавляем многоточие
          break;
          } */
    }
	}
	if ( $rus == 1) $s.= 'Россия' . ','; 
	if ( $ukr == 1) $s.= 'Украина' . ','; 
    $s = substr($s, 0, -1); // убираем последнюю запятую
    return $s;
}

//преобразует массив кодов регионов в массив имён регионов России
public function convRegionNameRussia($regionsNumsStr) {
    $s = '';
	$n = '';
	$rus = 0;
	$ukr = 0;
    $reg = explode(',', $regionsNumsStr);
    foreach ($reg as $region) {
        $q = "SELECT id, TRIM(name) as name FROM way_regions WHERE id = '$region'";
		//$q = sprintf("SELECT region FROM $this->db_table_name WHERE ownerid = $this->userId "); 
        $result = $this->mysqli->query($q);
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
        	if (($row['id'] >= 7 && $row['id'] <= 26) || ($row['id'] >= 40 && $row['id'] <= 43) || ($row['id'] >= 56 && $row['id'] <= 57) ) 
			{
				$s.= $row['id'] . ','; 
			    $n.= $row['name'] . ','; 
			}
        /* if (strlen($s)>160){
          $s = substr($s, 0, -2).' ...  '; // убираем последнюю запятую и добавляем многоточие
          break;
          } */
		}
	}
	
    $s = substr($s, 0, -1); // убираем последнюю запятую
	$n = substr($n, 0, -1); // убираем последнюю запятую
    return $n;
}

//подсчёт числа нагад за конкурсы Фестиваля
public function getPrises(){
	$q = sprintf("SELECT (CHAR_LENGTH(REPLACE(prises, ':', '**')) - CHAR_LENGTH(prises)) AS prises_num
 FROM $this->db_table_name WHERE ownerid = $this->userId "); 
 $result = $this->mysqli->query($q);
 $sumPrises = 0;
 while($row = $result->fetch_array(MYSQLI_ASSOC)){
	$sumPrises = $sumPrises + $row['prises_num']; 
 }
 return $sumPrises;
}

//вывод нагад за конкурсы Фестиваля
public function printPrises(){
	$q = sprintf("SELECT prises, year, (CHAR_LENGTH(REPLACE(prises, ':', '**')) - CHAR_LENGTH(prises)) AS prises_num
 FROM $this->db_table_name WHERE ownerid = $this->userId "); 
 $result = $this->mysqli->query($q);
 $sumPrises = 0;
 echo '<br>';
 while($row = $result->fetch_array(MYSQLI_ASSOC)){
	$sumPrises = $sumPrises + $row['prises_num']; 
	
    print_winner_result2($row['prises'], $row['year']);
	 }
	 if ($sumPrises > 0) echo '<br><br><br><br><br><br>';
 return $sumPrises;
}

//вывод числа наград по конкретным конкурсам и годам
public function getPrisesFest(){
$q = sprintf("SELECT year, prises, video_url, link
 FROM $this->db_table_name WHERE ownerid = $this->userId ");
 $result = $this->mysqli->query($q);
 $places = Array();
  while($row = $result->fetch_array(MYSQLI_ASSOC)){
	if ($row['prises'] == '') continue;
        $places = array_merge($places, json_decode($row['prises'], true)); 
 }
}

//суммарное число дней проведённое в походах
public function getDuration(){
	$q = sprintf("SELECT period FROM $this->db_table_name WHERE ownerid = $this->userId "); 
	$result = $this->mysqli->query($q);
	$sumDuration = 0; //дней за все походы
	
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
	$sumDuration = $sumDuration + $this->get_trip_duration($row['period']);
 }
 if (!empty($this->db_table_zayavka)){
 $q2 = sprintf("SELECT period FROM $this->db_table_zayavka WHERE ownerid = $this->userId ");
	$result2 = $this->mysqli->query($q2);
	while($row = $result2->fetch_array(MYSQLI_ASSOC)){
	$sumDuration = $sumDuration + $this->get_trip_duration($row['period']);
 }
 }
 return $sumDuration;
}

//число написанных отчётов
public function getReport(){
	$q = sprintf("SELECT count(*) as cnt FROM $this->db_table_name WHERE ownerid = $this->userId ");
	$result = $this->mysqli->query($q);
	$report1 = '';
	$report2 = '';
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
	$report1 = (int)$row['cnt'];
 }
    if (!empty($this->db_table_zayavka)){
		$q2 = sprintf("SELECT count(*) as cnt2 FROM $this->db_table_zayavka WHERE ownerid = $this->userId ");
	$result2 = $this->mysqli->query($q2);
	while($row = $result2->fetch_array(MYSQLI_ASSOC)){
	$report2 = (int)$row['cnt2'];
 }
	}
	else $report2 = 0;
 $report = $report1 + $report2;
 return $report;
}

// ************************* из строки со сроками получаем длительность похода в днях ***********
public function get_trip_duration($period){ 
		if (empty($period)) return 0;
		$dates = $this->getDates($period);
		$duration = 0;
		if (count($dates) == 2) {
			$duration = date_diff(date_create($dates[1]), date_create($dates[0]))->format('%a');
			$duration = $duration + 1;
		}
		return $duration;
	}
public	function getDates($period){return empty($period) ? NULL : explode("-", $period);}

//конвертация массива в строковое представление через запятую
public static function convStroke($arr){
	$s = '';
	foreach ($arr as $row) {
		if (!empty($s))$s.= ", $row";
		else $s.= "$row";
}
return $s;

}

//вывод наград за судейство и вклад если таковые имеются
public function getPrisesSpec() {
	 		$q = sprintf("SELECT prises FROM $this->db_table_name WHERE id = $this->userId "); 
	$result = $this->mysqli->query($q);
		
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
	$results_str = $row['prises'];
	}
	
    if ($results_str == '')
        return;
	echo "<hr><s1>Особые награды:</s1><br><br>";
	
    $places = json_decode($results_str, true);
    foreach ($places as $category => $result) {
        //$nomination_name = library_get_nomination_name($category);
		$cat = substr($category, 0, 4);
        if ($result == 3) {
			echo '<figure>';
        echo "<img align=\"center\" src=\"assets/templates/veloway/images/sova.png\" alt=\"за вклад\"
		title=\"за вклад в развитие велотуризма $cat\">";
        //echo "<figcaption>" . $nomination_name . "</figcaption>";
        
            echo "&ensp; $cat: <b>ЗА ВКЛАД В РАЗВИТИЕ ВЕЛОТУРИЗМА</b><br>";
			echo "</figure>";
		           }
        if ($result == 1) {
			echo '<figure>';
        echo "<img align=\"center\" src=\"assets/templates/veloway/images/magistr.png\" alt=\"лучший судья\"
		title=\"лучший судья $cat\">";
               
		echo "&ensp; $cat: <b>ЛУЧШИЙ СУДЬЯ</b><br>";
            			echo "</figure>";
			
                 } 
		if ($result == 2) {
			echo "<img align=\"center\" src=\"assets/templates/veloway/images/magistr.png\" alt=\"лучший зритель\"
		title=\"лучший зритель $cat\">";
               
		echo "&ensp; $cat: <b>ЛУЧШИЙ ЗРИТЕЛЬ</b><br>";
			                 } 
    }
	return;
}
}
?>