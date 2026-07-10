<?php

/**
 *
 */
class LibEntryEditor {

    private $zayavka;

    public function __construct($entryData) {
        $this->zayavka = new LibraryEntry($entryData);
    }

       public function Editor() {
        if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Сохранить') {
            $this->Save();
            URLWork::GoURL(ParamsWork::sanitizeSQLStr($_REQUEST['caller']));
            return;
        }
//        if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Удалить') {
//            $this->DelConfirm();
//            return;
//        }
//
//        if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Да, удалить!') {
//            $this->Delete();
//            URLWork::goURL('');
//        }
        $this->EditForm();
    }

    public function EditorUnderPohodAuthorAccount() {
        if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Сохранить') {
            //$this->SaveUnderPohodAuthorAccount();
			$this->Save();
            URLWork::GoURL(ParamsWork::sanitizeSQLStr($_REQUEST['caller']));
            return;
        }
		 $this->EditForm();
        //$this->EditFormUnderPohodAuthorAccount();
    }

    private function DelConfirm() {
        $idz = ParamsWork::sanitizeInt($_REQUEST['idz']);
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

    private function EditForm() {
        ?>
        <h2>Редактирование похода</h2>
        <form enctype="multipart/form-data" method="POST" action="">
            <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
            <p>
                <?php
                GUIHelpers::setHiddenField('idz', $idz);
                GUIHelpers::setHiddenField('caller', URLWork::getCurURL());
                ?>
                <!--Сроки похода-->
                <br>
                <?php
//                $unpackedDates = Period::explodeDates($this->zayavka->data['period']);
//                $day = new GUISelector('day');
//                $day->makeDayInput();
//                $day->setZeroOption(false);
//                $day->setDefaultValue($unpackedDates[0]);
//                $day->draw();
//                $month = new GUISelector('month');
//                $month->makeMonthInput();
//                $month->setZeroOption(false);
//                $month->setDefaultValue($unpackedDates[1]);
//                $month->draw();
//                $year = new GUISelector('year');
//                $year->makeYearInput();
//                $year->setZeroOption(false);
//                $year->setDefaultValue($unpackedDates[2]);
//                $year->draw();
//                $day2 = new GUISelector('day2');
//                $day2->makeDayInput();
//                $day2->setZeroOption(false);
//                $day2->setDefaultValue($unpackedDates[3]);
//                $day2->draw();
//                $month2 = new GUISelector('month2');
//                $month2->makeMonthInput();
//                $month2->setZeroOption(false);
//                $month2->setDefaultValue($unpackedDates[4]);
//                $month2->draw();
//                $year2 = new GUISelector('year2');
//                $year2->makeYearInput();
//                $year2->setZeroOption(false);
//                $year2->setDefaultValue($unpackedDates[5]);
//                $year2->draw();
                ?>
                <link rel="stylesheet" href="/assets/js/multiselect/chosen.min.css">
                <script src="/assets/js/multiselect/chosen.jquery.min.js"></script>
                <br>
                <!-- <label for="regions">Район похода (если их несколько, то отмечайте, удерживая клавишу Ctrl):</label> -->
<!--                <label for="regions">Районы похода:</label>
                <br>
                <select name="region[]" id="region" size="10" multiple="multiple">
                    <option value="0" ></option>
        <?//= RegionWork::populateRegionSelectList(RegionWork::unpack($this->zayavka->data['region'])); ?>
                </select>
                <script type="text/javascript">
                    jQuery('#region').chosen({
                        no_results_text: "Не найдено",
                        placeholder_text_single: "Выберите",
                        placeholder_text_multiple: "Выберите"
                    });
                </script>
                <br>-->
                <label for="link">Ссылка на отчет</label><br>
                <input name="link" id="link" type="text" size="50" value="<?= $this->zayavka->data['link'] ?>" />
                <br>
                <label for="route">Нитка маршрута</label><br>
                <input name="route" id="route" type="text" size="50" value="<?= $this->zayavka->data['route'] ?>" />
                <br style="clear:both;" />

<!--                <label for="route">Ссылка на трек:</label><br>

                <?/*php
                foreach ($this->zayavka->getTrackLinks() as $trackLink) {
                    if (!empty($trackLink)) {
                        echo '<input type="text" name="track-link[]" size="40" maxlength="200" value="' . $trackLink . '"><br>';
                    }
                }*/
                ?>
            <p id="track-link-block">
                <input type="text" name="track-link[]" size="40" maxlength="200" value="" >
            </p>
            <p><button id="add-track">Добавить еще один трек</button></p>
            <script type="text/javascript">
                $('#add-track').click(function () {
                    var linkBlock = $('#track-link-block').clone();
                    linkBlock.children('input').val('');
                    $('#track-link-block').after(linkBlock);
                    return false;
                });
            </script>-->

            <label for="description">Описание (3-4 предложения):</label>
            <br />
            <textarea cols="60" rows="4" name="description" > <?= $this->zayavka->data['description'] ?> </textarea>
            <br />
            <label for="mileage">километраж</label>
            <br>
            <input type="text" name="mileage" size="10" value="<?= $this->zayavka->data['mileage'] ?>" />
            <br>
            <label for="name">ФИО организатора:</label>
            <br />
            <input maxlength="60" name="name" size="40" type="text" value="<?= $this->zayavka->data['name'] ?>" />
            <br>
            <label for="email">e-mail для обратной связи</label>
            <br />
            <input maxlength="40" name="email" size="40" type="text" value="<?= $this->zayavka->data['email'] ?>" />
            <br />
            <label for="city">Город проживания</label>
            <br />
            <input maxlength="40" name="city" size="40" type="text" value="<?= $this->zayavka->data['city'] ?>" />
            <br />
            <label for="command">Клуб (команда) и участники похода (всего, ФИО/ник, город)</label>
            <br />
            <textarea cols="60" rows="4" name="command" > <?= $this->zayavka->data['command'] ?> </textarea>
            <br />
            <label for="comments">Комментарий</label>
            <br />
            <textarea cols="60" rows="4" name="comments" > <?= $this->zayavka->data['comments'] ?> </textarea>
            <br><br>
<!--            <label for="image">Картинка, характеризующая поход. Загрузить файл (только jpg)</label>
            <br>
            <input type="file" name="image" accept="image/*,image/jpeg" />
            <br>-->
            <label for="video_url">Ссылка на видео</label>
            <br>
            <input name="video_url" id="video_url" type="text" size="50" value="<?= $this->zayavka->data['video_url'] ?>" />
            <br>
<!--            <p id="photo-block"><label for="">Загрузить фотографии:</label>
                <br>
                <input type="file" name="photo1" accept="image/*,image/jpeg"  /><br>
                <input type="file" name="photo2" accept="image/*,image/jpeg"  /><br>
                <input type="file" name="photo3" accept="image/*,image/jpeg"  />
            </p>-->
            <span>
                <br><br>
                <input type="submit" name="submit" id="submit" value="Сохранить">
            </span>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<!--            <span>
                <input type="submit" name="submit" id="submit" value="Удалить">
            </span>-->
        </form>
        <?php
    }


    private function Save() {
        $idz = ParamsWork::sanitizeInt($_REQUEST['id']);
        $tmpEntry = new LibraryEntry(array());
//        $day = ParamsWork::sanitizeInt($_REQUEST["day"]);
//        $month = ParamsWork::sanitizeInt($_REQUEST["month"]);
//        $year = ParamsWork::sanitizeInt($_REQUEST["year"]);
//        $day2 = ParamsWork::sanitizeInt($_REQUEST["day2"]);
//        $month2 = ParamsWork::sanitizeInt($_REQUEST["month2"]);
//        $year2 = ParamsWork::sanitizeInt($_REQUEST["year2"]);
        $tmpEntry->data['mileage'] = ParamsWork::sanitizeInt($_REQUEST['mileage']);
        $tmpEntry->data['route'] = fixRoute(ParamsWork::sanitizeSQLStr($_REQUEST['route']));
        $tmpEntry->data['link'] = ParamsWork::sanitizeSQLStr($_REQUEST["link"]);
        $tmpEntry->data['description'] = ParamsWork::sanitizeSQLStr($_REQUEST["description"]);
        $tmpEntry->data['name'] = ParamsWork::sanitizeSQLStr($_REQUEST["name"]);
        $tmpEntry->data['city'] = ParamsWork::sanitizeSQLStr($_REQUEST["city"]);
        $tmpEntry->data['command'] = ParamsWork::sanitizeSQLStr($_REQUEST["command"]);
        $tmpEntry->data['comments'] = ParamsWork::sanitizeSQLStr($_REQUEST["comments"]);
        $tmpEntry->data['email'] = ParamsWork::sanitizeSQLStr($_REQUEST["email"]);
        $tmpEntry->data['video_url'] = ParamsWork::sanitizeSQLStr($_REQUEST['video_url']);
        // arrays
//        $this->zayavka->data['region'] = ParamsWork::sanitizeSQLStr(RegionWork::pack($_REQUEST["region"]));
//        $this->zayavka->data['track_link'] = ParamsWork::sanitizeSQLStr(DBDataWork::packArray($_REQUEST["track-link"]));

// формируем строку со сроками похода
//        $this->zayavka->data['period'] = Period::makePeriodStr($day, $month, $year, $day2, $month2, $year2);
// загружаем картинку
//        $this->zayavka->uploadCoverPic('image', $idz);
//        printDebugLog($photoLinksArray);
//        if (!empty($photoLinksArray)) {
//            $photos_link = DBDataWork::packArray($photoLinksArray);
//            $this->zayavka->data['photos_link'] = $photos_link;
//        }

        if ($this->zayavka->data['link'] != $tmpEntry->data['link']) {
            $tmpEntry->data['pohod_status'] = LibraryEntry::OTCHET_LINK_OK_STATUS;
        }
        $tmpEntry->update($idz);
    }

     private function SaveUnderPohodAuthorAccount() {
        $idz = ParamsWork::sanitizeInt($_REQUEST['id']);
        $tmpEntry = new LibraryEntry(array());
        $tmpEntry->data['link'] = ParamsWork::sanitizeSQLStr($_REQUEST["link"]);
        $tmpEntry->update($idz);
    }

    function EditFormUnderPohodAuthorAccount() {
        ?>
        <h2>Изменить данные похода</h2>
        <form enctype="multipart/form-data" method="POST" action="">
            <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
            <p>
                <?php
                GUIHelpers::setHiddenField('idz', $idz);
                GUIHelpers::setHiddenField('caller', URLWork::getCurURL());
                ?>
                <!--Сроки похода-->
                <br>
                <link rel="stylesheet" href="/assets/js/multiselect/chosen.min.css">
                <script src="/assets/js/multiselect/chosen.jquery.min.js"></script>
                <br>
                <label for="link">Ссылка на отчет</label><br>
                <input name="link" id="link" type="text" size="50" value="<?= $this->zayavka->data['link'] ?>" />
            <span>
                <br><br>
                <input type="submit" name="submit" id="submit" value="Сохранить">
            </span>
        </form>
        <?php
    }

}
