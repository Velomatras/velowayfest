<?php

// config constants
$PRINT_DEBUG_LOGS = 1;
//define(RESULTS_ONLY_MODE, true);
//define(COOKIE_NAME, 'sukas');

//require_once 'manager/includes/connection.php';
require_once '_utils/upload_img.php';
require_once '_utils/loginConnect.php';
//require_once '_utils/bookmark.php';
require_once '_utils/crud.php';
require_once '_utils/periods_work.php';
require_once '_utils/regions_work.php';
require_once '_utils/sql_queries.php';
require_once '_utils/gui.php';
require_once '_utils/modx.php';
require_once '_utils/BaseWay.php';
require_once '_utils/logger/logger.php';

require_once '_utils/data/rates/addnominations/AddNominationRate.php';
require_once '_utils/data/rates/addnominations/AddNominationRateQuote.php';
require_once '_utils/data/rates/addnominations/AddNominationRate2016.php';
require_once '_utils/data/rates/addnominations/AddNominationRate2017.php';
require_once '_utils/data/rates/addnominations/AddNominationRate2018.php';
require_once '_utils/data/rates/addnominations/AddNominationRate2019.php';
require_once '_utils/data/rates/addnominations/AddNominationRate2019_2.php';
require_once '_utils/data/rates/addnominations/AddNominationRate2020.php';
require_once '_utils/data/rates/addnominations/AddNominationRate2020_2.php';
require_once '_utils/data/rates/addnominations/AddNominationRate2021.php';
require_once '_utils/data/rates/addnominations/AddNominationRate2021_2.php';
require_once '_utils/data/rates/addnominations/AddNominationPik2021.php';
require_once '_utils/data/rates/addnominations/AddNominationRate2022.php';
require_once '_utils/data/rates/addnominations/AddNominationRate2022_2.php';
require_once '_utils/data/rates/addnominations/AddNominationRate2023.php';
require_once '_utils/data/rates/addnominations/AddNominationRate2023_2.php';
require_once '_utils/data/rates/addnominations/AddNominationRate2024.php';
require_once '_utils/data/rates/addnominations/AddNominationRate2024_2.php';
require_once '_utils/data/ZayavkaStatus.php';

require_once '_utils/data/pohod/pohod.php';
require_once '_utils/data/pohod/zayavka.php';
require_once '_utils/data/pohod/zayavka2015.php';
require_once '_utils/data/pohod/zayavka2016.php';
require_once '_utils/data/pohod/zayavka2017.php';
require_once '_utils/data/pohod/zayavka2018.php';
require_once '_utils/data/pohod/zayavka2019.php';
require_once '_utils/data/pohod/zayavka2020.php';
require_once '_utils/data/pohod/zayavka2021.php';
require_once '_utils/data/pohod/zayavka2022.php';
require_once '_utils/data/pohod/zayavka2023.php';
require_once '_utils/data/pohod/zayavka2024.php';
require_once '_utils/data/pohod/zayavkaLibrary.php';
require_once '_utils/data/pohod/library_entry.php';
require_once '_utils/data/pohod/library_temp_entry.php';

require_once '_utils/data/pohod/list/ZayavkaList.php';
require_once '_utils/data/pohod/list/ZayavkaPhotosList.php';
require_once '_utils/data/pohod/list/ZayavkaPhotosList2.php';
require_once '_utils/data/pohod/list/ZayavkaPik99List.php';
require_once '_utils/data/pohod/list/ZayavkaQuoteList.php';

require_once '_utils/views/pohod/ZayavkaView.php';
require_once '_utils/views/pohod/ZayavkaPhotosView.php';
require_once '_utils/views/pohod/ZayavkaQuotesView.php';
require_once '_utils/views/ZayavkaEditor.php';
require_once '_utils/views/LibEntryEditor.php';

require_once '_utils/views/2016/Results2016.php';
require_once '_utils/views/2016/ResultsReferee2016.php';
require_once '_utils/views/2016/ResultsExperts2016.php';

require_once '_utils/views/2017/Results2017.php';
require_once '_utils/views/2017/ResultsReferee2017.php';
require_once '_utils/views/2017/ResultsExperts2017.php';

require_once '_utils/views/2018/ResultsReferee2018.php';
require_once '_utils/views/2018/ResultsExperts2018.php';
require_once '_utils/views/2018/Results2018.php';
require_once '_utils/views/2018/ZayavkaEditor2018.php';

require_once '_utils/views/2019/ResultsReferee2019.php';
require_once '_utils/views/2019/ResultsExperts2019.php';
require_once '_utils/views/2019/Results2019.php';
require_once '_utils/views/2019/ResultsBestPohod2019.php';
require_once '_utils/views/2019/ResultsDebut2019.php';
require_once '_utils/views/2019/ZayavkaEditor2019.php';

require_once '_utils/views/2020/ResultsReferee2020.php';
require_once '_utils/views/2020/ResultsExperts2020.php';
require_once '_utils/views/2020/Results2020.php';
require_once '_utils/views/2020/ResultsBestPohod2020.php';
require_once '_utils/views/2020/ResultsDebut2020.php';
require_once '_utils/views/2020/ZayavkaEditor2020.php';

require_once '_utils/views/2021/ResultsReferee2021.php';
require_once '_utils/views/2021/ResultsExperts2021.php';
require_once '_utils/views/2021/Results2021.php';
require_once '_utils/views/2021/ResultsBestPohod2021.php';
//require_once '_utils/views/2021/ResultsDebut2021.php';
require_once '_utils/views/2021/ZayavkaEditor2021.php';

require_once '_utils/views/2022/ZayavkaEditor2022.php';
require_once '_utils/views/2022/ResultsReferee2022.php';
require_once '_utils/views/2022/ResultsExperts2022.php';
require_once '_utils/views/2022/Results2022.php';
require_once '_utils/views/2022/ResultsBestPohod2022.php';
require_once '_utils/views/2022/ResultsDebut2022.php';

require_once '_utils/views/2023/ZayavkaEditor2023.php';
require_once '_utils/views/2023/ResultsReferee2023.php';
require_once '_utils/views/2023/ResultsExperts2023.php';
require_once '_utils/views/2023/Results2023.php';
require_once '_utils/views/2023/ResultsBestPohod2023.php';
require_once '_utils/views/2023/ResultsDebut2023.php';
require_once '_utils/views/2023/ResultsPVD2023.php';
require_once '_utils/views/2023/ResultsClassKPohod2023.php';
require_once '_utils/views/2023/ResultsClassPohod2023.php';
require_once '_utils/views/2023/ResultsClassDPohod2023.php';

require_once '_utils/views/2024/ZayavkaEditor2024.php';
require_once '_utils/views/2024/ResultsReferee2024.php';
require_once '_utils/views/2024/ResultsExperts2024.php';
require_once '_utils/views/2024/Results2024.php';
require_once '_utils/views/2024/ResultsBestPohod2024.php';
require_once '_utils/views/2024/ResultsDebut2024.php';
require_once '_utils/views/2024/ResultsPVD2024.php';
require_once '_utils/views/2024/ResultsClassKPohod2024.php';
require_once '_utils/views/2024/ResultsClassPohod2024.php';
require_once '_utils/views/2024/ResultsClassDPohod2024.php';

//$connect = new connection();
$ucon = new loginConnect();
$mysqli = $ucon->getMysqli();
//$mysqli = $connect->getConnect();


//******************************************************************
function get_db_rows_num($db_table_name) {
    $result = mysql_query("SELECT COUNT(*) AS rows_num FROM $db_table_name");
    $data = mysql_fetch_assoc($result);
    $rows_num = $data['rows_num'];
    return $rows_num;
}

function db_enum_values_to_array($table, $field) {
    $q = "SHOW FIELDS FROM $table LIKE '$field'";
    printDebugLog($q);
    $result = mysql_query($q);
    $row = mysql_fetch_array($result);
    printDebugLog($row);
    preg_match('#^enum\((.*?)\)$#ism', $row['Type'], $matches);
    $enum = str_getcsv($matches[1], ",", "'");
    return $enum;
}

function dbAppendPlaceToLib($place, $category, $dbTableName, $fieldName, $searchСondition, $debugMode = true) {
// записываем в библиотеку походов места занятые походом - в поле $fieldName, в виде строки в формате JSON
    $result = mysql_query("SELECT $fieldName FROM $dbTableName WHERE $searchСondition");
    $data = mysql_fetch_assoc($result);
    $places = json_decode($data["$fieldName"], true);
    if (!is_array($places))
        $places = array();
    $places[$category] = $place;
    $s = json_encode($places, JSON_NUMERIC_CHECK);
    //$s = str_replace('"', '', $s);	// чтобы индексы массива были заданы в виде чисел, а не в виде строк
    $s = mysql_real_escape_string($s);
    $q = "UPDATE $dbTableName SET $fieldName=\"$s\" WHERE $searchСondition";
    echo $q;
    if (!$debugMode) // страховка, чтобы ненароком не записали в рабочую БД неотлаженные оценки
        $result = mysql_query($q);
    else
        echo '<br><b>!!! debug mode !!!</b>';
}

function calc_comments($application_num, $application_year, $author_comment = '') {
// считает количество комментариев к походу
    $comm = 0;
    if ($author_comment !== '')
        $comm++;   // учитываем также авторский комментарий

    $result2 = mysql_query("SELECT COUNT(uparent) FROM jot_content WHERE uparent = $application_num AND tagid = $application_year");
    if (!$result2)
        return $comm;

    for ($t = 0; $t < mysql_num_rows($result2); $t++) {
        $array2 = mysql_fetch_array($result2);
        $comm = $array2[0];
    }
    return $comm;
}

function printAuthorComment($comment) {
    if ($comment === '') { return; }
    echo '<div class="content"><h4>Авторский комментарий:</h4><br>' . nl2br(htmlspecialchars($comment)) . '</div>';
}

function get_value_units_text($value, $text_form1, $text_form2, $text_form3) {
// выбрать название величины в правильном падеже
    if (!isset($value))
        return '';
    if (($value > 4) and ( $value < 21))
        return $text_form3;
    else {
        $rem = $value % 10;
        if ($rem === 1)
            return $text_form1;
        elseif (($rem > 1) and ( $rem < 5))
            return $text_form2;
        else
            return $text_form3;
    }
}

function out_track_links($tracks_links_str) {
// Вывести ссылки на трек
// IN: $tracks_links_str - ссылки, упакованные в одну строке
// OUT: строка с HTML-ссылками
    $s = '';
    if (empty($tracks_links_str))
        return $s;
    $track_links = DBDataWork::unpackArray($tracks_links_str);
	    if (sizeof($track_links) > 0) {
        $s.='<br><br>Ссылка на трек (авторская): ';
        for ($i = 0; $i < (sizeof($track_links)); $i++)
            if (!empty($track_links[$i]))
                $s.='<a href=" ' . htmlspecialchars($track_links[$i]) . ' " target="_blank">' . ($i + 1) . '</a>&nbsp';
    }
    return $s;
}

function out_cover_image($pic_upload_flg, $pics_on_server_path, $application_num, $pic_url = '', $pic_alt = '', $pic_comment = '') {
// выводим заглавную фотографию похода
// указываем кодировку
    mb_internal_encoding("UTF-8");
// обрезаем alt для фотографии - до 60 символов
    $pic_alt = mb_substr($pic_alt, 0, 60) . "...";
    if ($pic_upload_flg) {
		
        $picUploadThumb = $pics_on_server_path . '/thumb/' . $application_num . '.jpg';
        $picUploadOrig = $pics_on_server_path . '/orig/' . $application_num . '.jpg';
        echo '<br/><a data-lightbox="image-' . $application_num . '"
		data-title="' . htmlspecialchars($pic_comment) . '" href="' . $picUploadOrig . '">
		<img src="' . $picUploadThumb . '"  width="150px" class = "thumbnail" /></a>';
        echo '<script type="text/javascript">	// maintain the same size of horizontal and vertical images
			$( ".thumbnail" ).load(function() {
				if ( $( this ).height() > $( this ).width()) {
				$( this ).width("100px");
			} });
		</script>';
    } else
        echo "<img src=\"$pic_url\" width=\"150px\" alt=\"$pic_alt\">";
}

function out_column_1($application_num, $pics_on_server_path, $pic_upload_flg, $pic_url = '', $pic_alt = '', $pic_comment = '') {
// выводим 1-ю колонку таблицы походов
// $pic_upload_flg - флаг - загружена ли фотография на сервер
// $pics_on_server_path - путь к папке с фотографиями, загруженными на сервер
// $application_num - номер заявки похода
// $pic_url - путь к фотографии, не загруженной на сервер
// $pic_alt - ALT-тэг к фотографии
// $pic_comment - подпись к фотографии
// выводим номер заявки
    $zayavkaTest = new ZayavkaView(); 
   $color_row = $zayavkaTest->getColorRow(); 
  
  // получаем цвет ячеек таблицы заявок
    echo "<td valign=\"top\" bgcolor=\"" . $color_row ."\" border=\"0\" align=\"center\" ><b>$application_num</b><br>";
// выводим заглавную фотографию похода
    out_cover_image($pic_upload_flg, $pics_on_server_path, $application_num, $pic_url, $pic_alt, $pic_comment);
    echo "</td>";
}

function out_column_1_lib($application_num, $pics_on_server_path, $pic_upload_flg,  $year, $pic_url = '', $pic_alt = '', $pic_comment = '') {
// выводим 1-ю колонку таблицы походов для библиотеки и личного кабинета
// $pic_upload_flg - флаг - загружена ли фотография на сервер
// $pics_on_server_path - путь к папке с фотографиями, загруженными на сервер
// $application_num - номер заявки похода
// $pic_url - путь к фотографии, не загруженной на сервер
// $pic_alt - ALT-тэг к фотографии
// $pic_comment - подпись к фотографии
// выводим номер заявки
    echo '<td valign="top"><b>' . $application_num . '_'.$year. 'г.</b><br>';
// выводим заглавную фотографию похода
    out_cover_image($pic_upload_flg, $pics_on_server_path, $application_num, $pic_url, $pic_alt, $pic_comment);
    echo "</td>";
}

function print_rate($rate, $isHighlighted = false) {
    ?> <td align="center"><span class="<?= $isHighlighted ? 'rates_higlighted_text' : 'rates_text'?>"><?= $rate ?> </span></td>
        <?php
}

function print_rate_red($rate, $isHighlighted = false) {
    ?> <td align="center"><span style="color: red" class="<?= $isHighlighted ? 'rates_higlighted_text' : 'rates_text'?>"><?= $rate ?> </span></td>
        <?php
}

function print_rates($rates, $highlighted_rate_num = 0, $dedicatedTD = false) {
    if (!$dedicatedTD) { ?>
        <td align="center">
    <?php }

    $i = 1;
    foreach ($rates as $rate) {
        $class = ($i == $highlighted_rate_num) ? 'rates_higlighted_text' : 'rates_text';
        if (!$dedicatedTD)
            echo '<span class="'.$class.'">'.$rate.'&nbsp&nbsp&nbsp</span>';
        else { ?>
            <td  align="center">
                <span class="<?= $class ?>"><?= $rate ?>&nbsp&nbsp&nbsp</span>
            </td>
        <?php }
        $i++;
    }
    if (!$dedicatedTD) echo'</td>';
}

// 1 - Самый сложный поход, 2 - Лучший маршрут, 3 - Лучший отчет, 4 - Приз зрительских симпатий
// 5 - Самый интересный поход, 6 - Самый необычный поход, 7 - Лучший маршрут, 8 - Лучшие велоэкскурсии, 9 - Лучшая организация и проведение похода
// 10 - Самый оригинальный поход, 11 - Наиболее познавательный велопоход, 12 - Лучшее видео, 13 - Самый автономный поход,
// 14 - Лучший поход
// 15 - Самый познавательный маршрут
// 16 - Лучший велопоход с детьми
// 17 - Самый "удачный" велопоход (Осторожнее вноси, кавычки!)
// 18 - Самый приключенческий велопоход
// 19 - Самый увлекательный отчёт
// 20 - Лучшая походная фотография
// 21 - Самый продолжительный маршрут
// 22 - Самый длинный маршрут
// 23 - Самый скоростной поход
// 24 - Лучший поход Года
// 25 - Лучший дебютант Фестиваля
// 26 - Лучшая цитата Велопути
// 27 - Лучший фильм
// 28 - Гран при Фестиваля
// 29 - Фотоконкурс Снаряжение
// 30 - Фотоконкурс ПИК-99
// 31 - Самый массовый велопоход
// 32 - Фотоконкурс: пейзаж
// 33 - Фотоконкурс: одинокий велосипед
// 34 - Лучший ПВД
// 35 - Самый зимний поход
// 36 - Лучшая лекция

function library_get_nomination_name($cat_num) {
    $cat_names = array('', 'Самый сложный поход', 'Лучший маршрут', 'Лучший отчет', 'Приз зрительских симпатий',
        'Самый интересный поход', 'Самый необычный поход', 'Лучший маршрут', 'Лучшие велоэкскурсии', 'Лучшая организация похода', 'Самый оригинальный поход',
        'Наиболее познавательный велопоход', 'Лучшее видео', 'Самый автономный поход', 'Лучший поход',
        'Самый познавательный маршрут', 'Лучший велопоход с детьми', 'Самый удачный велопоход', 'Самый приключенческий велопоход', 'Самый увлекательный отчёт',
        'Лучшая походная фотография', 'Самый продолжительный маршрут', 'Самый длинный маршрут', 'Самый скоростной поход', 'Лучший поход Года', 'Лучший дебют',
		'Лучшая цитата', 'Лучший фильм', 'Гран-При Фестиваля','Фотоконкурс Снаряжение','Фотоконкурс ПИК-99','Самый массовый велопоход','Фотоконкурс: пейзаж',
		'Фотоконкурс: одинокий велосипед','Лучший ПВД','Самый зимний поход','Лучшая лекция' );
    return $cat_names[$cat_num];
}

//Вывод значков наград для библиотеки и ЛК
function print_winner_result2($results_str, $year, $pohodData = NULL) {
    if ($results_str == '')
        return;
    $places = json_decode($results_str, true);
	$count = 0;
    foreach ($places as $category => $result) {
        $nomination_name = library_get_nomination_name($category);
        if (($category == 12) && isset($pohodData['video_url'])) {
            // для победителей в категории видео, значок - ссылка на видео
            echo '<a href="' . $pohodData['video_url'] . '" target="_blank">';
            $isLink = true;
        }
        if (($category == 3) && isset($pohodData['link']) && $pohodData['pohod_status'] != 2) {
            // для победителей в категории "отчет", значок - ссылка на отчет, если, конечно, он доступен
            echo '<a href="' . $pohodData['link'] . '" target="_blank">';
            $isLink = true;
        } else if ($isLink) $isLink = true;
			else $isLink = false;
        print_winner_result($result, $nomination_name, $year, $count);
        if ($isLink)
            echo '</a>';
		$count++;
    }
	echo "</table>";
}

function print_winner_result($result, $nomination_name, $year, $count) {
    $nomination_name_with_year = $nomination_name . '-' . "&nbsp;" . $year;
	if ($count == 0) echo "<table>";
    if (($result > 0) and ( $result < 6)) {
        //echo '<div class="results_img"><figure>';
		echo '<figure>';
		if ((fmod($count, 3) == 0) || $count == 0) echo "<tr>";
        echo '<td><img src="assets/templates/veloway/images/' . $result . 'place_icon.png" alt="' . $nomination_name_with_year . '"
		title="' . $nomination_name_with_year . '">';
		echo "<figcaption><b>" . $nomination_name . "</b>" . '-' . "&nbsp;" . $year ."</figcaption>";
		echo "</figure>";
		echo "</td>";
		if ((fmod($count, 3) == 0) || $count == 0) echo "</tr>";
        //
        
    }
}

function print_pohod_status_label($status) {
    return $status != LibraryEntry::OTCHET_LINK_BAD_STATUS ? '' : '<img src="assets/templates/veloway/images/linknotwork.gif" alt="Ссылка на отчет не работает!" title="Ссылка на отчет не работает!">';
}

// ************************************ голосование Финала ***********************************************************************

function out_vote_selector($name, $data_name, $max_index, $selected_item = 0, $isEnabled = true, $itemId = '', $itemClass='') {
// вывести выпадающий список выбора баллов - от 1 до $max_index
// $name - имя поля ввода
// $name - имя поля данных
// $max_index - максимальный балл
// ранее выбранный балл (будет в списке выделенным по умолчанию)
    ?>
    <?= $name ?>:
    <select id="<?= $itemId ?>" name="<?= $data_name ?>" <?= !empty($itemClass) ? 'class="'.$itemClass.'"' : '' ?> "eform="::0::#EVAL return true >
    <option value="-">---</option>
    <?php
    for ($i = 1; $i < $max_index + 1; $i++) {
        $selectedAttr = ($i == $selected_item) ? ' selected="selected" ' : '';
        $enabledAttr = $isEnabled ? '' : ' disabled="disabled" ';
        echo "<option value=\"$i\" $selectedAttr $enabledAttr>$i</option>";
    } ?>
    </select>
<?php
    if (!$isEnabled) { // задизабленный Select при субмите не возвращает значения, поэтому делаем hidden элемент ввода с тем же названием и пустым значением  ?>
        <input type="hidden" name="<?=$data_name?>" value='-'>
    <?php }
}

// ************************************ голосование Финала в номинации Цитата ***********************************************************************

function out_vote_selectorQuote($name, $data_name, $max_index, $selected_item = 0, $isEnabled = true, $itemId = '', $itemClass='') {
// вывести выпадающий список выбора баллов - от 1 до $max_index
// $name - имя поля ввода
// $name - имя поля данных
// $max_index - максимальный балл
// ранее выбранный балл (будет в списке выделенным по умолчанию)
    ?>
    <?= $name ?>:
    <select id="<?= $itemId ?>" name="<?= $data_name ?>" <?= !empty($itemClass) ? 'class="'.$itemClass.'"' : '' ?> "eform="::0::#EVAL return true >
    <option value="-">---</option>
    <?php
    for ($i = 1; $i < $max_index + 1; $i++) {
        if ($i >= 1 && $i <= 5){ $selectedAttr = ($i == $selected_item) ? ' selected="selected" ' : '';
        $enabledAttr = $isEnabled ? '' : ' disabled="disabled" ';
        echo "<option value=\"$i\" $selectedAttr $enabledAttr>$i</option>";
		}
    } ?>
    </select>
<?php
    if (!$isEnabled) { // задизабленный Select при субмите не возвращает значения, поэтому делаем hidden элемент ввода с тем же названием и пустым значением  ?>
        <input type="hidden" name="<?=$data_name?>" value='-'>
    <?php }
}

// ************************************* голосование Отбора 2019г *********************************************************************************

function out_vote_selector_qualification($name, $data_name, $max_index, $selected_item = 0, $isEnabled = true, $itemId = '', $itemClass='') {
// вывести выпадающий список выбора баллов - от 1 до $max_index
// $name - имя поля ввода
// $name - имя поля данных
// $max_index - максимальный балл
// ранее выбранный балл (будет в списке выделенным по умолчанию)
    ?>
    <?= $name ?>:
    <select id="<?= $itemId ?>" name="<?= $data_name ?>" <?= !empty($itemClass) ? 'class="'.$itemClass.'"' : '' ?> "eform="::0::#EVAL return true >
    <option value="-">---</option>
    <?php
    for ($i = 1; $i < $max_index + 1; $i++) {
        if ($i == 3 || $i == 6 || $i == 10){ $selectedAttr = ($i == $selected_item) ? ' selected="selected" ' : '';
        $enabledAttr = $isEnabled ? '' : ' disabled="disabled" ';
        echo "<option value=\"$i\" $selectedAttr $enabledAttr>$i</option>";
		}
    } ?>
    </select>
<?php
    if (!$isEnabled) { // задизабленный Select при субмите не возвращает значения, поэтому делаем hidden элемент ввода с тем же названием и пустым значением  ?>
        <input type="hidden" name="<?=$data_name?>" value='-'>
    <?php }
}

// ********************************* голосование Отбора 2020г и более поздних *******************************************************************

function out_vote_selector_qualification2($name, $data_name, $max_index, $selected_item = 0, $isEnabled = true, $itemId = '', $itemClass='') {
// вывести выпадающий список выбора баллов - от 1 до $max_index
// $name - имя поля ввода
// $name - имя поля данных
// $max_index - максимальный балл
// ранее выбранный балл (будет в списке выделенным по умолчанию)
    ?>
    <?= $name ?>:
    <select id="<?= $itemId ?>" name="<?= $data_name ?>" <?= !empty($itemClass) ? 'class="'.$itemClass.'"' : '' ?> "eform="::0::#EVAL return true >
    <option value="-">---</option>
    <?php
	$title;
	
    for ($i = 1; $i < $max_index + 1; $i++) {
                if ($i == 1 || $i == 4 || $i == 7 || $i == 10){ 
				$selectedAttr = ($i == $selected_item) ? ' selected="selected" ' : '';
				$enabledAttr = $isEnabled ? '' : ' disabled="disabled" ';
				if ($i == 1) $title = "(однозначно НЕ в Финал!)";
		if ($i == 4) $title = "(скорее НЕ в Финал)";
		if ($i == 7) $title = "(скорее в Финал)";
		if ($i == 10) $title = "(однозначно в ФИНАЛ!)";
        echo "<option value=\"$i\" $selectedAttr $enabledAttr>$i $title</option>";
				}
				             } ?>
    </select>
<?php
    if (!$isEnabled) { // задизабленный Select при субмите не возвращает значения, поэтому делаем hidden элемент ввода с тем же названием и пустым значением  ?>
        <input type="hidden" name="<?=$data_name?>" value='-'>
    <?php }
}

// ***************************************** голосование Отбора в номинации "Лучшая Цитата ВелоПути" *********************************************

function out_vote_selector_qualificationQuote($name, $data_name, $max_index, $selected_item = 0, $isEnabled = true, $itemId = '', $itemClass='') {
// вывести выпадающий список выбора баллов - от 1 до $max_index
// $name - имя поля ввода
// $name - имя поля данных
// $max_index - максимальный балл
// ранее выбранный балл (будет в списке выделенным по умолчанию)
    ?>
    <?= $name ?>:
    <select id="<?= $itemId ?>" name="<?= $data_name ?>" <?= !empty($itemClass) ? 'class="'.$itemClass.'"' : '' ?> "eform="::0::#EVAL return true >
    <option value="-">---</option>
    <?php
	$title;
	
    for ($i = 1; $i < $max_index + 1; $i++) {
                if ($i == 1 || $i == 2 || $i == 3 || $i == 4){ 
				$selectedAttr = ($i == $selected_item) ? ' selected="selected" ' : '';
				$enabledAttr = $isEnabled ? '' : ' disabled="disabled" ';
				if ($i == 1) $title = "(однозначно НЕ в Финал!)";
		if ($i == 2) $title = "(скорее НЕ в Финал)";
		if ($i == 3) $title = "(скорее в Финал)";
		if ($i == 4) $title = "(однозначно в ФИНАЛ!)";
        echo "<option value=\"$i\" $selectedAttr $enabledAttr>$i $title</option>";
				}
				             } ?>
    </select>
<?php
    if (!$isEnabled) { // задизабленный Select при субмите не возвращает значения, поэтому делаем hidden элемент ввода с тем же названием и пустым значением  ?>
        <input type="hidden" name="<?=$data_name?>" value='-'>
    <?php }
}

//*************************Функция для конвертации английских названий номинаций в русские*******************************************
  
  function nominationsRus ($nomRus){
	  	 $nomSearch = array("hard", "original", "report", "quote", "exciting", "informative", "autonome", "unusual", 
	"children", "unfortun", "video", "movie", "debut", "pik99", "snar", "photo", "winter", "lecture");
	     $nomReplace = array("сложность", "маршрут", "отчёт", "цитата", "увлекательность", "познавательность", "автономность", "необычность",
    "дети", "приключения", "видеоролик", "фильм", "дебют", "фото ПИК-99", "фото Снаряжение", "фотоконкурс", "зимний", "лекция" );
	      $nomR = str_replace($nomSearch, $nomReplace, $nomRus);
    
return 	$nomR;	
  }

function printCAPTCHA() { // Капча
    echo '<p align="right"><img src="[+verimageurl+]" alt="Код проверки" border="1" align="left"/>
	&nbsp;&nbsp;Введите код:&nbsp;&nbsp;<input type="text" class="vericodeform" name="vericode" /></p>';
}

function fixRoute($routeStr) {
// у некоторых отчетов в строке маршрута - дефис или тире, а не минус - исправляем
    $routeStr = str_replace('–', '-', $routeStr);
    $routeStr = str_replace('—', '-', $routeStr);
    $routeStr = preg_replace('/  /', ' ', $routeStr); // убираем двойные пробелы
    //$routeStr = str_replace(' - ','-',$routeStr);
    //$routeStr = preg_replace('/\S-\S/', ' - ', $routeStr);	// дефисы без пробелом - на дефисы с пробелами (а как же "Гусь-Хрустальный"?)
    return $routeStr;
}

class DBDataWork {

    const OLD_DIVIDER = "\n";
    const NEW_DIVIDER = "~~";

    static public function packArray($array) {
        if (!is_array($array))
            return '';
        $s = '';
        foreach ($array as $item) {
            if (!empty($item))
                $s.= $item . self::NEW_DIVIDER;
        } //implode("\n", $array)
        $s = StringsWork::delLastSym($s, strlen(self::NEW_DIVIDER)); // del last divider
        return $s;
    }

    static public function unpackArray($packedStr) {
        if (empty($packedStr)) {
            return Array();
        }
        $result = explode(self::NEW_DIVIDER, $packedStr);
        if (count($result) < 2 ){
            $result = explode(self::OLD_DIVIDER, $packedStr);
        }

        return $result;
    }

}

class ParamsWork {
	
    static public function sanitizeSQLStr($s) {
		global $mysqli;
        return mysqli_real_escape_string($mysqli, htmlspecialchars(trim($s)));
    }

    static public function sanitizeInt($n) {
        return intval($n);
    }

}

class FileWork {

    static private function getRootURL() {
        /*
          $port      = $_SERVER['SERVER_PORT'];
          $disp_port = ($protocol == 'http' && $port == 80 || $protocol == 'https' && $port == 443) ? '' : ":$port"; */
        $protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
        $domain = $_SERVER['SERVER_NAME'];
        $full_url = "$protocol://$domain}";
        return $full_url;
    }

    static public function appendServerRootFolder($path) {
        $appendPath = $_SERVER["DOCUMENT_ROOT"];
        if (strpos($path, $appendPath) === false)
            $path = $appendPath . $path;
        return $path;
    }

    static public function appendServerWWWRootFolder($path) {
        $appendPath = self::getRootURL();
        if (strpos($path, $appendPath) === false)
            $path = $appendPath . $path;
        return $path;
    }

    static public function delServerRootFolder($path) {
        $pos = strpos($path, $_SERVER["DOCUMENT_ROOT"]);
        if ($pos !== false)
            $path = substr($path, $pos);
        return $path;
    }

    static public function findFiles($pattern, $path) {
        $path = FileWork::appendServerRootFolder($path);
        return glob($path . $pattern);
    }

    static public function getWWWPath($pathOnServer) {
        $path = FileWork::appendServerWWWRootFolder($pathOnServer);
        return glob($path . $pattern);
    }

}

class StringsWork {

    static public function delLastSym(&$s, $symsToDelNum = 1) {
        return substr($s, 0, -$symsToDelNum);
    }

    static public function getSubstrTillTheSym($s, $symToFind) {
        $pos = strpos($s, $symToFind);
        return $pos ? substr($s, 0, $pos) : $s;
    }

}

class URLWork {

    static public function goURL($url) {
        echo("<script>location.href = '$url'</script>");
    }

    static public function getCurURL() {
        return $_SERVER['REQUEST_URI'];
    }

    static public function getCurURLNoParams() {
        $current_url = explode("?", $_SERVER['REQUEST_URI']);
        return $current_url[0]; // only url, withou paramethers
    }

    static public function setСookie($name, $value, $liveSpanInDays) {
        setcookie($name, $value, time() + $liveSpanInDays * 24 * 60 * 60, '/', $_SERVER['HTTP_HOST']);
    }

}

class ArrayWork {

    static private function random($maxValue) {
        return rand(0, $maxValue);
    }

    static public function shuffle(&$a, $seed = null) {
// To shuffle an array a of n elements (indices 0..n-1):
        srand($seed);
        $n = count($a);
        for ($i = 0; $i < $n; $i++) {
            $j        = self::random($n - $i - 1);
            $tmp      = $a[$i];
            $a[$i]    = $a[$i + $j];
            $a[$i + $j] = $tmp;
        }
    }

}

//Функция получения массива кодов закладок
function bookmark ($book){
$mark = explode("," , $book);
return $mark;
}

//обратная функция получения строчного представления массива
//function markbook ($trip_id, $mark){

//	foreach ($mark as $row => $result ){
//	$book ="";
//    if ($trip_id != $result && isset($book))	$book = "$book" . "," . "$result";	
//	if ($trip_id != $result && empty($book))	$book = $result;
	
//	}
//	return $book;
//}

//функция добавления новой закладки
function addMark ($trip_id, $book, $userId, $mysqli, $db_table_name){
	
	//проверка существования отчёта в библиотеке
if (empty($trip_id)) return 0;

    //проверка не добавляется ли отчёт повторно
$mark = bookmark ($book);
$unicum = unicumMark ($trip_id, $mark);
if ($unicum == false) return 0;	

if (!empty($book)) $newBook = "$book,$trip_id";
else $newBook = $trip_id;
//$newBook = $mysqli->real_escape_string($newBook);

$q3 = "UPDATE $db_table_name SET bookmarks = \"$newBook\" WHERE id = \"$userId\"";
//$q3 = "UPDATE '$db_table_name' SET bookmarks = '$newBook' WHERE id = '$userId'";
$mysqli->query($q3);

return 1;
}

//функция удаления всех закладок
function delMarkAll ($userId, $mysqli, $db_table_name){
	
$q4 = "UPDATE $db_table_name SET bookmarks = '' WHERE id = \"$userId\"";
$text = $mysqli->query($q4);

if ($text === true) $text = "<br>закладки успешно удалены!";
else $text = "<br>запрос не выполнен!!";
return $text;	
}

//функция удаления одной закладки
function delMark ($trip_id, $book, $userId, $mysqli, $db_table_name){
	
	//проверка существования отчёта в библиотеке
if (empty($trip_id)) return 0;

$mark = bookmark ($book);
$newBook = '';
foreach ($mark as $row){
	if ($row == $trip_id) continue;
	if (!empty($newBook)) $newBook .= "," . $row ;
	else $newBook = $row ;
	}
//$newBook = markbook ($trip_id, $mark)
	
$q = "UPDATE $db_table_name SET bookmarks = \"$newBook\" WHERE id = \"$userId\"";
$text = $mysqli->query($q);

if ($text === true) $text = "<br>закладка успешно удалена!";
else $text = "<br>запрос не выполнен!!";
return $text;	
}

//функция проверки уникальности закладки
function unicumMark ($trip_id, $mark){
 foreach ($mark as $row){
	 if ($row == $trip_id) return false;
 }
 return true;
}  	

//функция подсчёта числа закладок
function counMark ($userId, $mysqli, $db_table_name){
$q = "SELECT id, bookmarks FROM $db_table_name WHERE id = $userId";	
$result = $mysqli->query($q);
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$book = $row[bookmarks];
	}
	if (empty($book)) return 0;
	$mark = bookmark ($book);
		$coun = count($mark);
	return $coun;
}

// Класс для работы с групповыми походами
class groupUser {
	//возвращает все записи библиотеки, где юзер как участник похода, а не автор отчёта
static public function getGroupPohod($db, $userId){
	//массив всех записей библиотеки
    $row = $db->getAllRecords();	
	$pohods_group = Array();
	$pohods_summ = Array();
	
	foreach ($row as $data){
		//если записей о группе нет анализировать следующую запись
		if (empty ($data['groupid'])) continue;
		//получаем массив идентификаторов участников похода
		$group = bookmark($data['groupid']);
		//засчитываем поход, если юзер указан в составе группы
		if (in_array($userId, $group, true) && ($data['ownerid'] != $userId)) {
			//$pohods_group[] = array($db->getRecords(array('id' => $data['id'])));
			$pohods_group = $db->getRecords(array('id' => $data['id']));
			$pohods_summ = array_merge($pohods_summ, $pohods_group);
		}
	}
	return $pohods_group;
}
static public function getUserPohod($db, $userId){
	 $row = $db->getAllRecords();
	 $pohods_summ = Array();
	$pohods = Array();
	foreach ($row as $data){
		if ($data['ownerid'] == $userId) {
			$pohods = $db->getRecords(array('id' => $data['id']));
			$pohods_summ = array_merge($pohods_summ, $pohods);
		    //$pohods[] = $db->getRecords(array('id' => $data['id']));
		}
	}
	return $pohods_summ;
}

}
