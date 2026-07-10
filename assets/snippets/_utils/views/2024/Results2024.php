<?php

class Results2024
{
	

    function show()
    {
        // эти параметры меняются год от года
        $zayavka_Info_Url = 'archive/participant-2024.html';
        $YEAR_TAG = '2024';
        $zayavka = new Zayavka2024;

        $cat = intval($_GET["cat"]);
        if (!$cat || $cat < 6 || ($cat > 8 && $cat < 11) || $cat > 11) {
            $this->showDescr();
            return;
        }

        if ($cat == 6) {
            $sortParamName = 'км';
            ?> <br>
            <div style="padding: 10px; margin: 10px; width: 900px; background-color:#FFFFD7; font-size:16px; font-weight:bold">
                Самый протяженный маршрут
            </div> <?php
           $zayavkaList1 = new zayavkaList($zayavka);
            $zayavkaList1->load(Array('status' => 1));
            $zayavkaList2 = new zayavkaList($zayavka);
            $zayavkaList2->load(Array('status' => -2));
            $all = array_merge($zayavkaList1->list, $zayavkaList2->list);
			
            foreach ($all as $key => $row) {
                $all[$key]['sortField'] = $row['mileage'];
            }
        } elseif ($cat == 7) {
            $sortParamName = 'дней';
            ?> <br>
            <div style="padding: 10px; margin: 10px; width: 900px; background-color:#FFFFD7; font-size:16px; font-weight:bold">
                Cамый продолжительный поход
            </div> <?php
			$zayavkaList1 = new zayavkaList($zayavka);
            $zayavkaList1->load(Array('status' => 1));
            $zayavkaList2 = new zayavkaList($zayavka);
            $zayavkaList2->load(Array('status' => -2));
            $all = array_merge($zayavkaList1->list, $zayavkaList2->list);
            
            foreach ($all as $key => $row) {
                $all[$key]['sortField'] = Period::get_trip_duration($row['period']);
            }
        } elseif ($cat == 8) {
            $sortParamName = 'км/день';
            ?> <br>
            <div style="padding: 10px; margin: 10px; width: 900px; background-color:#FFFFD7; font-size:16px; font-weight:bold">
                Cамый скоростной поход
            </div> <?php
            $zayavkaList1 = new zayavkaList($zayavka);
            $zayavkaList1->load(Array('status' => 1));
            $zayavkaList2 = new zayavkaList($zayavka);
            $zayavkaList2->load(Array('status' => -2));
            $all = array_merge($zayavkaList1->list, $zayavkaList2->list);
			
            foreach ($all as $key => $row) {
				
                $dur = Period::get_trip_duration($row['period']);
				if ($dur < 4) continue;
                $all[$key]['sortField'] = $dur ? $row['mileage'] / $dur : 0;
            }
        }
		elseif ($cat == 11) {
            $sortParamName = 'участников';
            ?> <br>
            <div style="padding: 10px; margin: 10px; width: 900px; background-color:#FFFFD7; font-size:16px; font-weight:bold">
                Cамый массовый поход
            </div> <?php
            $zayavkaList1 = new zayavkaList($zayavka);
            $zayavkaList1->load(Array('status' => 1));
            $zayavkaList2 = new zayavkaList($zayavka);
            $zayavkaList2->load(Array('status' => -2));
            $all = array_merge($zayavkaList1->list, $zayavkaList2->list);
			
            foreach ($all as $key => $row) {
                $all[$key]['sortField'] = $row['number'];
            }
        }
		//Универсальная функция сортировки для всех статистических номинаций
        usort($all, function ($a, $b) {
            $d1 = $a['sortField'];
            $d2 = $b['sortField'];
            if ($d1 == $d2)
                return 0;
            return ($d1 < $d2) ? 1 : -1;
        });
		if ($cat == 11) $this->countStaticTable($all, $zayavka);
        ?>
        <table width="100%" border="0" cellspacing="2" cellpadding="0"> <?php
            $zayavkaView = new ZayavkaView();
			
            $zayavkaView->headerType1_StatNomResult($sortParamName);

            $place = 1;
			$preSum = 0;
            $preRate = 0;	
			
			
            foreach ($all as $i => $row) {
                $zayavka->data = $row;
               
                            //$place++;
                
				if ($preRate != $zayavka->data['sortField']) {
		$preSum = $place; 
		 $zayavka->data['place'] = $place;
		//print_rate($place++); // занятое место
        $place++;
	}
		else {
		$zayavka->data['place'] = $preSum;
		//print_rate($preSum); // занятое место
		$place++;
	}
	 $zayavkaView->setData($zayavka, $zayavka_Info_Url);
                if ($preSum  > 6 ) {
				 	$zayavkaView->row_StatNomResult($zayavka->data['sortField']);
				
				}
				else $zayavkaView->row_StatNomResult_top($zayavka->data['sortField']);
                $zayavkaView->hr5();
				
	$preRate = $zayavka->data['sortField'];
            }

            ?>
        </table>
        <?php
    }

    function showDescr()
    {

        ?>
		
		<!--
        <h2> "Путь-2024"</h2>
		
0		 
        <p><a href="http://www.veloway.su/archive/win2024.html">Победители</a></p>
        <p><a href="https://youtube.com/live/-EHC4SckRcc">Видео церемонии подведения итогов (31.03.2024, ведущий Сергей Шонин)</a></p>
		<br>
		!-->
          <hr>  
		  <br>
		  <p><b><a href="http://www.veloway.su/archive/win2024.html">Победители</a></b></p>
		  
        <p><a href="[~[*id*]~]?cat=9">Лучший дебют</a><br>
       <!-- <b>Дополнительные номинации:</b></p>
		<p><a href="http://www.veloway.su/archive/participant-2024.html?idz=23">Самый зимний велопоход</a></p><br><br>
		

        <p><a href="/maps/Rezultat/2024/Za_vklad_2024.jpg">За вклад в развитие велотуризма</a></p>
        <br><br>!-->

        
        <p><b>Номинации со статистической оценкой:</b></p>
        <p><a href="[~[*id*]~]?cat=6">Самый протяженный маршрут</a></p>
        <p><a href="[~[*id*]~]?cat=7">Cамый продолжительный поход</a></p>
        <p><a href="[~[*id*]~]?cat=8">Самый скоростной поход</a></p>
		<p><a href="[~[*id*]~]?cat=11">Самый массовый поход</a></p>
		<!--
		<p><a href="archive/sudya-2024.html">Лучший судья</a></p>
		<p><a href="archive/zritel-2024.html">Лучший зритель</a></p>
		
        <p><a href="[~[*id*]~]?cat=9">Лучший дебют</a></p>!-->
        <br><br>
        <p><b>Номинации со зрительской оценкой:</b></p>
        <!-- <p><a href="archive/video2024.html">Видеоролик</a></p>
		<p><a href="archive/movie2024.html">Лучший фильм о походе</a></p>
        <p><a href="archive/foto2024.html">Лучшая походная фотография</a></p>
		<p><a href="archive/exciting2024.html">Самый увлекательный отчет</a></p>
		<p><a href="archive/quote2024.html">Лучшая цитата ВелоПути</a></p> 
		-->
		<p><a href="archive/video2024.html">Видеоролик</a></p>
		<p><a href="archive/movie2024.html">Лучший фильм о походе</a></p>
		<p><a href="archive/lecture2024.html">Лекция</a></p>
        <p><a href="archive/foto2024.html">Лучшая походная фотография</a></p>
		<p><a href="archive/exciting2024.html">Самый увлекательный отчет</a></p>
		
		<p><a href="archive/quote2024.html">Лучшая цитата ВелоПути</a></p> 
		        <br><br>
				
				<p><b>Экспертные номинации:</b></p>
        <p><a href="[~[*id*]~]?cat=5&subcat=1">Самый познавательный поход</a></p>
        <p><a href="[~[*id*]~]?cat=5&subcat=2">Самый автономный маршрут</a></p>
        <p><a href="[~[*id*]~]?cat=5&subcat=3">Самый необычный поход</a></p>
        <p><a href="[~[*id*]~]?cat=5&subcat=4">Лучший велопоход с детьми</a></p>
        <p><a href="[~[*id*]~]?cat=5&subcat=5">Самый приключенческий поход</a></p>
		<p><a href="[~[*id*]~]?cat=5&subcat=6">Самый зимний поход</a></p>
        <br><br>
		
		<hr>
        <p><b>Судейские номинации:</b></p>
        <br>
		
        <b><p>Самый сложный велопоход:</b><br>
		<a href="[~[*id*]~]?cat=1&subcat=1">Короткие велопоходы (до 400км)</a><br>
		<a href="[~[*id*]~]?cat=2&subcat=1">Велопоходы (от 400км до 800км)</a><br>
		<a href="[~[*id*]~]?cat=3&subcat=1">Длинные велопоходы (более 800км)</a><br>
		<a href="[~[*id*]~]?cat=4&subcat=1">Велопутешествия (более 28 дней)</a><br>
		<a href="[~[*id*]~]?cat=20&subcat=1"><b>Самый сложный поход Года</b> (в абсолюте)</a><br> 
		<br>
		<b>Лучший маршрут:</b><br>
		<a href="[~[*id*]~]?cat=1&subcat=2">Короткие велопоходы (до 400км)</a><br>
		<a href="[~[*id*]~]?cat=2&subcat=2">Велопоходы (от 400км до 800км)</a><br>
		<a href="[~[*id*]~]?cat=3&subcat=2">Длинные велопоходы (более 800км)</a><br>
		<a href="[~[*id*]~]?cat=4&subcat=2">Велопутешествия (более 28 дней)</a><br>
		<a href="[~[*id*]~]?cat=20&subcat=2"><b>Лучший маршрут Года</b> (в абсолюте)</a><br><br>
		
		<b>Лучший отчёт:</b><br>
		<a href="[~[*id*]~]?cat=1&subcat=3">Короткие велопоходы (до 400км)</a><br>
		<a href="[~[*id*]~]?cat=2&subcat=3">Велопоходы (от 400км до 800км)</a><br>
		<a href="[~[*id*]~]?cat=3&subcat=3">Длинные велопоходы (более 800км)</a><br>
		<a href="[~[*id*]~]?cat=4&subcat=3">Велопутешествия (более 28 дней)</a><br>
		
		<br></p>
		<hr>
		<p><b>Лучший в классе:</b><br>
		<a href="[~[*id*]~]?cat=12">ПВД (от 2 до 3 дней)</a><br>
        <a href="[~[*id*]~]?cat=13">Короткие велопоходы (до 400км)</a><br>
        <a href="[~[*id*]~]?cat=14">Велопоходы (от 400км до 800км)</a><br>		
        <a href="[~[*id*]~]?cat=15">Длинные велопоходы (более 800км)</a><br>
        <a href="[~[*id*]~]?cat=16">Велопутешествия (более 28 дней)</a><br><br> 		
		
<p><b><a href="[~[*id*]~]?cat=10">Гран-при Фестиваля 2024</a></b><br><br></p>
 	<!--	
<p><b><a href="/assets/images/winner/2024/Za_vklad_2024.jpg">За вклад в развитие велотуризма</a></b></p><br>

		
        <h3>Оценка судейства:</h3>
        <p><a href="assets/images/news/2024/2024-Zritel.png">Лучший зритель</a></p>
		<br><br>
		
        <p><a href="/maps/Rezultat/2024/Sudya_2024.png">Лучший судья</a></p>
        <br><br>
        
        <h3>Анонимное голосование - наиболее читаемый отчёт:</h3>
        <p><a href="openvoting.html">Приз зрительских симпатий</a></p>
        <br><br>
        <p><a href="http://www.veloway.su/maps/Rezultat/2024/Itog_2024_final.xlsx">Подробные результаты финала в формате
                Excel</a></p>


        <p><a href="http://www.veloway.su/map/map2024.html" target="_blank">Общая карта треков походов-участников
                конкурса</a></p>
!-->
<hr>
        <p><a href="archive/participants2024.html">Список участников конкурса</a></p>
        <p><a href="archive/rules-2024.html" target="_blank">Положение-2024</a></p>
        <?php
    }


// записываем в библиотеку походов судейские оценки и места занятые походом
// not ready!!!
    private function AppendRateAndPlaceToLibrary_2016($place, $cat, $subcat, $id_z, $rate = 0)
    {
        $db_name = 'way_library_debug';
        $YEAR_TAG = '2016';
// !!!!!!!!!! need fix !!!!
        // !!!!!!!!!! need fix !!!!
        // записываем в библиотеку походов судейские оценки и места занятые походом
        if (($cat >= 1) and ($cat <= 4)) {
            $q2 = "UPDATE $db_name SET rate_diff=$rate WHERE (idz = $id_z) AND (year = $YEAR_TAG)";
            echo $q2;
            $result = mysql_query($q2);
        }

//	Записываем в библиотеку призовые места по категориям
// *** номера номинаций в конкурсе 2016
// 1 cамый сложный
// 2 cамый ориг маршр
// 3 cамый лучш отчет
// *** номера номинации в библиотеке
// 1 - Самый сложный поход, 2 - Лучший маршрут, 3 - Лучший отчет, 4 - Приз зрительских симпатий
// 5 - Самый интересный поход, 6 - Самый необычный поход, 7 - Лучший маршрут, 8 - Лучшие велоэкскурсии, 9 - Лучшая организация и проведение похода
// 10 - Самый оригинальный поход, 11 - Наиболее познавательный велопоход
// конвертим номер категории конкурса в номер категории библиотеки
        $lib_cat = NULL;  // номер номинации конкурса, используемый в библиотеке походов
        if (($cat >= 1) and ($cat <= 4)) {
            if ($subcat == 1)
                $lib_cat = 1;
            elseif ($subcat == 2)
                $lib_cat = 2;
            elseif ($subcat == 3)
                $lib_cat = 3;
            else
                return;
        }
        if (!isset($place) or ($place > 3) or !isset($lib_cat))
            return;  // записываем только призовые места, с известными программе номинациями
        dbAppendPlaceToLib($place, $lib_cat, $db_name, "prises", "(idz = $id_z) AND (year = \"$YEAR_TAG\")", true);
// кроме того, руками надо добавить места по номинациям:
// приз зрит симпатий, видеоконкурс, Лучший поход года
    }
	
	//получение таблицы распределения числа участников
	public function countStaticTable($all, $zayavka){
		$num1 = 0;
		$num2 = 0;
		$num3 = 0;
		$num4 = 0;
		$num5 = 0;
		$numM = 0;
	    $summ = 0;
		foreach ($all as $i => $row) {
                $zayavka->data = $row;
				$num = $zayavka->data['sortField'];
				
				if ($num == 1) $num1++;
				if ($num == 2) $num2++;
				if ($num == 3) $num3++;
				if ($num == 4) $num4++;
				if ($num == 5) $num5++;
				if ($num >= 6) $numM++;
			
		}
		
		$summ = $num1 + $num2 + $num3 + $num4 + $num5 + $numM; 
		//массив распределения числа участников
		$stTable[] = Array();
		$stTable = array('n1' => $num1, 'n2' =>  $num2, 'n3' =>  $num3, 'n4' =>  $num4, 'n5' =>  $num5, 'n6' =>  $numM, 'summ' =>  $summ);
		
		$this->printStaticTable($stTable); 
	}
	
	public function printStaticTable($stTable){
		echo "<table border=\"1\" align=\"center\"><tr><th width=\"20%\">число участников</th><th width=\"10%\">1</th>
		<th width=\"10%\">2</th><th width=\"10%\">3</th><th width=\"10%\">4</th><th width=\"10%\">5</th><th width=\"10%\">6 и больше</th></tr>";
		$n1 = $stTable['n1'];
		$n2 = $stTable['n2'];
		$n3 = $stTable['n3'];
		$n4 = $stTable['n4'];
		$n5 = $stTable['n5'];
		$n6 = $stTable['n6'];
		$summ = $stTable['summ']; 
		echo "<tr align=\"center\"><td>число походов</td><td>$n1</td><td>$n2</td><td>$n3</td><td>$n4</td><td>$n5</td><td>$n6</td></tr>";
		$n1p = $this->calc_percent($n1, $summ);
		$n2p = $this->calc_percent($n2, $summ); 
		$n3p = $this->calc_percent($n3, $summ); 
		$n4p = $this->calc_percent($n4, $summ); 
		$n5p = $this->calc_percent($n5, $summ); 
		$n6p = $this->calc_percent($n6, $summ); 
		echo "<tr align=\"center\"><td>% походов</td><td>$n1p</td><td>$n2p</td><td>$n3p</td><td>$n4p</td><td>$n5p</td><td>$n6p</td></tr></table><br>";
        	
	}
	public function calc_percent($count, $summ)
{
	return round(($count /$summ )*100)."%"; 
}
}
