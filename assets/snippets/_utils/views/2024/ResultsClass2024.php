<?php

class ResultsClass2024 {
	
	private $class_pohod = NULL;
	private $db_table_name = NULL;
	private $WIN = 12;
	private $win_count = 3; 
	
	public function __construct($class_pohod, $table, $WIN, $win_count) {
		
		$this->class_pohod = $class_pohod; //класс похода
		$this->db_table_name = $table; //таблица БД с оценками
		$this->WIN = $WIN; //минимальная оценка которая считается высокой, такие заявки отображаются как топовые
		$this->win_count = $win_count; // число номинаций по которым определяем интегральный балл (выделяем их жёлтой заливкой)
	}

    function show() {
		
		// эти параметры меняются год от года
        $YEAR_TAG = '2024';
        //$db_table_name = 'way2024';
		$nomination_name = 'debut';
		//$WIN = 6.5;
        
        $zayavka_Info_Url = 'archive/participant-2024.html';
        $zayavka = new Zayavka2024;
		
		// получаем данные походов по выбранной номинации
//$nomFilter = isset($_REQUEST['nomFilter']) && $nomFilter != '0' ? $_REQUEST['nomFilter'] : NULL;
$nomFilter = 'bestPohod';


        $rates = $this->getBestRates($this->db_table_name, $zayavka);
		//$zayavkaList = new zayavkaList($zayavka);       
//$zayavkaList->load(Array('nominations' => $nomination_name));
		
		$this->sortRates($rates);
		
		

// Заголовок страницы
        ?>
        <div style="padding: 10px; margin: 10px; width: 900px; background-color:#FFFFD7; font-size:16px; font-weight:bold">
            Лучший в классе: <?= $this->class_pohod ?>
           
        </div>
		<br><div class="cell_yellow2">
		<i>*Результат - средний балл по всем судейским номинациям<br>
		** Максимальный балл за номинацию выделен жирным шрифтом</i>
		</div>
        <table width="100%"  border="0" cellspacing="2" cellpadding="0">

            <?php
            
            $zayavkaView = new ZayavkaView();

            
            $zayavkaView->headerType1_refResults('Средняя оценка/<br>Число номинаций');
			$zayavkaView->hr5();
            $place = 1;
			
			$maxDiff = 0;
			
			//Определение максимального результата
			foreach ($rates as $value) {
				$idz = $value['idz'];
                $resultRate = $value['sortField'] > 0 ? $value['sortField'] : 0;
                if (!$resultRate || strcmp($value['class'], $this->class_pohod) != 0){
                    continue;   // поход не получил оценок или класс не ПВД
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
				if ($maxWin < $value['winter']) $maxWin = $value['winter'];
				if ($maxFoto < $value['foto']) $maxFoto = $value['foto'];
				if ($maxVideo < $value['video']) $maxVideo = $value['video'];
				if ($maxMovie < $value['movie']) $maxMovie = $value['movie'];
				if ($maxLecture < $value['lecture']) $maxLecture = $value['lecture'];
				if ($maxExc < $value['exciting']) $maxExc = $value['exciting'];
				
			}
			
			$result_pre = 0;
			$nul = 0;
			//Цикл вывода результатов
            foreach ($rates as $value) {
				$flag = 0;
                $idz = $value['idz'];
                $resultRate = $value['sortField'] > 0 ? $value['sortField'] : 0;
                if (!$resultRate  || strcmp($value['class'], $this->class_pohod) != 0) {
                    continue;   // поход не получил оценок или не ПВД
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
				$resultWin = $value['winter'];
				$resultFoto = $value['foto'];
				$resultVideo = $value['video'];
				$resultMovie = $value['movie'];
				$resultLecture = $value['lecture'];
				$resultExc = $value['exciting'];
							
if (!($resultRateCount >= 3)) 
	continue;   //поход не выполнил условие участия в Номинации

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
					
					if ($resultRate < $this->WIN){
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
					 $this->table_td_name($name = "сложн");
					 $this->table_td_name($name = "маршр");
					 $this->table_td_name($name = "отчёт");
					 $this->table_td_name($name = "познав");
					 $this->table_td_name($name = "автон");
					 $this->table_td_name($name = "дети");
					 $this->table_td_name($name = "необыч");
					 $this->table_td_name($name = "прикл");
					 $this->table_td_name($name = "зимний");
					 $this->table_td_name($name = "фото");
					 $this->table_td_name($name = "видео");
					 $this->table_td_name($name = "фильм");
					 $this->table_td_name($name = "лекция");
					 $this->table_td_name($name = "увлек");
					 
					 
					 $max1 = $value['max1'];
					 $max2 = $value['max2'];
					 $max3 = $value['max3'];
					 $yellow = 1;
					// $yellow = $this->max3_yellow($max1, $max2, $max3);
					 echo "</tr><tr>";
					 echo "<td>";
					 echo "</td>";
					 
					 //Значение оценок за номинации
					 $this->table_td_value($maxDiff, $resultDiff, $yellow_td = true);
					 $this->table_td_value($maxOrg, $resultOrg, $yellow_td = true);
					 $this->table_td_value($maxOtch, $resultOtch, $yellow_td = true);
					 $this->table_td_value($maxInf, $resultInf, $yellow_td = false);
					 $this->table_td_value($maxAut, $resultAut, $yellow_td = false);
					 $this->table_td_value($maxChi, $resultChi, $yellow_td = false);
					 $this->table_td_value($maxUnu, $resultUnu, $yellow_td = false);
					 $this->table_td_value($maxUnf, $resultUnf, $yellow_td = false);
					 $this->table_td_value($maxWin, $resultWin, $yellow_td = false);
					 $this->table_td_value($maxFoto, $resultFoto, $yellow_td = false);
					 $this->table_td_value($maxVideo, $resultVideo, $yellow_td = false);
					 $this->table_td_value($maxMovie, $resultMovie, $yellow_td = false);
					 $this->table_td_value($maxLecture, $resultLecture, $yellow_td = false);
					 $this->table_td_value($maxExc, $resultExc, $yellow_td = false);
					 
					  
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
      

        


        protected function getBestRates($db_table_name, $zayavka) {
			
			$q1 = "SELECT id, rate_diff, rate_org, rate_otch, rate_inf, rate_aut, rate_chi, rate_unu, 
rate_unf, rate_foto_1, rate_foto_2, rate_foto_3, rate_video, rate_videoLong, rate_exciting, class, rate_winter, rate_lecture FROM $db_table_name WHERE status = '1'";
$q2 = "SELECT id, rate_diff, rate_org, rate_otch, rate_inf, rate_aut, rate_chi, rate_unu, 
rate_unf, rate_foto_1, rate_foto_2, rate_foto_3, rate_video, rate_videoLong, rate_exciting, class, rate_winter, rate_lecture FROM $db_table_name WHERE status = '-2'";

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
					//$best_summ = $best_summ + $array[4];
					list($max1, $max2, $max3) = $this->max3_count($array[4], $max1, $max2, $max3); 
					//$best_cont++;
				}
				if ( $array[5] != 0) {
					//$best_summ = $best_summ + $array[5];
					list($max1, $max2, $max3) = $this->max3_count($array[5], $max1, $max2, $max3); 
					//$best_cont++;
				}
				if ( $array[6] != 0) {
					//$best_summ = $best_summ + $array[6];
					list($max1, $max2, $max3) = $this->max3_count($array[6], $max1, $max2, $max3); 
					//$best_cont++;
				}
				if ( $array[7] != 0) {
					//$best_summ = $best_summ + $array[7];
					list($max1, $max2, $max3) = $this->max3_count($array[7], $max1, $max2, $max3); 
					//$best_cont++;
				}
				if ( $array[8] != 0) {
					//$best_summ = $best_summ + $array[8];
					list($max1, $max2, $max3) = $this->max3_count($array[8], $max1, $max2, $max3); 
					//$best_cont++;
				}
				if ( $array[16] != 0) {
					//$best_summ = $best_summ + $array[8];
					list($max1, $max2, $max3) = $this->max3_count($array[16], $max1, $max2, $max3); 
					//$best_cont++;
				}
				if ( $array[9] != 0 || $array[10] != 0 || $array[11] != 0) {
					$best_foto = max($array[9],$array[10],$array[11]);
					list($max1, $max2, $max3) = $this->max3_count($best_foto, $max1, $max2, $max3); 
					//$best_summ = $best_summ + $best_foto;
					//$best_cont++;
				}
				
				if ( $array[12] != 0) {
					//$best_summ = $best_summ + $array[12];
					list($max1, $max2, $max3) = $this->max3_count($array[12], $max1, $max2, $max3); 
					//$best_cont++;
				}
				if ( $array[13] != 0) {
					//$best_summ = $best_summ + $array[13];
					list($max1, $max2, $max3) = $this->max3_count($array[13], $max1, $max2, $max3); 
					//$best_cont++;
				}
				if ( $array[17] != 0) {
					//$best_summ = $best_summ + $array[8];
					list($max1, $max2, $max3) = $this->max3_count($array[17], $max1, $max2, $max3); 
					//$best_cont++;
				}
				if ( $array[14] != 0) {
					//$best_summ = $best_summ + $array[14];
					list($max1, $max2, $max3) = $this->max3_count($array[14], $max1, $max2, $max3); 
					//$best_cont++;
				}
				if (!empty($array[15])) $class1 = $array[15];
				//if ($best_cont != 0) $best_rate = $best_summ/$best_cont;
				if ($best_cont != 0) $best_rate = $best_summ/$best_cont;
				else $best_rate = 0;
								
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
					'winter' => $array[16],
					'foto' => $best_foto,
					'video' => $array[12],
					'movie' => $array[13],
					'exciting' => $array[14],
					'lecture' => $array[17],
					'max1' => $max1,
					'max2' => $max2,
					'max3' => $max3,
					'class' => $class1
					
                                    );
				
				
               

                

            }
			
			for ($i = 0; $i < mysql_num_rows($result2); $i++) {
			$max1 = 0;
			$max2 = 0;
			$max3 = 0;
				$array = mysql_fetch_array($result2);
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
					//$best_summ = $best_summ + $array[4];
					list($max1, $max2, $max3) = $this->max3_count($array[4], $max1, $max2, $max3); 
					//$best_cont++;
				}
				if ( $array[5] != 0) {
					//$best_summ = $best_summ + $array[5];
					list($max1, $max2, $max3) = $this->max3_count($array[5], $max1, $max2, $max3); 
					//$best_cont++;
				}
				if ( $array[6] != 0) {
					//$best_summ = $best_summ + $array[6];
					list($max1, $max2, $max3) = $this->max3_count($array[6], $max1, $max2, $max3); 
					//$best_cont++;
				}
				if ( $array[7] != 0) {
					//$best_summ = $best_summ + $array[7];
					list($max1, $max2, $max3) = $this->max3_count($array[7], $max1, $max2, $max3); 
					//$best_cont++;
				}
				if ( $array[8] != 0) {
					//$best_summ = $best_summ + $array[8];
					list($max1, $max2, $max3) = $this->max3_count($array[8], $max1, $max2, $max3); 
					//$best_cont++;
				}
				if ( $array[16] != 0) {
					//$best_summ = $best_summ + $array[8];
					list($max1, $max2, $max3) = $this->max3_count($array[16], $max1, $max2, $max3); 
					//$best_cont++;
				}
				if ( $array[9] != 0 || $array[10] != 0 || $array[11] != 0) {
					$best_foto = max($array[9],$array[10],$array[11]);
					list($max1, $max2, $max3) = $this->max3_count($best_foto, $max1, $max2, $max3); 
					//$best_summ = $best_summ + $best_foto;
					//$best_cont++;
				}
				
				if ( $array[12] != 0) {
					//$best_summ = $best_summ + $array[12];
					list($max1, $max2, $max3) = $this->max3_count($array[12], $max1, $max2, $max3); 
					//$best_cont++;
				}
				if ( $array[13] != 0) {
					//$best_summ = $best_summ + $array[13];
					list($max1, $max2, $max3) = $this->max3_count($array[13], $max1, $max2, $max3); 
					//$best_cont++;
				}
				if ( $array[17] != 0) {
					//$best_summ = $best_summ + $array[8];
					list($max1, $max2, $max3) = $this->max3_count($array[17], $max1, $max2, $max3); 
					//$best_cont++;
				}
				if ( $array[14] != 0) {
					//$best_summ = $best_summ + $array[14];
					list($max1, $max2, $max3) = $this->max3_count($array[14], $max1, $max2, $max3); 
					//$best_cont++;
				}
				if (!empty($array[15])) $class1 = $array[15];
				//if ($best_cont != 0) $best_rate = $best_summ/$best_cont;
				if ($best_cont != 0) $best_rate = $best_summ/$best_cont;
				else $best_rate = 0;
				
				
				
								
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
					'winter' => $array[16],
					'foto' => $best_foto,
					'video' => $array[12],
					'movie' => $array[13],
					'exciting' => $array[14],
					'lecture' => $array[17],
					'max1' => $max1,
					'max2' => $max2,
					'max3' => $max3,
					'class' => $class1
					
					
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

 function max3_yellow($max1, $max2, $max3){
	if ($max1 == $max2 && $max2 == $max3) $yellow = 3;
	else if (($max2 == $max3) && ($max1 != $max2) ) $yellow = 2;
	else $yellow = 1;
return $yellow;
}

protected function table_td_name($name){
	?>
				 <td style="border: 1px solid black;">
					  <?php
					  echo $name; 
					  ?>
					 </td>
			<?php		 
}

protected function table_td_value($max, $result, $yellow){
	
	if ($this->win_count <= 0) $yellow = false;
	if ($yellow) {
		echo '<td style="border: 1px solid black; background: yellow;" align="center">';
		$this->win_count--;
	}
	else echo '<td style="border: 1px solid black;" align="center">';
	
					  if ($max == $result) echo "<b>";
					  if ($resultDiff != 0) echo sprintf("%.2f", $resultDiff);
                     else echo "-";
					// echo "+" . $value['max1'] . $value['max2'] . $value['max3'] . $value['rate'];
					 if ($maxDiff == $resultDiff) echo "</b>";
					 echo "</td>";
}
		
 	
		

    }
