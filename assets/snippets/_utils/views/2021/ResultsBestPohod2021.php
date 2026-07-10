<?php

class ResultsBestPohod2021 {
	
	

    function show() {
		
		// эти параметры меняются год от года
        $YEAR_TAG = '2021';
        $db_table_name = 'way2021';
        
        $zayavka_Info_Url = 'archive/participant-2021.html';
        $zayavka = new Zayavka2021;
		
		// получаем данные походов по выбранной номинации
//$nomFilter = isset($_REQUEST['nomFilter']) && $nomFilter != '0' ? $_REQUEST['nomFilter'] : NULL;
$nomFilter = 'bestPohod';


       

        $rates = $this->getBestRates($db_table_name, $zayavka);
		$this->sortRates($rates);
		
		

// Заголовок страницы
        ?>
        <div style="padding: 10px; margin: 10px; width: 900px; background-color:#FFFFD7; font-size:16px; font-weight:bold">
            номинация: <?= 'Лучший поход Года' ?>
           
        </div>
		<br>
		В этой номинации принимают участие только те отчёты, котрые участвовали не менее чем в четырёх номинациях включая три судейские <br>
и походы были совершенны полностью или частично в 2021г (для класса "длительные велопоходы" и "велопутешествия" также 2019г).<br><br>
		<i>* Результат номинации "Лучшая цитата" и "Лучший дебют" не учитывался при определении среднего балла за номинацию.</i><br><br>
		<hr>
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
				$zayavkaList = new zayavkaList($zayavka);


    
								
				
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
			
			//Цикл вывода результатов
            foreach ($rates as $value) {
                $idz = $value['idz'];
                $resultRate = $value['sortField'] > 0 ? $value['sortField'] : 0;
                if (!$resultRate) {
                    continue;   // поход не получил оценок
                }
				$zayavkaList = new zayavkaList($zayavka);


    
								
				
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
	

//ВНИМАНИЕ! Временные исклоючения в условии для 4 отчётов!	
if (!(($resultDiff > 0 && $resultOrg > 0 && $resultOtch > 0 && $resultRateCount >= 4) 
	|| $idz == 32  || $idz == 34  || $idz == 43  || $idz == 51)) 
	continue;   //поход не выполнил условие участия в ЛПГ

//if ($idz == 86) continue; Не учитываем поход Янгировой!!!
				
                ?> <tr> <?php
                    print_rate($place); // занятое походом место
                    $zayavkaView->column1();
                    $zayavkaView->column2();
                    $zayavkaView->column3();
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
					 ?>
					 <td style="border: 1px solid black;" align="center">
					  <?php
					  if ($resultDiff >= $maxDiff) echo "<b>";
					    if ($resultDiff != 0) echo sprintf("%.2f", $resultDiff);
                     else echo "-";
					 if ($resultDiff >= $maxDiff) echo "</b>";
					 echo "</td>";
					 ?>
					 <td style="border: 1px solid black;" align="center">
					  <?php
					  if ($resultOrg >= $maxOrg) echo "<b>";
					 if ($resultOrg != 0) echo sprintf("%.2f", $resultOrg);
					 else echo "-";
					 if ($resultOrg >= $maxOrg) echo "</b>";
					 echo "</td>";
					 ?>
					 <td style="border: 1px solid black;" align="center">
					  <?php
					  if ($resultOtch >= $maxOtch) echo "<b>";
					   if ($resultOtch != 0) echo sprintf("%.2f", $resultOtch);
					 else echo "-";
					 if ($resultOtch >= $maxOtch) echo "</b>";
					 echo "</td>";
					 ?>
					 <td style="border: 1px solid black;" align="center">
					  <?php
					  if ($resultInf >= $maxInf) echo "<b>";
					  if ($resultInf != 0) echo sprintf("%.2f", $resultInf);
					 else echo "-";
					 if ($resultInf >= $maxInf) echo "</b>";
					 echo "</td>";
					 ?>
					 <td style="border: 1px solid black;" align="center">
					  <?php
					  if ($resultAut >= $maxAut) echo "<b>";
					  if ($resultAut != 0) echo sprintf("%.2f", $resultAut);
					 else echo "-";
					 if ($resultAut >= $maxAut) echo "</b>";
					 echo "</td>";
					 ?>
					 <td style="border: 1px solid black;" align="center">
					  <?php
					  if ($resultChi >= $maxChi) echo "<b>";
					  if ($resultChi != 0) echo sprintf("%.2f", $resultChi);
					 else echo "-";
					 if ($resultChi >= $maxChi) echo "</b>";
					 echo "</td>";
					 ?>
					 <td style="border: 1px solid black;" align="center">
					  <?php
					  if ($resultUnu >= $maxUnu) echo "<b>";
					  if ($resultUnu != 0) echo sprintf("%.2f", $resultUnu);
					 else echo "-";
					 if ($resultUnu >= $maxUnu) echo "</b>";
					 echo "</td>";
					 ?>
					 <td style="border: 1px solid black;" align="center">
					  <?php
					  if ($resultUnf >= $maxUnf) echo "<b>";
					  if ($resultUnf != 0) echo sprintf("%.2f", $resultUnf);
					 else echo "-";
					 if ($resultUnf >= $maxUnf) echo "</b>";
					 echo "</td>";
					 ?>
					 <td style="border: 1px solid black;" align="center">
					  <?php
					  if ($resultFoto >= $maxFoto) echo "<b>";
					  if ($resultFoto != 0) echo sprintf("%.2f", $resultFoto);
					 else echo "-";
					 if ($resultFoto >= $maxFoto) echo "</b>";
					 echo "</td>";
					 ?>
					 <td style="border: 1px solid black;" align="center">
					  <?php
					  if ($resultVideo >= $maxVideo) echo "<b>";
					  if ($resultVideo != 0) echo sprintf("%.2f", $resultVideo);
					 else echo "-";
					 if ($resultVideo >= $maxVideo) echo "</b>";
					 echo "</td>";
					 ?>
					 <td style="border: 1px solid black;" align="center">
					  <?php
					  if ($resultMovie >= $maxMovie) echo "<b>";
					  if ($resultMovie != 0) echo sprintf("%.2f", $resultMovie);
					 else echo "-";
					 if ($resultMovie >= $maxMovie) echo "</b>";
					 echo "</td>";
					 ?>
					 <td style="border: 1px solid black;" align="center">
					  <?php
					  if ($resultExc >= $maxExc) echo "<b>";
					  if ($resultExc != 0) echo sprintf("%.2f", $resultExc);
					 else echo "-";
					 if ($resultExc >= $maxExc) echo "</b>";
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
                $place++;
            }
            echo "</table>";
        }
      

        


        private function getBestRates($db_table_name, $zayavka) {
			
			$q = "SELECT id, rate_diff, rate_org, rate_otch, rate_inf, rate_aut, rate_chi, rate_unu, 
rate_unf, rate_foto_1, rate_foto_2, rate_foto_3, rate_video, rate_videoLong, rate_exciting FROM $db_table_name WHERE status = '1'";
			$result = mysql_query($q);
			
              
			//$pohodsViewers = $zayavkaList->load(Array('status' => ZayavkaStatus::APPROVED_FOR_VIEWERS_VOTING));
			
			//$pohods = array_merge($pohodsApproved, $pohodsViewers);

            $rates = Array();
			            
			for ($i = 0; $i < mysql_num_rows($result); $i++) {
				$array = mysql_fetch_array($result);
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
		
		
		

    }
