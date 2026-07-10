<?php

class ResultsReferee2016 {

    function show() {

        $zayavka_Info_Url = 'archive/participant-2016.html';
        $YEAR_TAG = '2016';
        $zayavka = new Zayavka2016;

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

        $rates = $this->getRefereeRates($class);
        $this->sortRates($subcat, $rates);

// Заголовок страницы
        ?>
        <div style="padding: 10px; margin: 10px; width: 900px; background-color:#FFFFD7; font-size:16px; font-weight:bold">
            номинация: <?= $nomination_name ?>
            <?= !empty($class) ? ", класс: $class" : '' ?>
        </div>
        <table width="100%"  border="0" cellspacing="2" cellpadding="0">

            <?php
            $zayavkaList = new zayavkaList($zayavka);
            $zayavkaView = new ZayavkaView();

            $zayavkaView->headerType1_refResults('Средняя оценка/Кол-во оценок');

            $place = 1;
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
                $resultRate = $rate['sortField'];
                $resultRateCount = $rate[$this->subcat_num_to_internalName($subcat) . 'Count'];
                $zayavka->data = $zayavkaList->list[0];
                $zayavkaView->setData($zayavka, $zayavka_Info_Url);
// выводим очередную строку таблицы
                ?> <tr> <?php
                    print_rate($place); // занятое походом место
                    $zayavkaView->column1();
                    $zayavkaView->column2();
                    $zayavkaView->column3();
                    print_rates(Array($resultRate ? sprintf("%.2f", $resultRate) : '-', $resultRateCount));
                    ?> </tr>
                <?php
                $zayavkaView->hr();
// записываем в библиотеку походов судейские оценки и места занятые походом
                //AppendRateAndPlaceToLibrary_2016($place, $cat, $subcat, $id_z);
                $place++;
            }
            echo "</table>";
            return;
        }

        private function count_rate_sum($cur_rate, $rate_sum, $rate_count, $rate_min, $rate_max) {
// подсчет суммы и количества учтенных оценок, и их макс и мин.значения
            if ($cur_rate !== '-') {// пропускаем воздержавшихся
                $rate_sum += $cur_rate;
                $rate_count++;
                $rate_min = ($rate_min > $cur_rate) ? $cur_rate : $rate_min;
                $rate_max = ($rate_max < $cur_rate) ? $cur_rate : $rate_max;
            }
            return array($rate_sum, $rate_count, $rate_min, $rate_max);
        }

        private function calc_result_avg_rate($rate_sum, $rate_count, $rate_min, $rate_max) {
            $rate_sum -= $rate_min;
            $rate_count--;
            $rate_sum -= $rate_max;
            $rate_count--;
            if ($rate_count <= 0) {
                $rate_count = 1;
            }
            return $rate_sum / $rate_count;
        }

        private function cat_num_to_class($cat) {
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

        private function subcat_num_to_name($subcat) {
            switch ($subcat) {
                case 1: $nomination = "Сложность";
                    $id = "hard";
                    break;
                case 2: $nomination = "Маршрут/Организация";
                    $id = "original";
                    break;
                case 3: $nomination = "Отчёт";
                    $id = "report";
                    break;
                case 4: $nomination = "Лучший поход 2016";
                    $id = "";
                    break;
                default: $nomination = "";
                    $id = "";
                    break;
            }
            return Array($nomination, $id);
        }

        private function subcat_num_to_internalName($subcat) {
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

        private function getRefereeRates($class) {
            $ref_voting_db_name = 'way_voting_referee_2016';
            $db_table_name = 'way2016';

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

        private function sortRates($subcat, &$rates) {
            if (!$subcat) {
                return;
            }
            foreach ($rates as &$rate) {
                $rate["sortField"] = null;
                if ($subcat == 1) {
                    $rate["sortField"] = $rate["diff"];
                } elseif ($subcat == 2) {
                    $rate["sortField"] = $rate["org"];
                } elseif ($subcat == 3) {
                    $rate["sortField"] = $rate["otch"];
                } elseif ($subcat == 4) {
                    $rate["sortField"] = $rate["rates_sum"];
                }
            }

            function sort_func($a, $b) {
                if ($a['sortField'] == $b['sortField']) {
                    return 0;
                }
                return ($a["sortField"] < $b["sortField"]) ? 1 : -1;
            }

            usort($rates, sort_func);
        }

    }
