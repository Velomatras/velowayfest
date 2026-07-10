<?php

class ResultsDebut2023 {
	
	

    function show() {
		
		// эти параметры меняются год от года
        $YEAR_TAG = '2023';
        $db_table_name = 'way2023';
		$nomination_name = 'debut';
		$WIN = 7;
        
        $zayavka_Info_Url = 'archive/participant-2023.html';
        $zayavka = new Zayavka2023;
		
		// получаем данные походов по выбранной номинации
//$nomFilter = isset($_REQUEST['nomFilter']) && $nomFilter != '0' ? $_REQUEST['nomFilter'] : NULL;
$nomFilter = 'bestPohod';


        $rates = $this->getBestRates($db_table_name, $zayavka);
		//$zayavkaList = new zayavkaList($zayavka);       
//$zayavkaList->load(Array('nominations' => $nomination_name));
		
		$this->sortRates($rates);
		
		

// Заголовок страницы
        ?>
        <div style="padding: 10px; margin: 10px; width: 900px; background-color:#FFFFD7; font-size:16px; font-weight:bold">
            номинация: <?= 'Лучший дебют' ?>
           
        </div>
		<br><div class="cell_yellow2">
		<i>*В этой номинации принимают участие только те отчёты, котрые участвовали не менее чем в трёх номинациях и авторы 
		которых не участвовали ранее на Фестивале "Велопуть"<br><br>
		**Результат номинации "Лучший дебют" средний балл по 3 номинациям в которых отчёт показал наилучший результат </i>
		</div>
        <table width="100%"  border="0" cellspacing="2" cellpadding="0">

            <?php
            
            $zayavkaView = new ZayavkaView();

            
            $zayavkaView->headerType1_refResults('Средняя оценка/<br>Кол-во номинаций');
			$zayavkaView->hr5();
            $place = 1;
			
			$maxDiff = 0;
			
			//Определение максимального результата
			foreach ($rates as $value) {
				$idz = $value['idz'];
                $resultRate = $value['sortField'] > 0 ? $value['sortField'] : 0;
                if (!$resultRate) {
                    continue;   // поход не получил оценок
                }
				//$zayavkaList = new zayavkaList($zayavka);


    
								
				
                $zayavka->load($idz);
                $zayavkaView->setData($zayavka, $zayavka_Info_Url);
				
				if ($maxDiff < $value['diff']) $maxDiff = $value['diff'];
				if ($maxOrg < $value['org']) $maxOrg = $value['org'];
				if ($maxOtch < $value['otch']) $maxOtch = $value['otch'];
				if ($maxInf < $value['inf']) $maxInf = $value['inf'];
				if ($maxAut < $value['aut']) $maxAut = $value['aut'];
				if ($maxChi < $value['chi']) $maxChi = $value['chi'];
				if ($maxUnu < $value['unu']) $maxUnu = $value['unu'];
				if ($maxUnf < $value['unf']) $maxUnf = $value['unf'];
				if ($maxFoto < $value['foto']) $maxFoto = $value['foto'];
				if ($maxVideo < $value['video']) $maxVideo = $value['video'];
				if ($maxMovie < $value['movie']) $maxMovie = $value['movie'];
				if ($maxExc < $value['exciting']) $maxExc = $value['exciting'];
				
			}
			
			$result_pre = 0;
			$nul = 0;
			//Цикл вывода результатов
            foreach ($rates as $value) {
				$flag = 0;
                $idz = $value['idz'];
                $resultRate = $value['sortField'] > 0 ? $value['sortField'] : 0;
                if (!$resultRate) {
                    continue;   // поход не получил оценок
                }
				$zayavkaList = new zayavkaList($zayavka);


    
								
				$zayavkaList->load(Array('nominations' => $nomination_name));
                $zayavka->load($idz);
                $zayavkaView->setData($zayavka, $zayavka_Info_Url);
// выводим очередную строку таблицы
                $resultRateCount = $value['count'];
				
				$resultDiff = $value['diff'];
				$resultOrg = $value['org'];
				$resultOtch = $value['otch'];
				$resultInf = $value['inf'];
				$resultAut = $value['aut'];
				$resultChi = $value['chi'];
				$resultUnu = $value['unu'];
				$resultUnf = $value['unf'];
				$resultFoto = $value['foto'];
				$resultVideo = $value['video'];
				$resultMovie = $value['movie'];
				$resultExc = $value['exciting'];
							
if (!( ($resultRateCount >= 3) && $zayavka->isInNomination('debut'))) 
	continue;   //поход не выполнил условие участия в Дебюте

//if ($idz == 86) continue; //Не учитываем поход Янгировой!!!
//if ($idz != 2 && $idz != 3 && $idz != 11 && $idz != 12 && $idz != 13 && $idz != 16 && $idz != 18 &&
//$idz != 27 && $idz != 30 && $idz != 40 && $idz != 43 && $idz != 44 &&
//$idz != 48 && $idz != 51) continue; //Не учитываем походы не являющиеся дебютными!!!
				
                ?> <tr> <?php
				if ($result_pre != $resultRate){
					$place = $place + $nul;
                    print_rate($place++); // занятое походом место
				    $nul = 0;
				}
				else {
					print_rate($place);
					$nul++;
				}
                    $result_pre = $resultRate;
					
					if ($resultRate < $WIN){
                    $zayavkaView->column1();
                    $zayavkaView->column2_expert();
                    $zayavkaView->column3_expert();
				}
				else {
					$zayavkaView->column1_top();
                    $zayavkaView->column2_expert_top();
                    $zayavkaView->column3_expert_top();
				}
                    
                    print_rates(Array('<span style="color: red">'.sprintf("%.2f", $resultRate).'</span>', 
					$resultRateCount));
                    ?> </tr><tr><td></td><td></td><td>
                <?php

				//Блок вывода оценок за номинацию
				
				?> 
				<table style="border-collapse:collapse"; align="center">
				<tr>
				<?php
				
				echo "<td><b>оценки за номинации:</b></td>";
				 
					 echo '<span style="color: black">';
					 ?>
					 <td style="border: 1px solid black;">
					  <?php
					 echo "слож"; 
					 echo "</td>";
					 ?>
					 <td style="border: 1px solid black;">
					  <?php
					  echo "мар"; 
					 echo "</td>";
					 ?>
					 <td style="border: 1px solid black;">
					  <?php
					  echo "отч"; 
					 echo "</td>";
					 ?>
					 <td style="border: 1px solid black;">
					  <?php
					  echo "позн"; 
					 echo "</td>";
					 ?>
					 <td style="border: 1px solid black;">
					  <?php
					  echo "авт"; 
					 echo "</td>";
					 ?>
					 <td style="border: 1px solid black;">
					  <?php
					  echo "дети"; 
					 echo "</td>";
					 ?>
					 <td style="border: 1px solid black;">
					  <?php
					  echo "необ"; 
					 echo "</td>";
					 ?>
					 <td style="border: 1px solid black;">
					  <?php
					  echo "прик"; 
					 echo "</td>";
					 ?>
					 <td style="border: 1px solid black;">
					  <?php
					  echo "фото"; 
					 echo "</td>";
					 ?>
					 <td style="border: 1px solid black;">
					  <?php
					  echo "видео"; 
					 echo "</td>";
					 ?>
					 <td style="border: 1px solid black;">
					  <?php
					  echo "фильм"; 
					 echo "</td>";
					 ?>
					 <td style="border: 1px solid black;">
					  <?php
					  echo "увл"; 
					 echo "</td>";
					 
					 echo "<tr>";
					 echo "<td>";
					 echo "</td>";
					 if ($resultDiff >= $value['max3'] && $flag < 3){
						 ?>
					 					 <td style="border: 1px solid black; background: yellow;" align="center">
					  <?php
					  $flag++;
					 } else {
					 ?>
					 <td style="border: 1px solid black;" align="center">
					  <?php
					 }
					  if ($maxDiff == $resultDiff) echo "<b>";
					  if ($resultDiff != 0) echo sprintf("%.2f", $resultDiff);
                     else echo "-";
					 if ($maxDiff == $resultDiff) echo "</b>";
					 echo "</td>";
					 
					 if ($resultOrg >= $value['max3'] && $flag < 3){
						 ?>
					 					 <td style="border: 1px solid black; background: yellow;" align="center">
					  <?php
					  $flag++;
					 } else {
					 ?>
					 <td style="border: 1px solid black;" align="center">
					  <?php
					 }
					  if ($resultOrg >= $maxOrg) echo "<b>";
					 if ($resultOrg != 0) echo sprintf("%.2f", $resultOrg);
					 else echo "-";
					 if ($resultOrg >= $maxOrg) echo "</b>";
					 echo "</td>";
					 
					 if ($resultOtch >= $value['max3'] && $flag < 3){
						 ?>
					 					 <td style="border: 1px solid black; background: yellow;" align="center">
					  <?php
					  $flag++;
					 } else {
					 ?>
					 <td style="border: 1px solid black;" align="center">
					  <?php
					 }
					  if ($resultOtch != 0) echo sprintf("%.2f", $resultOtch);
					 else echo "-";
					 echo "</td>";
					 
					 if ($resultInf >= $value['max3'] && $flag < 3){
						 ?>
					 					 <td style="border: 1px solid black; background: yellow;" align="center">
					  <?php
					  $flag++;
					 } else {
					 ?>
					 <td style="border: 1px solid black;" align="center">
					  <?php
					 }
					  if ($resultInf != 0) echo sprintf("%.2f", $resultInf);
					 else echo "-";
					 echo "</td>";
					 
					 if ($resultAut >= $value['max3'] && $flag < 3){
						 ?>
					 					 <td style="border: 1px solid black; background: yellow;" align="center">
					  <?php
					  $flag++;
					 } else {
					 ?>
					 <td style="border: 1px solid black;" align="center">
					  <?php
					 }
					  if ($resultAut != 0) echo sprintf("%.2f", $resultAut);
					 else echo "-";
					 echo "</td>";
					 
					 if ($resultChi >= $value['max3'] && $flag < 3){
						 ?>
					 					 <td style="border: 1px solid black; background: yellow;" align="center">
					  <?php
					  $flag++;
					 } else {
					 ?>
					 <td style="border: 1px solid black;" align="center">
					  <?php
					 }
					  if ($resultChi != 0) echo sprintf("%.2f", $resultChi);
					 else echo "-";
					 echo "</td>";
					 
					 if ($resultUnu >= $value['max3'] && $flag < 3){
						 ?>
					 					 <td style="border: 1px solid black; background: yellow;" align="center">
					  <?php
					  $flag++;
					 } else {
					 ?>
					 <td style="border: 1px solid black;" align="center">
					  <?php
					 }
					  if ($resultUnu != 0) echo sprintf("%.2f", $resultUnu);
					 else echo "-";
					 echo "</td>";
					 
					 if ($resultUnf >= $value['max3'] && $flag < 3){
						 ?>
					 					 <td style="border: 1px solid black; background: yellow;" align="center">
					  <?php
					  $flag++;
					 } else {
					 ?>
					 <td style="border: 1px solid black;" align="center">
					  <?php
					 }
					  if ($resultUnf != 0) echo sprintf("%.2f", $resultUnf);
					 else echo "-";
					 echo "</td>";
					 
					 if ($resultFoto >= $value['max3'] && $flag < 3){
						 ?>
					 					 <td style="border: 1px solid black; background: yellow;" align="center">
					  <?php
					  $flag++;
					 } else {
					 ?>
					 <td style="border: 1px solid black;" align="center">
					  <?php
					 }
					  if ($resultFoto != 0) echo sprintf("%.2f", $resultFoto);
					 else echo "-";
					 echo "</td>";
					 
					 if ($resultVideo >= $value['max3'] && $flag < 3){
						 ?>
					 					 <td style="border: 1px solid black; background: yellow;" align="center">
					  <?php
					  $flag++;
					 } else {
					 ?>
					 <td style="border: 1px solid black;" align="center">
					  <?php
					 }
					  if ($resultVideo != 0) echo sprintf("%.2f", $resultVideo);
					 else echo "-";
					 echo "</td>";
					 
					 if ($resultMovie >= $value['max3'] && $flag < 3){
						 ?>
					 					 <td style="border: 1px solid black; background: yellow;" align="center">
					  <?php
					  $flag++;
					 } else {
					 ?>
					 <td style="border: 1px solid black;" align="center">
					  <?php
					 }
					  if ($resultMovie != 0) echo sprintf("%.2f", $resultMovie);
					 else echo "-";
					 echo "</td>";
					 
					 if ($resultExc >= $value['max3'] && $flag < 3){
						 ?>
					 					 <td style="border: 1px solid black; background: yellow;" align="center">
					  <?php
					  $flag++;
					 } else {
					 ?>
					 <td style="border: 1px solid black;" align="center">
					  <?php
					 }
					  if ($resultExc != 0) echo sprintf("%.2f", $resultExc);
					 else echo "-";
					 echo "</td>";
					 
					 echo "</tr>";
					 	 				 
					 
					echo '</span>';
				 
				 
				 ?>
				 </table>
				 
				<?php
				echo "</td></tr>";
				$zayavkaView->hr5(); ?>
                <?php
// записываем в библиотеку походов судейские оценки и места занятые походом
                //AppendRateAndPlaceToLibrary_2018($place, $cat, $subcat, $idz);
                
            }
            echo "</table>";
        }
      

        


        private function getBestRates($db_table_name, $zayavka) {
			
			$q1 = "SELECT id, rate_diff, rate_org, rate_otch, rate_inf, rate_aut, rate_chi, rate_unu, 
rate_unf, rate_foto_1, rate_foto_2, rate_foto_3, rate_video, rate_videoLong, rate_exciting FROM $db_table_name WHERE status = '1'";
$q2 = "SELECT id, rate_diff, rate_org, rate_otch, rate_inf, rate_aut, rate_chi, rate_unu, 
rate_unf, rate_foto_1, rate_foto_2, rate_foto_3, rate_video, rate_videoLong, rate_exciting FROM $db_table_name WHERE status = '-2'";

			$result1 = mysql_query($q1);
			$result2 = mysql_query($q2);
			              
			//$pohodsViewers = $zayavkaList->load(Array('status' => ZayavkaStatus::APPROVED_FOR_VIEWERS_VOTING));
			
			//$pohods = array_merge($pohodsApproved, $pohodsViewers);

            $rates = Array();
			
			            
			for ($i = 0; $i < mysql_num_rows($result1); $i++) {
			$max1 = 0;
			$max2 = 0;
			$max3 = 0;
				$array = mysql_fetch_array($result1);
				$best_rate = $best_cont = $best_summ_foto = $best_foto = 0;
                            
                $best_count = $best_summ = 0; // число номинаций, сумма баллов за номинации с участием
				$idz = $array[0];
                                			
				if ( $array[1] != 0) {
					$best_summ = $best_summ + $array[1];
					list($max1, $max2, $max3) = $this->max3_count($array[1], $max1, $max2, $max3);                     				   				 
					$best_cont++;
				}
				if ( $array[2] != 0) {
					$best_summ = $best_summ + $array[2];
					list($max1, $max2, $max3) = $this->max3_count($array[2], $max1, $max2, $max3); 
					$best_cont++;
				}
				if ( $array[3] != 0) {
					$best_summ = $best_summ + $array[3];
					list($max1, $max2, $max3) = $this->max3_count($array[3], $max1, $max2, $max3); 
					$best_cont++;
				}
				if ( $array[4] != 0) {
					$best_summ = $best_summ + $array[4];
					list($max1, $max2, $max3) = $this->max3_count($array[4], $max1, $max2, $max3); 
					$best_cont++;
				}
				if ( $array[5] != 0) {
					$best_summ = $best_summ + $array[5];
					list($max1, $max2, $max3) = $this->max3_count($array[5], $max1, $max2, $max3); 
					$best_cont++;
				}
				if ( $array[6] != 0) {
					$best_summ = $best_summ + $array[6];
					list($max1, $max2, $max3) = $this->max3_count($array[6], $max1, $max2, $max3); 
					$best_cont++;
				}
				if ( $array[7] != 0) {
					$best_summ = $best_summ + $array[7];
					list($max1, $max2, $max3) = $this->max3_count($array[7], $max1, $max2, $max3); 
					$best_cont++;
				}
				if ( $array[8] != 0) {
					$best_summ = $best_summ + $array[8];
					list($max1, $max2, $max3) = $this->max3_count($array[8], $max1, $max2, $max3); 
					$best_cont++;
				}
				if ( $array[9] != 0 || $array[10] != 0 || $array[11] != 0) {
					$best_foto = max($array[9],$array[10],$array[11]);
					list($max1, $max2, $max3) = $this->max3_count($best_foto, $max1, $max2, $max3); 
					$best_summ = $best_summ + $best_foto;
					$best_cont++;
				}
				
				if ( $array[12] != 0) {
					$best_summ = $best_summ + $array[12];
					list($max1, $max2, $max3) = $this->max3_count($array[12], $max1, $max2, $max3); 
					$best_cont++;
				}
				if ( $array[13] != 0) {
					$best_summ = $best_summ + $array[13];
					list($max1, $max2, $max3) = $this->max3_count($array[13], $max1, $max2, $max3); 
					$best_cont++;
				}
				if ( $array[14] != 0) {
					$best_summ = $best_summ + $array[14];
					list($max1, $max2, $max3) = $this->max3_count($array[14], $max1, $max2, $max3); 
					$best_cont++;
				}
				//if ($best_cont != 0) $best_rate = $best_summ/$best_cont;
				$best_rate = ($max1 + $max2 + $max3)/3;
								
				// формируем массив с оценками
				$rates[] = array(
				    'idz' => $idz,
                    'count' => $best_cont,
                    'rate' => $best_rate,
					'diff' => $array[1],
					'org' => $array[2],
					'otch' => $array[3],
					'inf' => $array[4],
					'aut' => $array[5],
					'chi' => $array[6],
					'unu' => $array[7],
					'unf' => $array[8],
					'foto' => $best_foto,
					'video' => $array[12],
					'movie' => $array[13],
					'exciting' => $array[14],
					'max1' => $max1,
					'max2' => $max2,
					'max3' => $max3
					
                                    );
				
				
               

                

            }
			
			for ($i = 0; $i < mysql_num_rows($result2); $i++) {
				$array = mysql_fetch_array($result2);
				$best_rate = $best_cont = $best_summ_foto = $best_foto = 0;
                            
                $best_count = $best_summ = 0; // число номинаций, сумма баллов за номинации с участием
				$idz = $array[0];
                                			
				if ( $array[1] != 0) {
					$best_summ = $best_summ + $array[1];
					$best_cont++;
				}
				if ( $array[2] != 0) {
					$best_summ = $best_summ + $array[2];
					$best_cont++;
				}
				if ( $array[3] != 0) {
					$best_summ = $best_summ + $array[3];
					$best_cont++;
				}
				if ( $array[4] != 0) {
					$best_summ = $best_summ + $array[4];
					$best_cont++;
				}
				if ( $array[5] != 0) {
					$best_summ = $best_summ + $array[5];
					$best_cont++;
				}
				if ( $array[6] != 0) {
					$best_summ = $best_summ + $array[6];
					$best_cont++;
				}
				if ( $array[7] != 0) {
					$best_summ = $best_summ + $array[7];
					$best_cont++;
				}
				if ( $array[8] != 0) {
					$best_summ = $best_summ + $array[8];
					$best_cont++;
				}
				if ( $array[9] != 0 || $array[10] != 0 || $array[11] != 0) {
					$best_foto = max($array[9],$array[10],$array[11]);
					$best_summ = $best_summ + $best_foto;
					$best_cont++;
				}
				
				if ( $array[12] != 0) {
					$best_summ = $best_summ + $array[12];
					$best_cont++;
				}
				if ( $array[13] != 0) {
					$best_summ = $best_summ + $array[13];
					$best_cont++;
				}
				if ( $array[14] != 0) {
					$best_summ = $best_summ + $array[14];
					$best_cont++;
				}
				if ($best_cont != 0) $best_rate = $best_summ/$best_cont;
				
								
				// формируем массив с оценками
				$rates[] = array(
				    'idz' => $idz,
                    'count' => $best_cont,
                    'rate' => $best_rate,
					'diff' => $array[1],
					'org' => $array[2],
					'otch' => $array[3],
					'inf' => $array[4],
					'aut' => $array[5],
					'chi' => $array[6],
					'unu' => $array[7],
					'unf' => $array[8],
					'foto' => $best_foto,
					'video' => $array[12],
					'movie' => $array[13],
					'exciting' => $array[14]
					
                                    );
				
				
               

                

            }
			
            return $rates;
        }

		


        function sortRates(&$rates) {
            
            foreach ($rates as &$rate) {
				$rate["sortField"] = null;
				                
                $rate["sortField"] = $rate['rate'];
				$rate["summ"] = $rate['count']; 
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
		
		function max3_count($row, $max1, $max2, $max3){
	 
	
	$array2 = array($max1, $max2, $max3);
if ($row > $max1) {
					    $array2[2] = $max2; 
						$array2[1] = $max1;
						$array2[0] = $row;
					}
					else if ($row > $max2){
						$array2[2] = $max2;
						$array2[1] = $row;
					}
					else {
						if ($row > $max3) $array2[2] = $row;
					}
	return $array2;				
					
}
		
 	
		

    }
