<?php

class ResultsExperts2017 {

    function show() {

// эти параметры меняются год от года
        $YEAR_TAG = '2017';
        $db_table_name = 'way2017';
        $voting_db_name = 'way_voting_expert_2017';
        $zayavka_Info_Url = 'participant-2017.html';
        $zayavka = new Zayavka2017;

        $subcat = intval($_GET["subcat"]);
        if ($subcat < 1 || $subcat > 5) {
            return;
        }

        $rates = $this->getExpertsRates($zayavka, $voting_db_name);
        $this->sortRates($subcat, $rates);

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

            $zayavkaView->headerType1_refResults('Средняя оценка/<br>Кол-во оценок');
            $place = 1;
            foreach ($rates as $value) {
                $idz = $value['idz'];
                $resultRate = $value['sortField'] > 0 ? $value['sortField'] : 0;
                if (!$resultRate) {
                    continue;   // поход не получил оценок
                }
                $zayavka->load($idz);
                $zayavkaView->setData($zayavka, $zayavka_Info_Url);
// выводим очередную строку таблицы
                $resultRateCount = $value[$this->subcat_num_to_internalName($subcat) . 'Count'];
                ?> <tr> <?php
                    print_rate($place); // занятое походом место
                    $zayavkaView->column1();
                    $zayavkaView->column2();
                    $zayavkaView->column3();
                    print_rates(Array(sprintf("%.2f", $resultRate), $resultRateCount));
                    ?> </tr>
                <?php $zayavkaView->hr(); ?>
                <?php
// записываем в библиотеку походов судейские оценки и места занятые походом
                //AppendRateAndPlaceToLibrary_2017($place, $cat, $subcat, $idz);
                $place++;
            }
            echo "</table>";
        }

        private function subcat_num_to_name($subcat) {
            if ($subcat == 1)
                $valueName = 'Информативный';
            if ($subcat == 2)
                $valueName = 'Автономный';
            if ($subcat == 3)
                $valueName = 'Необычный';
            if ($subcat == 4)
                $valueName = 'С детьми';
            if ($subcat == 5)
                $valueName = 'Приключенческий';
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
                $rate["sortField"] = $rate[$this->subcat_num_to_internalName($subcat)];
            }

            usort($rates, function ($a, $b) {
                if ($a['sortField'] == $b['sortField']) {
                    return 0;
                }
                return ($a["sortField"] < $b["sortField"]) ? 1 : -1;
            });
        }

    }
