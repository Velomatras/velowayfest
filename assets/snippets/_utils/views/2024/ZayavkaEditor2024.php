<?php

class ZayavkaEditor2024
{
    const ZAYAVKA_CLASS = 'Zayavka';
	const ZAYAVKA_CLASS_NAME = 'Zayavka2024';

    public static function ZayavkaEditor($zayavka, $moderatorId, $idz, $regOff)
    {
        if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Сохранить заявку') {
            self::ZayavkaEditorSave($zayavka, $moderatorId, $idz);
            URLWork::GoURL(ParamsWork::sanitizeSQLStr($_REQUEST['caller']));
            return;
        }

        if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Удалить заявку') {
            self::ZayavkaEditorDelConfirm($idz);
            return;
        }

        if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Да, удалить!') {
            self::ZayavkaEditorDelete($idz);
            URLWork::goURL('');
        }

        self::ZayavkaEditorEdit($zayavka, $idz, $regOff);
    }
    
    private static function ZayavkaEditorSave($oldZayavka, $moderatorId, $idz)
    {        
        $className = self::ZAYAVKA_CLASS_NAME;
        $zayavka = new $className();
        
        $zayavkaPrevModeratorId = isset($oldZayavka->data['moderator']) ? $zayavka->data['moderator'] : null;
        
        $zayavka->data['moderator'] = isset($zayavkaPrevModeratorId) ? $zayavkaPrevModeratorId : $moderatorId;
        $zayavka->data['status'] = ParamsWork::sanitizeInt($_REQUEST['status']);
        $zayavka->data['nominations'] = ParamsWork::sanitizeSQLStr(DBDataWork::packArray($_REQUEST["nominations"]));
        $day = ParamsWork::sanitizeInt($_REQUEST["day"]);
        $month = ParamsWork::sanitizeInt($_REQUEST["month"]);
        $year = ParamsWork::sanitizeInt($_REQUEST["year"]);
        $day2 = ParamsWork::sanitizeInt($_REQUEST["day2"]);
        $month2 = ParamsWork::sanitizeInt($_REQUEST["month2"]);
        $year2 = ParamsWork::sanitizeInt($_REQUEST["year2"]);
        $zayavka->data['mileage'] = ParamsWork::sanitizeInt($_REQUEST['mileage']);
        $zayavka->data['route'] = fixRoute(ParamsWork::sanitizeSQLStr($_REQUEST['route']));
        $zayavka->data['link'] = ParamsWork::sanitizeSQLStr($_REQUEST["link"]);
        $zayavka->data['description'] = ParamsWork::sanitizeSQLStr($_REQUEST["description"]);
        $zayavka->data['name'] = ParamsWork::sanitizeSQLStr($_REQUEST["name"]);
		$zayavka->data['name2'] = ParamsWork::sanitizeSQLStr($_REQUEST["name2"]);
        $zayavka->data['city'] = ParamsWork::sanitizeSQLStr($_REQUEST["city"]);
		$zayavka->data['class'] = ParamsWork::sanitizeSQLStr($_REQUEST["class"]);
		$zayavka->data['number'] = ParamsWork::sanitizeSQLStr($_REQUEST["number"]);
		$zayavka->data['social'] = ParamsWork::sanitizeSQLStr($_REQUEST["social"]);
		$zayavka->data['tel'] = ParamsWork::sanitizeSQLStr($_REQUEST["tel"]);
        $zayavka->data['command'] = ParamsWork::sanitizeSQLStr($_REQUEST["command"]);
		$zayavka->data['club'] = ParamsWork::sanitizeSQLStr($_REQUEST["club"]);
		$zayavka->data['clublink'] = ParamsWork::sanitizeSQLStr($_REQUEST["clublink"]);
		$zayavka->data['myself'] = ParamsWork::sanitizeSQLStr($_REQUEST["myself"]);
        $zayavka->data['comments'] = ParamsWork::sanitizeSQLStr($_REQUEST["comments"]);
        $zayavka->data['email'] = ParamsWork::sanitizeSQLStr($_REQUEST["email"]);
        $zayavka->data['video_url'] = ParamsWork::sanitizeSQLStr($_REQUEST['video_url']);
		$zayavka->data['videoLong_url'] = ParamsWork::sanitizeSQLStr($_REQUEST['videoLong_url']);
		$zayavka->data['lector_url'] = ParamsWork::sanitizeSQLStr($_REQUEST['lector_url']);
		$zayavka->data['photo01'] = ParamsWork::sanitizeSQLStr($_REQUEST['photo01']);
		$zayavka->data['photo02'] = ParamsWork::sanitizeSQLStr($_REQUEST['photo02']);
		$zayavka->data['photo03'] = ParamsWork::sanitizeSQLStr($_REQUEST['photo03']);
		$zayavka->data['author_foto1'] = ParamsWork::sanitizeSQLStr($_REQUEST['author_foto1']);
		$zayavka->data['author_foto2'] = ParamsWork::sanitizeSQLStr($_REQUEST['author_foto2']);
		$zayavka->data['author_foto3'] = ParamsWork::sanitizeSQLStr($_REQUEST['author_foto3']);
		$zayavka->data['author_video'] = ParamsWork::sanitizeSQLStr($_REQUEST['author_video']);
		$zayavka->data['author_videoLong'] = ParamsWork::sanitizeSQLStr($_REQUEST['author_videoLong']);
		$zayavka->data['author_lector'] = ParamsWork::sanitizeSQLStr($_REQUEST['author_lector']);
        // arrays
        $zayavka->data['region'] = ParamsWork::sanitizeSQLStr(RegionWork::pack($_REQUEST["region"]));
        $zayavka->data['track_link'] = ParamsWork::sanitizeSQLStr(DBDataWork::packArray($_REQUEST["track-link"]));
		$zayavka->data['quote'] = ParamsWork::sanitizeSQLStr(DBDataWork::packArray($_REQUEST["quote"]));

// формируем строку со сроками похода
        $zayavka->data['period'] = Period::makePeriodStr($day, $month, $year, $day2, $month2, $year2);
// загружаем картинку
        $zayavka->uploadCoverPic('image', $idz);
// загружаем фотографии
        $photos = new Photos($idz, $zayavka::$PHOTO_SAVE_PATH);
        //echo $zayavka::$PHOTO_SAVE_PATH; die();
        $photoLinksArray = $photos->uploadPhotos('photo');
        printDebugLog($photoLinksArray);
        if (!empty($photoLinksArray)) {
            $photos_link = DBDataWork::packArray($photoLinksArray);
            $zayavka->data['photos_link'] = $photos_link;
        }
        $zayavka->update($idz);
    }

    private static function ZayavkaEditorDelConfirm($idz)
    {        
        ?>
        <form enctype="multipart/form-data" method="POST" action="">
            <p>
                Удалить заявку?
                <br>
                <?php
                GUIHelpers::setHiddenField('idz', $idz);
                GUIHelpers::setHiddenField('caller', URLWork::getCurURL());
                ?>
                <input type="submit" name="submit" id="submit" value="Да, удалить!">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="submit" name="submit" id="submit" value="Нет">
            </p>
        </form>
        <?php
    }

    private static function ZayavkaEditorDelete($idz)
    {        
        $className = self::ZAYAVKA_CLASS_NAME;
        $zayavka = new $className();
        
        $zayavka->delete($idz);
        $db = new MyCRUD_Modx($zayavka::$db_table_name);
        $autoincrementId = $db->getAutoincrementValue();
        if ($autoincrementId == $idz + 1) { // если удаляемая заявка - самая новая, то корректируем номер, который будет присвоен следующей заявке
            $db->setAutoincrementValue($idz);
        }
    }

    private static function ZayavkaEditorEdit($zayavka, $idz, $regOff)
    {
        ?>
        <h2>Редактирование заявки</h2>
        <form enctype="multipart/form-data" method="POST" action="">
		<div class="cell_yellow3" style="padding: 15px 20px 15px">
            <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
            <p>
			<style>
   .colortext {
    background-color: #fbeefd; /* Цвет фона */
    }
  </style>
        <?php
        GUIHelpers::setHiddenField('idz', $idz);
        GUIHelpers::setHiddenField('caller', URLWork::getCurURL());
		global $modx;
		$userId = $modx->getLoginUserID();
		if (empty($userId)) $userId = 0;
		if (isModerator($userId)){
        ?>
		
                <label for="status">Статус заявки</label><br>
                <?php 
		
				printStatusesSelector('status', $zayavka->data['status']);
		}
				?>
				<br><br>
                Сроки похода
                <br>
                <?php
                $unpackedDates = Period::explodeDates($zayavka->data['period']);
                $day = new GUISelector('day');
                $day->makeDayInput();
                $day->setZeroOption(false);
                $day->setDefaultValue($unpackedDates[0]);
                $day->draw();
                $month = new GUISelector('month');
                $month->makeMonthInput();
                $month->setZeroOption(false);
                $month->setDefaultValue($unpackedDates[1]);
                $month->draw();
                $year = new GUISelector('year');
                $year->makeYearInput();
                $year->setZeroOption(false);
                $year->setDefaultValue($unpackedDates[2]);
                $year->draw();
                $day2 = new GUISelector('day2');
                $day2->makeDayInput();
                $day2->setZeroOption(false);
                $day2->setDefaultValue($unpackedDates[3]);
                $day2->draw();
                $month2 = new GUISelector('month2');
                $month2->makeMonthInput();
                $month2->setZeroOption(false);
                $month2->setDefaultValue($unpackedDates[4]);
                $month2->draw();
                $year2 = new GUISelector('year2');
                $year2->makeYearInput();
                $year2->setZeroOption(false);
                $year2->setDefaultValue($unpackedDates[5]);
                $year2->draw();
                ?>
                <link rel="stylesheet" href="/assets/js/multiselect/chosen.min.css">
                <script src="/assets/js/multiselect/chosen.jquery.min.js"></script>
                <br><br>
                <label for="status">Номинации:</label>
                <br>
                    <?php 
					
					printNominationsSelector(self::ZAYAVKA_CLASS_NAME, DBDataWork::unpackArray($zayavka->data['nominations'])); 
					?>
                <br>
                <!-- <label for="regions">Район похода (если их несколько, то отмечайте, удерживая клавишу Ctrl):</label> -->
                <label for="regions">Районы похода:</label>
                <br>
                <select name="region[]" id="region" size="10" multiple="multiple">
                    <option value="0" ></option>
        <?= RegionWork::populateRegionSelectList(RegionWork::unpack($zayavka->data['region'])); ?>
                </select>
                <script type="text/javascript">
                    jQuery('#region').chosen({
                        no_results_text: "Не найдено",
                        placeholder_text_single: "Выберите",
                        placeholder_text_multiple: "Выберите"
                    });
                </script>
                <br>
                <label for="link">Ссылка на отчет</label><br>
                <input name="link" id="link" type="text" class="colortext" size="50" value="<?= $zayavka->data['link'] ?>" />
                <br>
                <label for="route">Нитка маршрута</label><br>
                <!-- <input name="route" id="route" type="text" size="50" value="<?= $zayavka->data['route'] ?>" /> -->
				<textarea cols="60" rows="4" name="route" class="colortext" id="route" ><?= $zayavka->data['route'] ?> </textarea>
                <br style="clear:both;" />

                <label for="route">Ссылка на трек:</label><br>

                <?php
                foreach ($zayavka->getTrackLinks() as $trackLink) {
                    if (!empty($trackLink)) {
                        echo '<input type="text" name="track-link[]" size="60" maxlength="1000" value="' . $trackLink . '"><br>';
                    }
                }
                ?>
            <p id="track-link-block">
                <input type="text" name="track-link[]" size="60" maxlength="1000" value="" >
            </p>
			
            <p><button id="add-track">Добавить еще один трек</button></p>
            <script type="text/javascript">
                $('#add-track').click(function () {
                    var linkBlock = $('#track-link-block').clone();
                    linkBlock.children('input').val('');
                    $('#track-link-block').after(linkBlock);
                    return false;
                });
            </script>
			<br>
			<label for="quote">Цитаты:</label><br>

                <?php
				if ($regOff <= 2 ) {
                foreach ($zayavka->getQuote() as $quote) {
                    if (!empty($quote)) {
                        echo '<input type="text" name="quote[]" size="100" maxlength="2000" value="' . $quote . '"><br>';
                    }
                }
				
				
                ?>
            
			<p id="quote-block" class="quote-block-class">
  <input type="text" name="quote[]" size="100" maxlength="2000" value="" >
</p>
<p><button id="add-quote">Добавить еще одну цитату</button></p>
 

			
            <script type="text/javascript">
                $('#add-quote').click(function () {
  var linkBlock2 = $('#quote-block').clone();
  linkBlock2.children('input').val('');
  $('.quote-block-class:last').after(linkBlock2);
  return false;
});
            </script>
			<?php
			}
			else {
				if ($regOff == 3) echo "<font color=\"red\">Внимание! Редактор цитат недоступен, так как этап голосований начался!</font>";
				if ($regOff == 4) echo "<font color=\"red\">Редактор цитат доступен только для модераторов!</font>";
			echo "<br>";
			}
			?>
            <br />
            <label for="description">Описание (3-4 предложения):</label>
            <br />
            <textarea cols="100" rows="6" name="description" ><?= $zayavka->data['description'] ?> </textarea>
            <br><br>
			
            <label for="mileage">километраж</label>
            <br>
            <input type="text" name="mileage" class="colortext" size="10" value="<?= $zayavka->data['mileage'] ?>" />
            <br><br>
			
            <label for="name">ФИО автора отчёта:</label>
            <br />
            <input maxlength="60" name="name" class="colortext" size="40" type="text" value="<?= $zayavka->data['name'] ?>" />
			<br><br>
			
			<label for="name2">ФИО организатора:</label>
            <br />
            <input maxlength="60" id="name2" name="name2" size="40" type="text" value="<?= $zayavka->data['name2'] ?>" />
            <br><br>
			
            <label for="email">e-mail для обратной связи</label>
            <br />
            <input maxlength="40" name="email" class="colortext" size="40" type="text" value="<?= $zayavka->data['email'] ?>" />
            <br><br>
			
			<label for="social">Ссылка на контакт в соцсети</label><br>
                <input name="social" id="social" type="text" size="60" value="<?= $zayavka->data['social'] ?>" />
				<br><br>
				
			<label for="social">Телефон автора отчёта:</label><br>
                <input name="tel" maxlength="40" id="tel" type="text" size="40" value="<?= $zayavka->data['tel'] ?>" />
               <br><br>
			   
            <label for="city">Город проживания</label>
            <br />			
            <input maxlength="40" name="city" size="40" type="text" value="<?= $zayavka->data['city'] ?>" />
			<br><br>
			
			<label for="myself">О себе (предпочитаемые форматы походов/гонок, стиль, направления, любимые ландщафты,опыт)</label>
			<br><br>
            <textarea cols="100" rows="6" name="myself" ><?= $zayavka->data['myself'] ?> </textarea>
            <br />
			
            <label for="number">число участников</label>
            <br>
            <input type="text" name="number" class="colortext" size="4" value="<?= $zayavka->data['number'] ?>" />
            <br><br>
			
			<label for="club">Клуб (команда)</label>
            <br>
            <input type="text" name="club"  size="40" value="<?= $zayavka->data['club'] ?>" />
            <br><br>
			
			<label for="clublink">ссылка на клуб</label>
            <br>
			<input type="text" name="clublink"  size="40" value="<?= $zayavka->data['clublink'] ?>" />
            <br><br>
			
            <label for="command">Участники похода (всего, ФИО/ник, город)</label>
			<br><br>
            <textarea cols="60" rows="4" name="command" ><?= $zayavka->data['command'] ?> </textarea>
            <br />
			
            <label for="comments">Комментарий</label>
            <br />
            <textarea cols="60" rows="4" name="comments" ><?= $zayavka->data['comments'] ?> </textarea>
            <br><br>
            <label for="image">Картинка, характеризующая поход. Загрузить файл (jpg, jpeg)</label>
            <br>
            <input type="file" name="image" accept="image/*,image/jpeg" />
            <br><br>
            <label for="video_url">Ссылка на короткий видеоролик</label>
            <br>
			<input name="video_url" id="video_url" type="text" size="50" value="<?= $zayavka->data['video_url'] ?>" />
			<br>
			<label for="author_video">Автор короткого видеоролика</label>
            <br>
			<input maxlength="40" name="author_video" size="50" type="text" value="<?= $zayavka->data['author_video'] ?>" />
			<br><br>
			 <label for="videoLong_url">Ссылка на фильм</label>
            <br>
            <input name="videoLong_url" id="videoLong_url" type="text" size="50" value="<?= $zayavka->data['videoLong_url'] ?>" />
            <br>
			<label for="author_videoLong">Автор фильма</label>
            <br>
			<input maxlength="40" name="author_videoLong" size="50" type="text" value="<?= $zayavka->data['author_videoLong'] ?>" />
			<br><br>
			 <label for="lector_url">Ссылка на лекцию</label>
            <br>
            <input name="lector_url" id="lector_url" type="text" size="50" value="<?= $zayavka->data['lector_url'] ?>" />
            <br>
			<label for="author_lector">Автор лекции</label>
            <br>
			<input maxlength="40" name="author_lector" size="50" type="text" value="<?= $zayavka->data['author_lector'] ?>" />
			<br><br>
			<?php
			if ($regOff == 1 || $regOff == 4) {
			?>
			
            <p id="photo-block"><label for="">Загрузить фотографии (добавление стирает уже загруженные фото, нужно перезагружать все!):</label>
                <br>
				
            <input type="file" name="photo1" accept="image/*,image/jpeg"  />
			<?php
			}
			else echo "<br><font color=\"red\">Внимание! Загрузчик фото недоступен, так как этап голосований начался!</font><br>";
			?>
			<br> 
			<table><tr><td>
			<label for="photo01">Название фото №1</label></td><td>
			<input maxlength="60" name="photo01" size="40" type="text" value="<?= $zayavka->data['photo01'] ?>" /></td></tr>
			<tr><td>
			<label for="author_foto1">Автор фото №1</label></td><td>
			<input maxlength="60" name="author_foto1" size="40" type="text" value="<?= $zayavka->data['author_foto1'] ?>" /></td></tr>
			</table>
			<?php
			if ($regOff == 1  || $regOff == 4) {
			?>
            <input type="file" name="photo2" accept="image/*,image/jpeg"  /><br>
			<?php
			}
			?>
			<table><tr><td>
			<label for="photo02">Название фото №2</label></td><td>
			
			<input maxlength="60" name="photo02" size="40" type="text" value="<?= $zayavka->data['photo02'] ?>" /></td></tr>
			<tr><td>
			<label for="author_foto2">Автор фото №2</label></td><td>
			<input maxlength="60" name="author_foto2" size="40" type="text" value="<?= $zayavka->data['author_foto2'] ?>" /></td></tr>
			</table>			
			<?php
			if ($regOff == 1  || $regOff == 4) {
			?>
            <input type="file" name="photo3" accept="image/*,image/jpeg"  /><br>
			<?php
			}
			?>
			<table><tr><td>
			<label for="photo03">Название фото №3</label></td><td>
			<input maxlength="60" name="photo03" size="40" type="text" value="<?= $zayavka->data['photo03'] ?>" /></td></tr>
			<tr><td>
			<label for="author_foto3">Автор фото №3</label></td><td>
			<input maxlength="60" name="author_foto3" size="40" type="text" value="<?= $zayavka->data['author_foto3'] ?>" /></td></tr>
			</table>
            </p>
			
			
            <span>
			
                <br><br>
                <input type="submit" class="buttons" name="submit" id="submit" value="Сохранить заявку">
            </span>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span>
                <input type="submit" name="submit" id="submit" value="Удалить заявку">
            </span></div>
        </form>
        <?php
    }

}
