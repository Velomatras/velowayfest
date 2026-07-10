<?php
// поиск в библиотеке походов
require 'assets/snippets/aux_funcs.php';
function add_param(&$params, $param_name){	
	$s = ParamsWork::sanitizeSQLStr($_REQUEST[$param_name]);
	if ($s !== '')
		$params[$param_name] = $s;
}

// поиск походов в библиотеке походов
function list_library(&$fields){		
// получаем из формы введенные данные     
	add_param($params, 'region');
	add_param($params, 'name');
	add_param($params, 'route');
	add_param($params, 'year');
	add_param($params, 'month');
	add_param($params, 'city');
	add_param($params, 'command');	
	add_param($params, 'onlyWinners');
	add_param($params, 'onlyTripWithOwners');
	add_param($params, 'forLev1');	
//	add_param($params, 'search_all_fields_str');	
// делаем строку для передачи параметров на страницу поиска
	$params_str = http_build_query($params);
// переходим на страницу поиска	
	URLWork::goURL("/library_found.html?$params_str");
	
    return true; // Говорим eForm, что все в порядке.
}

function getRegionData($regionId, $db_table_name, $db_table_regions)
{
    //$regionId = intval($regionId);
    //echo $regionId;
    $userID = 167;
	
    $q_region = "SELECT name FROM $db_table_regions WHERE id = '$regionId'";
    $result_region = mysql_query($q_region);
    $regionData = mysql_fetch_array($result_region);
	
	$sql_search = get_sql_search_str_for_region($regionId);
    $q_count = "SELECT COUNT(*) AS count FROM $db_table_name WHERE $sql_search";
    $result = mysql_query($q_count);
    $array = mysql_fetch_array($result);
    $count = $array['count'];
	
	//получение ссылки на походы по данному региону
$url_reg = "http://www.veloway.su/library_found.html?region=".$regionId;
    //получение ссылки на флаг
$url_flag = "http://www.veloway.su/assets/images/flags/".$regionData[0].".gif";
	
    return array($regionData[0], $count, $url_reg, $url_flag);
}


$db_table_name = 'way_library';    // имя таблицы БД
$db_table_regions = 'way_regions';

//запрос на получение кода региона
$q_regionID = "SELECT id, name, parent_id FROM $db_table_regions WHERE parent_id IS NULL ORDER BY name";
    $result_regionID = mysql_query ($q_regionID);
	$regionTable = mysql_fetch_array($result_regionID);	

$summ_count = "SELECT COUNT(*) AS count FROM $db_table_name";
$result_summ = mysql_query($summ_count);	
$array_summ = mysql_fetch_array($result_summ);		

			
	
$width = 60;
$height = 33;

//$regionId = 7; //номер региона
?>
<style type="text/css">
   table {
    background: #fbe6cf; /* Цвет фона таблицы */
       }
   td {
    background: #fdfae2; /* Цвет фона ячеек */
   }
   colorZero {
	   color: #fdfae2; 
   }
  </style>
  <p>Всего отчётов в библиотеке: <?= $array_summ[0] ?></p>
  <table>
<?php
//list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($regionTable, $db_table_name, $db_table_regions);
// foreach ($regionTable as $key => $value){
//	for ($i = 1; $i <= 137; $i++) {
	
	//**************************  Отображение регионов России  **************************************************************
	
	$russia = 7;
	$altai = 8;
	$dal_vostok = 41;
	$kamchatka = 21;
	$primorie = 42;
	$sahalin = 43;
	$evrRussia = 9;
	$kaliningrad = 20;
	$severRussia = 10;
	$centerRussia = 11;
	$yugRussia = 15;
	$karelia = 22;
	$kolski = 23;
	$valdai = 12;
	$meshera = 14;
	$podmoskow = 13;
	$kavkaz = 16;
	$vostKavkaz = 19;
	$zapKavkaz = 17;
	$centerKavkaz = 18;
	$pribaikal = 24;
	$sayani = 25;
	$hakasia = 40;
	$ural = 26;
	$zapSibir = 56;
	$zabaikal = 57;
	
		list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($russia, $db_table_name, $db_table_regions);
		$url_flag = "http://www.veloway.su/assets/images/flags/"."Россия".".gif";
	?>
 <tr>

        <td>
            <a href="<?= $url_reg ?>"><img src="<?= $url_flag ?>" width=$width height=$height alt="country flag image"></a>
        </td>
        <td>
            <a href="<?= $url_reg ?>"><?= $regionDataID ?> </a>
			(<?= $count ?>)
        </td>

        
            
        

    </tr>
	
	<?php
	list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($altai, $db_table_name, $db_table_regions);
	?>
	<tr><td></td>
	        <td>
           <colorZero>--</colorZero>- <a href="<?= $url_reg ?>"><?= $regionDataID ?> </a>
			(<?= $count ?>)
        </td>
		</tr>
		
		<?php
	list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($dal_vostok, $db_table_name, $db_table_regions);
	?>
	<tr>
	<td></td>
        <td>
           <colorZero>--</colorZero>- <a href="<?= $url_reg ?>"><?= $regionDataID ?> </a>
			(<?= $count ?>)
        </td>
		</tr>
		
		<?php
	list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($kamchatka, $db_table_name, $db_table_regions);
	?>
	<tr><td></td>
	        <td>
           <colorZero>-------</colorZero>- <a href="<?= $url_reg ?>"><?= $regionDataID ?> </a>
			(<?= $count ?>)
        </td>
		</tr>
		<?php
	list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($primorie, $db_table_name, $db_table_regions);
	?>
	
	<tr>
	<td></td>
        <td>
           <colorZero>-------</colorZero>- <a href="<?= $url_reg ?>"><?= $regionDataID ?> </a>
			(<?= $count ?>)
        </td>
		</tr>
		
		<?php
	list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($sahalin, $db_table_name, $db_table_regions);
	?>
	<tr><td></td>
	        <td>
           <colorZero>-------</colorZero>- <a href="<?= $url_reg ?>"><?= $regionDataID ?> </a>
			(<?= $count ?>)
        </td>
		</tr>
		
		<?php
	list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($evrRussia, $db_table_name, $db_table_regions);
	?>
	<tr>
	<td></td>
        <td>
           <colorZero>--</colorZero>- <a href="<?= $url_reg ?>"><?= $regionDataID ?> </a>
			(<?= $count ?>)
        </td>
		</tr>
		
		<?php
	list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($kaliningrad, $db_table_name, $db_table_regions);
	?>
	<tr><td></td>
	        <td>
           <colorZero>-------</colorZero>- <a href="<?= $url_reg ?>"><?= $regionDataID ?> </a>
			(<?= $count ?>)
        </td>
		</tr>
		
		<?php
	list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($severRussia, $db_table_name, $db_table_regions);
	?>
	<tr>
	<td></td>
        <td>
           <colorZero>-------</colorZero>- <a href="<?= $url_reg ?>"><?= $regionDataID ?> </a>
			(<?= $count ?>)
        </td>
		</tr>
		
		<?php
	list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($karelia, $db_table_name, $db_table_regions);
	?>
	<tr>
	<td></td>
        <td>
           <colorZero>------------</colorZero>- <a href="<?= $url_reg ?>"><?= $regionDataID ?> </a>
			(<?= $count ?>)
        </td>
		</tr>
		
		<?php
	list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($kolski, $db_table_name, $db_table_regions);
	?>
	<tr>
	<td></td>
	<td>        
		  <colorZero>------------</colorZero>- <a href="<?= $url_reg ?>"><?= $regionDataID ?> </a>
			(<?= $count ?>)
        </td>
		</tr>
		
		<?php
	list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($centerRussia, $db_table_name, $db_table_regions);
	?>
	<tr>
	<td></td>
        <td>
           <colorZero>-------</colorZero>- <a href="<?= $url_reg ?>"><?= $regionDataID ?> </a>
			(<?= $count ?>)
        </td>
		</tr>
		
		<?php
	list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($valdai, $db_table_name, $db_table_regions);
	?>
	<tr>
	<td></td>
        <td>
           <colorZero>------------</colorZero>- <a href="<?= $url_reg ?>"><?= $regionDataID ?> </a>
			(<?= $count ?>)
        </td>
		</tr>
		
		<?php
	list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($meshera, $db_table_name, $db_table_regions);
	?>
	<tr>
	<td></td>
        <td>
           <colorZero>------------</colorZero>- <a href="<?= $url_reg ?>"><?= $regionDataID ?> </a>
			(<?= $count ?>)
        </td>
		</tr>
		
		<?php
	list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($podmoskow, $db_table_name, $db_table_regions);
	?>
	<tr>
	<td></td>
        <td>
           <colorZero>------------</colorZero>- <a href="<?= $url_reg ?>"><?= $regionDataID ?> </a>
			(<?= $count ?>)
        </td>
		</tr>
		
		<?php
	list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($yugRussia, $db_table_name, $db_table_regions);
	?>
	<tr>
	<td></td>
        <td>
           <colorZero>-------</colorZero>- <a href="<?= $url_reg ?>"><?= $regionDataID ?> </a>
			(<?= $count ?>)
        </td>
		</tr>
		
		<?php
	list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($kavkaz, $db_table_name, $db_table_regions);
	?>
	<tr>
	<td></td>
        <td>
           <colorZero>------------</colorZero>- <a href="<?= $url_reg ?>"><?= $regionDataID ?> </a>
			(<?= $count ?>)
        </td>
		</tr>
		
		<?php
	list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($vostKavkaz, $db_table_name, $db_table_regions);
	?>
	<tr>
	<td></td>
        <td>
           <colorZero>-----------------</colorZero>- <a href="<?= $url_reg ?>"><?= $regionDataID ?> </a>
			(<?= $count ?>)
        </td>
		</tr>
		
		<?php
	list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($zapKavkaz, $db_table_name, $db_table_regions);
	?>
	<tr>
	<td></td>
        <td>
           <colorZero>-----------------</colorZero>- <a href="<?= $url_reg ?>"><?= $regionDataID ?> </a>
			(<?= $count ?>)
        </td>
		</tr>
		
		<?php
	list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($centerKavkaz, $db_table_name, $db_table_regions);
	?>
	<tr>
	<td></td>
        <td>
           <colorZero>-----------------</colorZero>- <a href="<?= $url_reg ?>"><?= $regionDataID ?> </a>
			(<?= $count ?>)
        </td>
		</tr>
		
		<?php
	list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($pribaikal, $db_table_name, $db_table_regions);
	?>
	<tr>
	<td></td>
        <td>
           <colorZero>--</colorZero>- <a href="<?= $url_reg ?>"><?= $regionDataID ?> </a>
			(<?= $count ?>)
        </td>
		</tr>
		
		<?php
	list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($sayani, $db_table_name, $db_table_regions);
	?>
	<tr>
	<td></td>
        <td>
           <colorZero>--</colorZero>- <a href="<?= $url_reg ?>"><?= $regionDataID ?> </a>
			(<?= $count ?>)
        </td>
		</tr>
		
		<?php
	list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($hakasia, $db_table_name, $db_table_regions);
	?>
	<tr>
	<td></td>
        <td>
           <colorZero>--</colorZero>- <a href="<?= $url_reg ?>"><?= $regionDataID ?> </a>
			(<?= $count ?>)
        </td>
		</tr>
		
		<?php
	list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($ural, $db_table_name, $db_table_regions);
	?>
	<tr>
	<td></td>
        <td>
           <colorZero>--</colorZero>- <a href="<?= $url_reg ?>"><?= $regionDataID ?> </a>
			(<?= $count ?>)
        </td>
		</tr>
		
		<?php
	list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($zapSibir, $db_table_name, $db_table_regions);
	?>
	<tr>
	<td></td>
        <td>
           <colorZero>--</colorZero>- <a href="<?= $url_reg ?>"><?= $regionDataID ?> </a>
			(<?= $count ?>)
        </td>
		</tr>
		
		<?php
	list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($zabaikal, $db_table_name, $db_table_regions);
	?>
	<tr>
	<td></td>
        <td>
           <colorZero>--</colorZero>- <a href="<?= $url_reg ?>"><?= $regionDataID ?> </a>
			(<?= $count ?>)
        </td>
		</tr>
		
		<?php
	//*************************** Отображение списка зарубежных стран ****************************************************
	
	
	while($regionTable = mysql_fetch_array($result_regionID)){
		if ($regionTable['id'] == 7) continue;
		
		if (!$regionTable['name']) continue;
list($regionDataID, $count, $url_reg, $url_flag) = getRegionData($regionTable['id'], $db_table_name, $db_table_regions);
 ?>
 <tr>

        <td>
            <a href="<?= $url_reg ?>"><img src="<?= $url_flag ?>" width=$width height=$height alt="country flag image"></a>
        </td>
        <td>
            <a href="<?= $url_reg ?>"><?= $regionDataID ?> </a>
			(<?= $count ?>)
        </td>

        
            
        

    </tr>
	<?php
	
	
	
	}
 
echo "</table>";

?>
?>