<?php

class ResultsReferee2019 {

    private $ref_voting_db_name = 'way_voting_referee_2019';
	private $ref_voting_db_name2 = 'way_voting_referee_2019_2';
    private $db_table_name = 'way2019';
	
//Короткие велопоходы
const RATE_WIN_DIFF_1 = 7;
const RATE_WIN_ORG_1 = 7;
const RATE_WIN_OTCH_1 = 7.5;

//Велопоходы
const RATE_WIN_DIFF_2 = 8;
const RATE_WIN_ORG_2 = 7.25;
const RATE_WIN_OTCH_2 = 6.4;

//Длительные велопоходы
const RATE_WIN_DIFF_3 = 7.2;
const RATE_WIN_ORG_3 = 6.5;
const RATE_WIN_OTCH_3 = 7;

//Велопутешествия
const RATE_WIN_DIFF_4 = 7.6;
const RATE_WIN_ORG_4 = 6.8;
const RATE_WIN_OTCH_4 = 3;
	
	//Функция для определения проходных баллов для финала для каждой номинации и класса
function showConstant($cat) {
	$ball = Array(); //Массив оценок
	
	
	

        switch ($cat) {
			case 1:
			$ball[$cat]['diff'] = self::RATE_WIN_DIFF_1;
			$ball[$cat]['org'] = self::RATE_WIN_ORG_1;
			$ball[$cat]['otch'] = self::RATE_WIN_OTCH_1;
			 
			break;
			
			case 2:
			$ball[$cat]['diff'] = self::RATE_WIN_DIFF_2;
			$ball[$cat]['org'] = self::RATE_WIN_ORG_2;
			$ball[$cat]['otch'] = self::RATE_WIN_OTCH_2;
			break;
			
			case 3:
			$ball[$cat]['diff'] = self::RATE_WIN_DIFF_3;
			$ball[$cat]['org'] = self::RATE_WIN_ORG_3;
			$ball[$cat]['otch'] = self::RATE_WIN_OTCH_3;
			break;
			
			case 4:
			$ball[$cat]['diff'] = self::RATE_WIN_DIFF_4;
			$ball[$cat]['org'] = self::RATE_WIN_ORG_4;
			$ball[$cat]['otch'] = self::RATE_WIN_OTCH_4;
			break;
			
			default: 
			$ball[$cat]['diff'] = 0;
			$ball[$cat]['org'] = 0;
			$ball[$cat]['otch'] = 0;
			break;
				}
				return $ball;
    }
	
	
	
		
	
    function show() {

        $zayavka_Info_Url = 'archive/participant-2019.html';
        $YEAR_TAG = '2019';
        $zayavka = new Zayavka2019;

        $cat = intval($_GET["cat"]);
        $subcat = intval($_GET["subcat"]);
        if ($cat < 0 || $cat > 4) {
            return;
        }
        if ($subcat == 4) {
            $cat = null;
        }
        $class = $this->cat_num_to_class($cat);
        list($nomination_name, $nominationId) = $this->subcat_num_to_name($subcat);
        if (subcat == 4) {
            $class = '';
        }   // лучший поход

        $rates = $this->getRefereeRates($class, $this->db_table_name, $this->ref_voting_db_name);
		$rates2 = $this->getRefereeRates($class, $this->db_table_name, $this->ref_voting_db_name2);
        $this->sortRates($subcat, $rates);
		$this->sortRates2($subcat, $rates2);
		
		$ball = Array(); //массив констант проходных баллов для данного класса
		
	$ball = $this->showConstant($cat); //заполнение массива константами проходных баллов по классам и номинациям
				if ($subcat == 1) $ball_sub = $ball[$cat]['diff'];
				if ($subcat == 2) $ball_sub = $ball[$cat]['org'];
				if ($subcat == 3) $ball_sub = $ball[$cat]['otch'];
				


// Заголовок страницы
        ?>
        <div style="padding: 10px; margin: 10px; width: 900px; background-color:#FFFFD7; font-size:16px; font-weight:bold">
            <i>номинация:</i> <?= $nomination_name ?></div>
			<div style="padding: 7px; margin: 7px; width: 900px; background-color:#fdeee8; font-size:10px; font-weight:bold">
            <?= !empty($class) ? "<i>класс:</i> $class" : '' ?>
        </div>
		        <table width="100%"  border="0" cellspacing="2" cellpadding="0">

            <?php
            $zayavkaList = new zayavkaList($zayavka);
            $zayavkaView = new ZayavkaView();

            $zayavkaView->headerType1_refResults('Средняя оценка в Финале/<br>Средняя оценка в Отборе/<br>Кол-во оценок');

            $place = 1;
			$zayavkaView->hr5();
			
			//Цикл вывода результатов судейского голосования финального этапа
            foreach ($rates2 as $rate2) {
                $id_z = $rate2['id_z'];
                $filter = Array('id' => $id_z);
                if ($nominationId) {
                    $filter['nominations'] = $nominationId;
                }
                $zayavkaList->load($filter);

                if (empty($zayavkaList->list)) {
                    continue;   // поход не заявлен в эту номинацию
                }

                if ($id_z == 86) {
                    continue;   // Не показываем поход Янгировой!!! 
                }
				if ($rate2['sortField'] <= 0) {
                    continue;   // поход не получил оценок
                }
				
				$resultRate = $rate2['sortField'];
				$idz = 0;
				$resultRateCount = $rate2[$this->subcat_num_to_internalName($subcat) . 'Count'];
				
				 foreach ($rates as $rate) {
                
				if ($rate['id_z'] == $id_z) {
					$resultRateOtbor = $rate['sortField'];
				$resultRateCount2 = $rate[$this->subcat_num_to_internalName($subcat) . 'Count'];
				$resultRateCount = $resultRateCount + $resultRateCount2;
				}
				$idz++;
				 }
				
				//echo "<br>";
				//echo "проходной балл $ball_sub";
				//echo "<br>";
				//echo "оценка $resultRate";
				//echo "<br>";
				
                
                
                $zayavka->data = $zayavkaList->list[0];
                $zayavkaView->setData($zayavka, $zayavka_Info_Url);
// выводим очередную строку таблицы
                ?> <tr> <?php
                    print_rate($place); // занятое походом место
                    $zayavkaView->column1();
                    $zayavkaView->column2();
                    $zayavkaView->column3();?>
					
					<?php
                    print_rates(Array($resultRate ? '<span style="color: red">'.sprintf("%.2f", $resultRate).'</span>' : '-',
$resultRateOtbor ? sprintf("%.2f", $resultRateOtbor) : '-', $resultRateCount));
                    ?> </font></tr><tr><td></td><td></td><td>
                <?php
				$ratesRef = Array();
				
				//Блок вывода финальных оценок судей
				$ratesRef =	$this->getRefereeRatesTable($subcat, $this->ref_voting_db_name2, $id_z);
				?> 
				<table style="border-collapse:collapse">
				<tr><td>
				<?php
				echo "<br>";
				echo "<td><b>оценки судей в Финале:</b></td><td>";
				 for ($t = 0; $t < count($ratesRef); $t++) {
					 ?>
					 <td style="border: 1px solid black;">
					  <?php
					 echo '<span style="color: red">';
					 echo $ratesRef[$t];
					 echo '</span>';
					 echo "</td>";
					
				 }
				 echo "</tr>";
				 ?>
				 </table>
				 
				<?php
				echo "</td></tr>";
				echo "<tr><td></td><td></td><td>";
				
				//Блок вывода отборочных оценок судей
				$ratesRef =	$this->getRefereeRatesTable($subcat, $this->ref_voting_db_name, $id_z);
				?> 
				<table style="border-collapse:collapse">
				<tr>
				<?php
				
				echo "<td><b>оценки судей в Отборе:</b></td><td>";
				 for ($t = 0; $t < count($ratesRef); $t++) {
					 ?>
					 <td style="border: 1px solid black;">
					  <?php
					 echo '<span style="color: black">';
					 echo $ratesRef[$t];
					 echo '</span>';
					 echo "</td>";
					
				 }
				 echo "</tr>";
				 ?>
				 </table>
				 
				<?php
				echo "</td></tr>";
				$zayavkaView->final_smile();
                $zayavkaView->hr5();
// записываем в библиотеку походов судейские оценки и места занятые походом
                //AppendRateAndPlaceToLibrary_2018($place, $cat, $subcat, $id_z);
                $place++;
            }
			
			
			$zayavkaView->hr5();
			echo "<tr><td></td><td></td><td>";
			echo '<span style="color: blue">';
			echo "Результаты не попавших в Финал отчётов:";
			echo '</span>';
			echo "</td></tr>";
			echo "<tr><td></td><td></td><td>";
			echo '<span style="color: blue">';
			echo "(необходимо баллов для попадания в Финал - <b>$ball_sub</b>)";
			echo '</span>';
			echo "</td></tr>";
			$zayavkaView->hr5();
			$zayavkaView->hr5();
			
			//Цикл вывода результатов судейского голосования отборочного этапа
            foreach ($rates as $rate) {
                $id_z = $rate['id_z'];
                $filter = Array('id' => $id_z);
                if ($nominationId) {
                    $filter['nominations'] = $nominationId;
                }
                $zayavkaList->load($filter);

                if (empty($zayavkaList->list)) {
                    continue;   // поход не заявлен в эту номинацию
                }

                if ($rate['sortField'] <= 0) {
                    continue;   // поход не получил оценок
                }
				
				if ($id_z == 86) {
                    continue;   // Не показываем поход Янгировой!!! 
                }
				
				$resultRate = $rate['sortField'];
				//echo "<br>";
				//echo "проходной балл $ball_sub";
				//echo "<br>";
				//echo "оценка $resultRate";
				//echo "<br>";
				if ($rate['sortField'] >= $ball_sub){
					
                    continue;   // поход в финале
                }
                
                $resultRateCount = $rate[$this->subcat_num_to_internalName($subcat) . 'Count'];
                $zayavka->data = $zayavkaList->list[0];
                $zayavkaView->setData($zayavka, $zayavka_Info_Url);
// выводим очередную строку таблицы
                ?> <tr> <?php
                    print_rate($place); // занятое походом место
                    $zayavkaView->column1();
                    $zayavkaView->column2();
                    $zayavkaView->column3();?>
					
					<?php
                    print_rates(Array('<span style="color: red">'.'-'.'</span>', $resultRate ? sprintf("%.2f", $resultRate) : '-', $resultRateCount));
                    ?> </font></tr><tr><td></td><td></td><td>
                <?php
				
				//Блок вывода оценок судей
				$ratesRef =	$this->getRefereeRatesTable($subcat, $this->ref_voting_db_name, $id_z);
				?> 
				<table style="border-collapse:collapse">
				<tr><td>
				<?php
				echo "<br>";
				echo "<td><b>оценки судей в Отборе:</b></td><td>";
				 for ($t = 0; $t < count($ratesRef); $t++) {
					 ?>
					 <td style="border: 1px solid black;">
					  <?php
					 echo '<span style="color: black">';
					 echo $ratesRef[$t];
					 echo '</span>';
					 echo "</td>";
					
				 }
				 echo "</tr>";
				 ?>
				 </table>
				 
				<?php
				echo "</td></tr>";
                $zayavkaView->hr5();
// записываем в библиотеку походов судейские оценки и места занятые походом
                //AppendRateAndPlaceToLibrary_2018($place, $cat, $subcat, $id_z);
                $place++;
            }
            echo "</table>";
            return;
        }

         function count_rate_sum($cur_rate, $rate_sum, $rate_count, $rate_min, $rate_max) {
// подсчет суммы и количества учтенных оценок, и их макс и мин.значения
            if ($cur_rate !== '-') {// пропускаем воздержавшихся
                $rate_sum += $cur_rate;
                $rate_count++;
                $rate_min = ($rate_min > $cur_rate) ? $cur_rate : $rate_min;
                $rate_max = ($rate_max < $cur_rate) ? $cur_rate : $rate_max;
            }
            return array($rate_sum, $rate_count, $rate_min, $rate_max);
        }

         function calc_result_avg_rate($rate_sum, $rate_count, $rate_min, $rate_max) {
            //$rate_sum = $rate_sum - $rate_min;   // вычитаем минимакс
            //$rate_count = $rate_count - 1;
            //$rate_sum = $rate_sum - $rate_max;
            //$rate_count = $rate_count - 1;

            if ($rate_count <= 0) {
                $rate_count = 1;
            }
            return $rate_sum / $rate_count;
        }

         function cat_num_to_class($cat) {
            switch ($cat) {
                case 0: $class = '';
                    break;
                case 1: $class = "Короткие велопоходы";
                    break;
                case 2: $class = "Велопоходы";
                    break;
                case 3: $class = "Длительные велопоходы";
                    break;
                case 4: $class = "Велопутешествия";
                    break;
                case 5: $class = "";    //"Лучший поход";
                    break;
                default: $class = "Короткие велопоходы";
            }
            return $class;
        }

         function subcat_num_to_name($subcat) {
            switch ($subcat) {
                case 1: $nomination = "Самый сложный велопоход";
                    $id = "hard";
                    break;
                case 2: $nomination = "Самый оригинальный маршрут";
                    $id = "original";
                    break;
                case 3: $nomination = "Лучший отчёт";
                    $id = "report";
                    break;
                case 4: $nomination = "Лучший поход Года";
                    $id = "";
                    break;
                default: $nomination = "";
                    $id = "";
                    break;
            }
            return Array($nomination, $id);
        }

         function subcat_num_to_internalName($subcat) {
            if ($subcat == 1)
                return 'diff';
            elseif ($subcat == 2)
                return 'org';
            elseif ($subcat == 3)
                return 'otch';
            elseif ($subcat == 4)
                return 'rates_sum';
            else
                return null;
        }

         function getRefereeRates($class, $db_table_name, $ref_voting_db_name) {
            $q = "SELECT status, class, id FROM $db_table_name WHERE status = '1'";
            if ($class !== '') {
                $q .= " AND class = '$class'";
            }
            $result = mysql_query($q);

            $rates = Array();

            for ($i = 0; $i < mysql_num_rows($result); $i++) {
                $array = mysql_fetch_array($result);
                $diff = $org = $otch = 0;
                $diff_min = $org_min = $otch_min = PHP_INT_MAX;
                $diff_max = $org_max = $otch_max = 0;
                $diff_count = $org_count = $otch_count = 0;
                $result4 = mysql_query("SELECT difficult, org, otch FROM $ref_voting_db_name WHERE id_z = $array[id]");
                for ($t = 0; $t < mysql_num_rows($result4); $t++) {
                    $array4 = mysql_fetch_array($result4);
// считаем суммы и количество учтенных оценок, и их макс и мин.значения
                    list($diff, $diff_count, $diff_min, $diff_max) = $this->count_rate_sum($array4[0], $diff, $diff_count, $diff_min, $diff_max);
                    list($org, $org_count, $org_min, $org_max) = $this->count_rate_sum($array4[1], $org, $org_count, $org_min, $org_max);
                    list($otch, $otch_count, $otch_min, $otch_max) = $this->count_rate_sum($array4[2], $otch, $otch_count, $otch_min, $otch_max);
                }
                $diff = $this->calc_result_avg_rate($diff, $diff_count, $diff_min, $diff_max);
                $org = $this->calc_result_avg_rate($org, $org_count, $org_min, $org_max);
                $otch = $this->calc_result_avg_rate($otch, $otch_count, $otch_min, $otch_max);
// формируем массив с оценками
                $rates_sum = $diff > 0 && $org > 0 && $otch > 0 ? $diff + $org + $otch : 0;
                $rates[] = array(
                    'id_z' => $array[id],
                    'diff' => $diff,
                    'org' => $org,
                    'otch' => $otch,
                    'rates_sum' => $rates_sum,
                    'otchCount' => $otch_count,
                    'diffCount' => $diff_count,
                    'orgCount' => $org_count,
                    'rates_sumCount' => min(Array($otch_count, $diff_count, $org_count))
                );
            }
            return $rates;
        }
		
		function getRefereeRatesTable($subcat, $ref_voting_db_name, $idz) {
			$result5 = mysql_query("SELECT difficult, org, otch FROM $ref_voting_db_name WHERE id_z = $idz");
			$ratesRef = Array();
			$s = 0;
                for ($t = 0; $t < mysql_num_rows($result5); $t++) {
                    $array5 = mysql_fetch_array($result5);
// считаем суммы и количество учтенных оценок, и их макс и мин.значения
if ($subcat == 1) $ratesRef[$s++] = $array5[0];
if ($subcat == 2) $ratesRef[$s++] = $array5[1];
if ($subcat == 3) $ratesRef[$s++] = $array5[2];
                    
               }
				return $ratesRef;
			
		}


        private function getPZSRatesScaledTo1() {
            $q = "SELECT pzs FROM $this->db_table_name WHERE status = '1'";
            $result = mysql_query($q);

            $maxPZS = 0;
            $rates = Array();
            for ($i = 0; $i < mysql_num_rows($result); $i++) {
                $item = mysql_fetch_array($result);
                $item['id'] = $item['pzs'];
                if ($item["pzs"] > $maxPZS) {
                    $maxPZS = $item["pzs"];
                }
            }

            if ($maxPZS == 0) {
                return $rates;
            }

            foreach ($rates as $i => $rate) {
                $rate[$i] = (double)$rate[$i] / $maxPZS / 100.0;
            }

            return $rates;
        }

         function sortRates($subcat, &$rates) {
            if (!$subcat) {
                return;
            }

            $pzsRatesScaledTo1 = $this->getPZSRatesScaledTo1();

            foreach ($rates as &$rate) {
                $rate["sortField"] = null;
				$rate["summ"] = null;
                if ($subcat == 1) {
                    $rate["sortField"] = $rate["diff"];
					$rate["summ"] = $rate["diffCount"];
                } elseif ($subcat == 2) {
                    $rate["sortField"] = $rate["org"];
					$rate["summ"] = $rate["orgCount"];
                } elseif ($subcat == 3) {
                    $rate["sortField"] = $rate["otch"];
					$rate["summ"] = $rate["otchCount"];
                } elseif ($subcat == 4) {
                    $rate["sortField"] = $rate["rates_sum"];
                }

                $rate["sortField"] = $rate["sortField"] + $pzsRatesScaledTo1[$rate['id_z']];    // take in account pzs if other rates are equal
            }

            function sort_func($a, $b) {
                if ($a['sortField'] == $b['sortField']) {
					if ($a['summ'] == $b['summ']) return 0;
					else return ($a['summ'] < $b['summ']) ? 1 : -1;
                    
                }
                return ($a["sortField"] < $b["sortField"]) ? 1 : -1;
            }

            usort($rates, sort_func);
        }
		
		function sortRates2($subcat, &$rates2) {
            if (!$subcat) {
                return;
            }

            

            foreach ($rates2 as &$rate) {
                $rate["sortField"] = null;
				$rate["summ"] = null;
                if ($subcat == 1) {
                    $rate["sortField"] = $rate["diff"];
					$rate["summ"] = $rate["diffCount"];
                } elseif ($subcat == 2) {
                    $rate["sortField"] = $rate["org"];
					$rate["summ"] = $rate["orgCount"];
                } elseif ($subcat == 3) {
                    $rate["sortField"] = $rate["otch"];
					$rate["summ"] = $rate["otchCount"];
                } elseif ($subcat == 4) {
                    $rate["sortField"] = $rate["rates_sum"];
                }

               // $rate["sortField"] = $rate["sortField"] + $pzsRatesScaledTo1[$rate['id_z']];    // take in account pzs if other rates are equal
            }

            function sort_func2($a, $b) {
                if ($a['sortField'] == $b['sortField']) {
					if ($a['summ'] == $b['summ']) return 0;
					else return ($a['summ'] < $b['summ']) ? 1 : -1;
                    
                }
                return ($a["sortField"] < $b["sortField"]) ? 1 : -1;
            }

            usort($rates2, sort_func2);
        }
		
function getRefereeVotes($userID, $idz, $class, $db_voting_table_name){
    $result3 = mysql_query("SELECT * FROM $db_voting_table_name WHERE id_ref = $userID AND id_z = $idz AND cat = '$class'");
    if ($result3 == false) {
        return Array(0,0,0);
    }
    $array3 = mysql_fetch_array($result3);
    return Array($array3['difficult'], $array3['org'], $array3['otch']);
}

    }
