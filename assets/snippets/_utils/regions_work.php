<?php

class RegionWork {

    static public function pack($regions) {
        if (!is_array($regions)) {
            return '';
        }

        $pohodRgnsStr = '';
        foreach ($regions as $region)
            if ($region !== '0')
                $pohodRgns.= $region . ',';
        if ($pohodRgns !== '')
            $pohodRgns = substr($pohodRgns, 0, -1); // убираем последнюю запятую
        return $pohodRgns;
    }

    static public function unpack($packedRegionsStr) {
        return ($packedRegionsStr == '') ? Array() : explode(",", $packedRegionsStr);
    }

    static public function getRegionsRecursive($parentId = NULL, $strFiller = '', $strFillerAdd = '&nbsp;&nbsp;&nbsp;&nbsp;') {
        $regions = Array();
        if (isset($parentId))
            $q = "SELECT * FROM way_regions WHERE parent_id = $parentId ORDER BY name"; //echo $q;
        else
            $q = "SELECT * FROM way_regions WHERE parent_id IS NULL ORDER BY name";
		$sql = new connection();
		$mysqli = $sql->getConnect();
		$result = $mysqli->query($q);
        //$result = mysql_query($q);
        if (empty($result))
            return Array();  // no children
        for ($i = 0; $i < mysqli_num_rows($result); $i++) {
            $row = mysqli_fetch_array($result);
            $regions[] = Array('id' => $row['id'], 'name' => $strFiller . $row['name']);
            //if ($row['has_childrens'] !== NULL)
            $regions = array_merge($regions, self::getRegionsRecursive($row['id'], $strFiller . $strFillerAdd));
        }
        return $regions;
    }

    static public function populateRegionSelectList($selectedRegions = Array()) { // fill GUI selector list with regions names and ids
        $regions = self::getRegionsRecursive();
        $s = '';
        foreach ($regions as $region) {
            $selectedOption = in_array($region['id'], $selectedRegions) ? true : false;
            $s.= GUIHelpers::getSelectorOption($region['name'], $region['id'], $selectedOption);
        }
        return $s;
    }

    static public function getRegionSelectList() {
        return self::populateRegionSelectList();
    }

}

//************************************************************
// поиск по регионам
// simple region search version
/* function get_sql_search_str_for_region($region){
  if (($region !== '') and ($region != 0))
  $sql_search_str=" ((region = '$region') OR (region LIKE '$region,%') OR (region LIKE '%,$region') OR (region LIKE '%,$region,%'))";
  else
  $sql_search_str = '';
  return $sql_search_str;
  } */

// hierarchical region search version
function getChildsArray($parentId) {
    $r = Array();
    $q = "SELECT * FROM way_regions WHERE parent_id = '$parentId'";
    //$result = mysql_query($q);
	$sql = new connection();
		$mysqli = $sql->getConnect();
		$result = $mysqli->query($q);
    if (empty($result))
        return Array();  // no children
    for ($i = 0; $i < mysqli_num_rows($result); $i++) {
        $row = mysqli_fetch_array($result);
        $r[] = $row['id'];
//		if ($row['has_childrens'] !== NULL)
        $r = array_merge($r, getChildsArray($row['id']));
    }
    return $r;
}

function makeRegionsSQLSearchStr($regions) {
    $s = '';
    foreach ($regions as $region)
        $s.= ' ' . "((region = '$region') OR (region LIKE '$region,%') OR (region LIKE '%,$region') OR (region LIKE '%,$region,%'))" . ' OR ';
    $s = StringsWork::delLastSym($s, 3); // delete last OR
    return $s;
}

function get_sql_search_str_for_region($region) {
    if (($region !== '') and ( $region != 0)) {
        $childs = getChildsArray($region);
        $sql_search_str = makeRegionsSQLSearchStr(array_merge(Array($region), $childs));
    } else
        $sql_search_str = '';
    return $sql_search_str;
}

// получает имена всех регионов похода и выводит их через запятую
function getRegionsNames($regionsNumsStr) {
    $s = '';
    $regions = explode(',', $regionsNumsStr);
    foreach ($regions as $region) {
        $q = "SELECT TRIM(name) as name FROM way_regions WHERE id = '$region'";
        //$result = mysql_query($q);
		$sql = new connection();
		$mysqli = $sql->getConnect();
		$result = $mysqli->query($q);
        $row = mysqli_fetch_array($result);
        $s.= $row['name'] . ', ';
        /* if (strlen($s)>160){
          $s = substr($s, 0, -2).' ...  '; // убираем последнюю запятую и добавляем многоточие
          break;
          } */
    }
    $s = substr($s, 0, -2); // убираем последнюю запятую
    return $s;
}

// получает имена всех регионов похода и выводит массив регионов
function getRegionName($regionsNumsStr) {
    $s = '';
	$rus = 0;
	$ukr = 0;
    $regions = explode(',', $regionsNumsStr);
    foreach ($regions as $region) {
        $q = "SELECT id, TRIM(name) as name FROM way_regions WHERE id = '$region'";
        //$result = mysql_query($q);
		$sql = new connection();
		$mysqli = $sql->getConnect();
		$result = $mysqli->query($q);
        $row = mysqli_fetch_array($result);
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
	if ( $rus == 1) $s.= 'Россия' . ','; 
	if ( $ukr == 1) $s.= 'Украина' . ','; 
    $s = substr($s, 0, -1); // убираем последнюю запятую
    return $s;
}

// !!! не удалять, используется в eForm !!!
function populateRegionSelectList(&$fields, &$templates) {
    $fields['regions'] = RegionWork::populateRegionSelectList();
    return true;
}

?>