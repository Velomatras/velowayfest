<?php

class ResultsExperts2020 {
	
	// количество баллов необходимое для попадания в финальную стадию Фестиваля (задаётся каждый год !!!)
	// Продублировать значения тем что выставлено в сниппете votingExp !!!
	
const RATE_WIN_INF = 7.5;
const RATE_WIN_AUT = 7; 
const RATE_WIN_UNU = 7; 
const RATE_WIN_CHI = 7; 
const RATE_WIN_UNF = 6; 
const USER_SIM = 6; //число символов в нике юзера таблицы результатов


function showConstant($subcat) {
	$ball_sub = 0;
	if ($subcat == 1) $ball_sub = self::RATE_WIN_INF;
		if ($subcat == 2) $ball_sub = self::RATE_WIN_AUT;
		if ($subcat == 3) $ball_sub = self::RATE_WIN_UNU;
		if ($subcat == 4) $ball_sub = self::RATE_WIN_CHI;
		if ($subcat == 5) $ball_sub = self::RATE_WIN_UNF;
		return $ball_sub;
}

    function show() {

// эти параметры меняются год от года
        $YEAR_TAG = '2020';
        $db_table_name = 'way2020';
        $voting_db_name = 'way_voting_expert_2020';
		$voting_db_name2 = 'way_voting_expert_2020_2';
        $zayavka_Info_Url = 'archive/participant-2020.html';
        $zayavka = new Zayavka2020;

        $subcat = intval($_GET["subcat"]);
        if ($subcat < 1 || $subcat > 5) {
            return;
        }

        $rates = $this->getExpertsRates($zayavka, $voting_db_name);
		$rates2 = $this->getExpertsRates2($zayavka, $voting_db_name);
		$rates = array_merge($rates, $rates2);
		
		$rates3 = $this->getExpertsRates($zayavka, $voting_db_name2);
		$rates4 = $this->getExpertsRates2($zayavka, $voting_db_name2);
		$rates_2 = array_merge($rates3, $rates4);
		
        $this->sortRates($subcat, $rates);
		$this->sortRates2($subcat, $rates_2);
		
		$ball_sub = 0; //баллов для попадания в финал 
		$ball_sub = $this->showConstant($subcat);
		
		

// Заголовок страницы
        ?>
        <div style="padding: 10px; margin: 10px; width: 900px; background-color:#FFFFD7; font-size:16px; font-weight:bold">
            номинация: <?= $this->subcat_num_to_name($subcat) ?>
            <?= !empty($class) ? ", класс: $class" : '' ?>
        </div>
        <table width="100%"  border="0" cellspacing="2" cellpadding="0">

            <?php
            $zayavkaList = new zayavkaList($zayavka);
            $zayavkaView = new ZayavkaView();

            $valueName = $this->subcat_num_to_name($subcat);

            $zayavkaView->headerType1_refResults('Средняя оценка Финала/<br>Средняя оценка Отбора/<br>Кол-во оценок');
			$zayavkaView->hr5();
            $place = 1;
			$preRate = 0;
                $preSum = 0; 
			
			//Цикл вывода результатов финального этапа
            foreach ($rates_2 as $value) {
                $idz = $value['idz'];
                $resultRate = $value['sortField'] > 0 ? $value['sortField'] : 0;
                if (!$resultRate) {
                    continue;   // поход не получил оценок
                }
				//if ($idz == 86) {
                //    continue;   // Не показываем поход Янгировой!!! 
                //}
				
								
                $zayavka->load($idz);
                $zayavkaView->setData($zayavka, $zayavka_Info_Url);
// выводим очередную строку таблицы
                $resultRateCount = $value[$this->subcat_num_to_internalName($subcat) . 'Count'];
				
				$id_Z_otbor = 0;
				
				
				foreach ($rates as $rate) {
                
				if ($rate['idz'] == $idz){
				$resultRateOtbor = $rate['sortField'];
				$resultRateCount2 = $rate[$this->subcat_num_to_internalName($subcat) . 'Count'];
				//$resultRateCount = $resultRateCount + $resultRateCount2;
				}
				$id_Z_otbor++;
				 }
				 
				 
                ?> <tr> <?php
				if ($preRate != $resultRate) {
		$preSum = $place; 
		print_rate($place++); // занятое место
        
	}
		else {
		
		print_rate($preSum); // занятое место
		$place++;
	}
	$preRate = $resultRate;
                    //print_rate($place); // занятое походом место
                    $zayavkaView->column1();
                    $zayavkaView->column2();
                    $zayavkaView->column3();
                    print_rates(Array('<span style="color: red">'.sprintf("%.2f", $resultRate).'</span>', sprintf("%.2f", $resultRateOtbor), 
					$resultRateCount));
                    ?> </tr><tr><td></td><td></td><td>
                <?php 
				$ratesExp = Array();
				
				//Блок вывода финальных оценок судей
				list($ratesExp, $namesExp) =	$this->getExpertRatesTable($subcat, $voting_db_name2, $idz);
				?> 
				<table style="border-collapse:collapse">
				<tr>
				<?php
				echo "<br>";
				echo "<td><b>оценки экспертов в Финале:</b></td>";
				echo "</tr>";
				
				echo "<tr>";
				 echo "<td>";
				 echo "</td>";
				 for ($t = 0; $t < count($namesExp); $t++) {
					 ?>
					 <td align="center" style="border: 1px solid black;">
					  <?php
					 echo '<span style="color: black">';
					 echo substr($namesExp[$t],0,self::USER_SIM);
					 echo '</span>';
					 echo "</td>";
					
				 }
				 echo "</tr><tr>";
				 echo "<td>";
				 echo "</td>";
				
				 for ($t = 0; $t < count($ratesExp); $t++) {
					 ?>
					 <td align="center" style="border: 1px solid black;">
					  <?php
					 echo '<span style="color: red">';
					 echo $ratesExp[$t];
					 echo '</span>';
					 echo "</td>";
					
				 }
				 echo "</tr>";
				 ?>
				 </table>
				 
				 
				<?php
				$disp = sprintf("%.2f", $this->dispers($ratesExp));
				//echo "</td><td></td><td>(Дисперсия: $disp)</tr>";
				
				echo "<tr><td></td><td></td><td>";
				
				//Блок вывода отборочных оценок судей
				list($ratesExp, $namesExp) =	$this->getExpertRatesTable($subcat, $voting_db_name, $idz);
				?> 
				<table style="border-collapse:collapse">
				<tr>
				<?php
				
				echo "<td><b>оценки экспертов в Отборе:</b></td>";
				echo "</tr>";
				echo "<tr>";
				 echo "<td>";
				 echo "</td>";
				 for ($t = 0; $t < count($namesExp); $t++) {
					 ?>
					 <td align="center" style="border: 1px solid black;">
					  <?php
					 echo '<span style="color: black">';
					 echo substr($namesExp[$t],0,self::USER_SIM);
					 echo '</span>';
					 echo "</td>";
					
				 }
				 echo "</tr><tr>";
				 echo "<td>";
				 echo "</td>";
				
				 for ($t = 0; $t < count($ratesExp); $t++) {
					 ?>
					 <td align="center" style="border: 1px solid black;">
					  <?php
					 echo '<span style="color: black">';
					 echo $ratesExp[$t];
					 echo '</span>';
					 echo "</td>";
					
				 }
				 echo "</tr>";
				 
				 ?>
				 </table>
				 
				 
				<?php
				echo "</td></tr>";
				$zayavkaView->final_smile();
				$zayavkaView->hr5(); ?>
                <?php
// записываем в библиотеку походов судейские оценки и места занятые походом
                //AppendRateAndPlaceToLibrary_2018($place, $cat, $subcat, $idz);
                //$place++;
            }
			
			$zayavkaView->hr5();
			
			echo "<tr><td></td><td></td><td>";
			echo '<span style="color: blue">';
			echo "Результаты не попавших в ФИНАЛ отчётов:";
			echo '</span>';
			echo "</td></tr>";
			echo "<tr><td></td><td></td><td>";
			echo '<span style="color: blue">';
			echo "(необходимо баллов для попадания в Финал - <b>$ball_sub</b>)";
			echo '</span>';
			echo "</td></tr>";
			
			$zayavkaView->hr5();
			$zayavkaView->hr5();
			
			//*************************************** Цикл вывода результатов отборочного этапа **********************************
			
            foreach ($rates as $value) {
                $idz = $value['idz'];
                $resultRate = $value['sortField'] > 0 ? $value['sortField'] : 0;
                if (!$resultRate) {
                    continue;   // поход не получил оценок
                }
				if ($value['sortField'] >= $ball_sub){
					
                    continue;   // поход в финале
                }
				//if ($idz == 86) {
                 //   continue;   // Не показываем поход Янгировой!!! 
                //}
				
                $zayavka->load($idz);
                $zayavkaView->setData($zayavka, $zayavka_Info_Url);
// выводим очередную строку таблицы
                $resultRateCount = $value[$this->subcat_num_to_internalName($subcat) . 'Count'];
				
				
                ?> <tr> <?php
				if ($preRate != $resultRate) {
		$preSum = $place; 
		print_rate($place++); // занятое место
        
	}
		else {
		
		print_rate($preSum); // занятое место
		$place++;
	}
	$preRate = $resultRate;
                    //print_rate($place); // занятое походом место
                    $zayavkaView->column1();
                    $zayavkaView->column2();
                    $zayavkaView->column3();
                    print_rates(Array('<span style="color: red">'.'-'.'</span>', sprintf("%.2f", $resultRate), 
					$resultRateCount));
                    ?> </tr><tr><td></td><td></td><td>
                <?php

				//Блок вывода отборочных оценок экспертов
				list($ratesExp, $namesExp) =	$this->getExpertRatesTable($subcat, $voting_db_name, $idz);
				?> 
				<table style="border-collapse:collapse">
				<tr>
				<?php
				
				echo "<td><b>оценки экспертов в Отборе:</b></td>";
				echo "</tr>";
				echo "<tr>";
				 echo "<td>";
				 echo "</td>";
				 for ($t = 0; $t < count($namesExp); $t++) {
					 ?>
					 <td align="center" style="border: 1px solid black;">
					  <?php
					 echo '<span style="color: black">';
					 echo substr($namesExp[$t],0,self::USER_SIM);
					 echo '</span>';
					 echo "</td>";
					
				 }
				 echo "</tr>";
				echo "<tr>";
				echo "<td>";
				 echo "</td>";
				 for ($t = 0; $t < count($ratesExp); $t++) {
					 ?>
					 <td align="center" style="border: 1px solid black;">
					  <?php
					 echo '<span style="color: black">';
					 echo $ratesExp[$t];
					 echo '</span>';
					 echo "</td>";
					
				 }
				 
				 
				 ?>
				 </tr>
				 </table>
				 
				<?php
				echo "</td></tr>";
				$zayavkaView->hr5(); ?>
                <?php
// записываем в библиотеку походов судейские оценки и места занятые походом
                //AppendRateAndPlaceToLibrary_2018($place, $cat, $subcat, $idz);
                //$place++;
            }
            echo "</table>";
        }

        private function subcat_num_to_name($subcat) {
            if ($subcat == 1)
                $valueName = 'Самый познавательный маршрут';
            if ($subcat == 2)
                $valueName = 'Самый автономный маршрут';
            if ($subcat == 3)
                $valueName = 'Самый необычный поход';
            if ($subcat == 4)
                $valueName = 'Лучший велопоход с детьми';
            if ($subcat == 5)
                $valueName = 'Самый приключенческий велопоход';
            if ($subcat == 6)
                $valueName = 'Сумма оценок';
            return $valueName;
        }

        private function subcat_num_to_internalName($subcat) {
            if ($subcat == 1)
                return 'inf';
            elseif ($subcat == 2)
                return 'auto';
            elseif ($subcat == 3)
                return 'unus';
            elseif ($subcat == 4)
                return 'child';
            elseif ($subcat == 5)
                return 'unfor';
            else
                return null;
        }

// подсчет суммы и количества учтенных оценок
        private function count_rate_sum($cur_rate, $rate_sum, $rate_count) {
            if ($cur_rate !== '-') {// пропускаем воздержавшихся
                $rate_sum += $cur_rate;
                $rate_count++;
            }
            return array($rate_sum, $rate_count);
        }

        private function calc_avg_rate($rate_sum, $rate_count) {
            if ($rate_count <= 0) {
                $rate_count = 1;
            }
            return $rate_sum / $rate_count;
        }

        private function getExpertsRates($zayavka, $voting_db_name) {

            $zayavkaList = new zayavkaList($zayavka);
			
						
            $zayavkaList->load(Array('status' => ZayavkaStatus::APPROVED));
			//$pohodsViewers = $zayavkaList->load(Array('status' => ZayavkaStatus::APPROVED_FOR_VIEWERS_VOTING));
			
			//$pohods = array_merge($pohodsApproved, $pohodsViewers);

            $rates = Array();

            $db = new MyCRUD_Modx($voting_db_name);

            foreach ($zayavkaList->list as $array) {
                $inf = $auto = $unus = $child = $unfor = 0;
                $inf_count = $auto_count = $unus_count = $child_count = $unfor_count = 0;
                $zayavkaVotes = $db->getRecords(Array('idz' => $array['id']));
                foreach ($zayavkaVotes as $vote) {
                    list($inf, $inf_count) = $this->count_rate_sum($vote['informative'], $inf, $inf_count);
                    list($auto, $auto_count) = $this->count_rate_sum($vote['autonome'], $auto, $auto_count);
                    list($unus, $unus_count) = $this->count_rate_sum($vote['unusual'], $unus, $unus_count);
                    list($child, $child_count) = $this->count_rate_sum($vote['children'], $child, $child_count);
                    list($unfor, $unfor_count) = $this->count_rate_sum($vote['unfortun'], $unfor, $unfor_count);
                }
                $inf = $this->calc_avg_rate($inf, $inf_count);
                $auto = $this->calc_avg_rate($auto, $auto_count);
                $unus = $this->calc_avg_rate($unus, $unus_count);
                $child = $this->calc_avg_rate($child, $child_count);
                $unfor = $this->calc_avg_rate($unfor, $unfor_count);
// формируем массив с оценками
                $rates[] = array(
                    'idz' => $array['id'],
                    'inf' => $inf,
                    'auto' => $auto,
                    'unus' => $unus,
                    'child' => $child,
                    'unfor' => $unfor,
                    'infCount' => $inf_count,
                    'autoCount' => $auto_count,
                    'unusCount' => $unus_count,
                    'childCount' => $child_count,
                    'unforCount' => $unfor_count
                );
//        echo '<b>' . $array['id'] . '</b>' . ' ' . $inf. ' ' .$inf_count. $inf/($inf_count>0?$inf_count:1)."<br>";
            }
            return $rates;
        }

		private function getExpertsRates2($zayavka, $voting_db_name) {

            $zayavkaList = new zayavkaList($zayavka);
			
						
            $zayavkaList->load(Array('status' => ZayavkaStatus::APPROVED_FOR_VIEWERS_VOTING));
			//$pohodsViewers = $zayavkaList->load(Array('status' => ZayavkaStatus::APPROVED_FOR_VIEWERS_VOTING));
			
			//$pohods = array_merge($pohodsApproved, $pohodsViewers);

            $rates = Array();

            $db = new MyCRUD_Modx($voting_db_name);

            foreach ($zayavkaList->list as $array) {
                $inf = $auto = $unus = $child = $unfor = 0;
                $inf_count = $auto_count = $unus_count = $child_count = $unfor_count = 0;
                $zayavkaVotes = $db->getRecords(Array('idz' => $array['id']));
                foreach ($zayavkaVotes as $vote) {
                    list($inf, $inf_count) = $this->count_rate_sum($vote['informative'], $inf, $inf_count);
                    list($auto, $auto_count) = $this->count_rate_sum($vote['autonome'], $auto, $auto_count);
                    list($unus, $unus_count) = $this->count_rate_sum($vote['unusual'], $unus, $unus_count);
                    list($child, $child_count) = $this->count_rate_sum($vote['children'], $child, $child_count);
                    list($unfor, $unfor_count) = $this->count_rate_sum($vote['unfortun'], $unfor, $unfor_count);
                }
                $inf = $this->calc_avg_rate($inf, $inf_count);
                $auto = $this->calc_avg_rate($auto, $auto_count);
                $unus = $this->calc_avg_rate($unus, $unus_count);
                $child = $this->calc_avg_rate($child, $child_count);
                $unfor = $this->calc_avg_rate($unfor, $unfor_count);
// формируем массив с оценками
                $rates[] = array(
                    'idz' => $array['id'],
                    'inf' => $inf,
                    'auto' => $auto,
                    'unus' => $unus,
                    'child' => $child,
                    'unfor' => $unfor,
                    'infCount' => $inf_count,
                    'autoCount' => $auto_count,
                    'unusCount' => $unus_count,
                    'childCount' => $child_count,
                    'unforCount' => $unfor_count
                );
//        echo '<b>' . $array['id'] . '</b>' . ' ' . $inf. ' ' .$inf_count. $inf/($inf_count>0?$inf_count:1)."<br>";
            }
            return $rates;
        }


        function sortRates($subcat, &$rates) {
            if (!$subcat) {
                return;
            }
            foreach ($rates as &$rate) {
				$rate["sortField"] = null;
				$rate["summ"] = null;
                if ($subcat == 1) {
                    $rate["sortField"] = $rate["inf"];
					$rate["summ"] = $rate["infCount"];
                } elseif ($subcat == 2) {
                    $rate["sortField"] = $rate["auto"];
					$rate["summ"] = $rate["autoCount"];
                } elseif ($subcat == 3) {
                    $rate["sortField"] = $rate["unus"];
					$rate["summ"] = $rate["unusCount"];
                } elseif ($subcat == 4) {
                    $rate["sortField"] = $rate["child"];
					$rate["summ"] = $rate["childCount"];
                } elseif ($subcat == 5) {
                    $rate["sortField"] = $rate["unfor"];
					$rate["summ"] = $rate["unforCount"];
                }
                $rate["sortField"] = $rate[$this->subcat_num_to_internalName($subcat)];
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
		function sortRates2($subcat, &$rates_2) {
            if (!$subcat) {
                return;
            }
            foreach ($rates_2 as &$rate) {
				$rate["sortField"] = null;
				$rate["summ"] = null;
                if ($subcat == 1) {
                    $rate["sortField"] = $rate["inf"];
					$rate["summ"] = $rate["infCount"];
                } elseif ($subcat == 2) {
                    $rate["sortField"] = $rate["auto"];
					$rate["summ"] = $rate["autoCount"];
                } elseif ($subcat == 3) {
                    $rate["sortField"] = $rate["unus"];
					$rate["summ"] = $rate["unusCount"];
                } elseif ($subcat == 4) {
                    $rate["sortField"] = $rate["child"];
					$rate["summ"] = $rate["childCount"];
                } elseif ($subcat == 5) {
                    $rate["sortField"] = $rate["unfor"];
					$rate["summ"] = $rate["unforCount"];
                }
                $rate["sortField"] = $rate[$this->subcat_num_to_internalName($subcat)];
            }

            function sort_func2($a, $b) {
                if ($a['sortField'] == $b['sortField']) {
					if ($a['summ'] == $b['summ']) return 0;
					else return ($a['summ'] < $b['summ']) ? 1 : -1;
                    
                }
                return ($a["sortField"] < $b["sortField"]) ? 1 : -1;
            }

            usort($rates_2, sort_func2);
        }
		
		function dispers ($array){
			
			$mean = array_sum($array) / count($array);
		
$var = 0.0;
foreach ($array as $i){
    $var += pow($i - $mean, 2);
}
$size = count($array) - 1;
return (float) sqrt($var)/sqrt($size);
		}
		
		//функция создания таблицы с экспертными оценками 
		function getExpertRatesTable($subcat, $voting_db_name, $idz) {
			$result5 = mysql_query("SELECT informative, autonome, unusual, children, unfortun, userid FROM $voting_db_name WHERE idz = $idz");
			$ratesExp = Array();
			$namesExp = Array();
			$s = 0;
			$s2 = 0;
                for ($t = 0; $t < mysql_num_rows($result5); $t++) {
                    $array5 = mysql_fetch_array($result5);
// считаем суммы и количество учтенных оценок, и их макс и мин.значения
if ($subcat == 1) $ratesExp[$s++] = $array5[0];
if ($subcat == 2) $ratesExp[$s++] = $array5[1];
if ($subcat == 3) $ratesExp[$s++] = $array5[2];
if ($subcat == 4) $ratesExp[$s++] = $array5[3];
if ($subcat == 5) $ratesExp[$s++] = $array5[4];
 $namesExp[$s2++] = ModXWork::getUserName($array5[5]);                   
               }
				return array ($ratesExp, $namesExp);
			
		}
		
		

    }
