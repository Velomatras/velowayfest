<?php

class Results2023
{

    function show()
    {
        // эти параметры меняются год от года
        $zayavka_Info_Url = 'archive/participant-2023.html';
        $YEAR_TAG = '2023';
        $zayavka = new Zayavka2023;

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
                if ($place > 6) $zayavkaView->row_StatNomResult($zayavka->data['sortField']);
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
        <h2> "Путь-2023"</h2>
		
		 !-->
        <p><a href="http://www.veloway.su/archive/win2023.html">Победители</a></p>
        <p><a href="https://www.youtube.com/live/47GtqgLLIO4">Видео церемонии подведения итогов</a></p>
		<br>
       

        <h3>Дополнительные номинации:</h3>
        <p><a href="[~[*id*]~]?cat=9">Лучший дебют</a></p><br>
        
<!--
        <p><a href="/maps/Rezultat/2023/Za_vklad_2023.jpg">За вклад в развитие велотуризма</a></p>
        <br><br>!-->

        
        <h3>Номинации со статистической оценкой:</h3>
        <p><a href="[~[*id*]~]?cat=6">Самый протяженный маршрут</a></p>
        <p><a href="[~[*id*]~]?cat=7">Cамый продолжительный поход</a></p>
        <p><a href="[~[*id*]~]?cat=8">Самый скоростной поход</a></p>
		<p><a href="[~[*id*]~]?cat=11">Самый массовый поход</a></p>
		<!--
		<p><a href="archive/sudya-2023.html">Лучший судья</a></p>
		<p><a href="archive/zritel-2023.html">Лучший зритель</a></p>
		
        <p><a href="[~[*id*]~]?cat=9">Лучший дебют</a></p>!-->
        <br><br>
        <h3>Номинации со зрительской оценкой:</h3>
        <p><a href="archive/video2023.html">Видеоролик</a></p>
		<p><a href="archive/movie2023.html">Лучший фильм о походе</a></p>
        <p><a href="archive/foto2023.html">Лучшая походная фотография</a></p>
        <p><a href="archive/exciting2023.html">Самый увлекательный отчет</a></p>
		<p><a href="archive/quote2023.html">Лучшая цитата ВелоПути</a></p>
		        <br><br>
				
				<h3>Экспертные номинации:</h3>
        <p><a href="[~[*id*]~]?cat=5&subcat=1">Самый познавательный поход</a></p>
        <p><a href="[~[*id*]~]?cat=5&subcat=2">Самый автономный маршрут</a></p>
        <p><a href="[~[*id*]~]?cat=5&subcat=3">Самый необычный поход</a></p>
        <p><a href="[~[*id*]~]?cat=5&subcat=4">Лучший велопоход с детьми</a></p>
        <p><a href="[~[*id*]~]?cat=5&subcat=5">Самый приключенческий поход</a></p>
        <br><br>
		
		<br>
        <h3>Основные (судейские) номинации:</h3>
        <br><br>
		
        <b><p>Самый сложный велопоход:</b><br>
		<a href="[~[*id*]~]?cat=1&subcat=1">Короткие велопоходы (от 4 до 10 дней)</a><br>
		<a href="[~[*id*]~]?cat=2&subcat=1">Велопоходы (от 11 до 16 дней)</a><br>
		<a href="[~[*id*]~]?cat=3&subcat=1">Длительные велопоходы (от 17 до 28 дней)</a><br>
		<!--
		<a href="[~[*id*]~]?cat=4&subcat=1">Велопутешествия (более 28 дней)</a><br> -->
		<br>
		<b>Самый оригинальный маршрут:</b><br>
		<a href="[~[*id*]~]?cat=1&subcat=2">Короткие велопоходы (от 4 до 10 дней)</a><br>
		<a href="[~[*id*]~]?cat=2&subcat=2">Велопоходы (от 11 до 16 дней)</a><br>
		<a href="[~[*id*]~]?cat=3&subcat=2">Длительные велопоходы (от 17 до 28 дней)</a><br>
		<!--
		<a href="[~[*id*]~]?cat=4&subcat=2">Велопутешествия (более 28 дней)</a><br>--><br>
		
		<b>Лучший отчёт:</b><br>
		<a href="[~[*id*]~]?cat=1&subcat=3">Короткие велопоходы (от 4 до 10 дней)</a><br>
		<a href="[~[*id*]~]?cat=2&subcat=3">Велопоходы (от 11 до 16 дней)</a><br>
		<a href="[~[*id*]~]?cat=3&subcat=3">Длительные велопоходы (от 17 до 28 дней)</a><br>
		<!--<a href="[~[*id*]~]?cat=4&subcat=3">Велопутешествия (более 28 дней)</a><br>-->
		
		<br><br>
				   
               		
<p><b><a href="[~[*id*]~]?cat=10">Гран-при Фестиваля 2023</a></b><br><br></p>

<p><b><a href="/assets/images/winner/2023/Za_vklad_2023.jpg">За вклад в развитие велотуризма</a></b></p><br>
	<!--	
        <h3>Оценка судейства:</h3>
        <p><a href="assets/images/news/2023/2023-Zritel.png">Лучший зритель</a></p>
		<br><br>
		
        <p><a href="/maps/Rezultat/2023/Sudya_2023.png">Лучший судья</a></p>
        <br><br>
        
        <h3>Анонимное голосование - наиболее читаемый отчёт:</h3>
        <p><a href="openvoting.html">Приз зрительских симпатий</a></p>
        <br><br>
        <p><a href="http://www.veloway.su/maps/Rezultat/2023/Itog_2023_final.xlsx">Подробные результаты финала в формате
                Excel</a></p>
!-->
<hr>
        <p><a href="http://www.veloway.su/map/map2023.html" target="_blank">Общая карта треков походов-участников
                конкурса</a></p>

        <p><a href="archive/participants2023.html">Список участников конкурса</a></p>
        <p><a href="archive/rules-2023.html" target="_blank">Положение-2023</a></p>
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
}
