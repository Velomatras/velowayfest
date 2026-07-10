<?php

class ZayavkaEditor2018
{
    const ZAYAVKA_CLASS_NAME = 'Zayavka2018';

    public function ZayavkaEditor($zayavka, $moderatorId, $idz)
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

        self::ZayavkaEditorEdit($zayavka, $idz);
    }
    
    private function ZayavkaEditorSave($oldZayavka, $moderatorId, $idz)
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
        $zayavka->data['city'] = ParamsWork::sanitizeSQLStr($_REQUEST["city"]);
        $zayavka->data['command'] = ParamsWork::sanitizeSQLStr($_REQUEST["command"]);
        $zayavka->data['comments'] = ParamsWork::sanitizeSQLStr($_REQUEST["comments"]);
        $zayavka->data['email'] = ParamsWork::sanitizeSQLStr($_REQUEST["email"]);
        $zayavka->data['video_url'] = ParamsWork::sanitizeSQLStr($_REQUEST['video_url']);
        // arrays
        $zayavka->data['region'] = ParamsWork::sanitizeSQLStr(RegionWork::pack($_REQUEST["region"]));
        $zayavka->data['track_link'] = ParamsWork::sanitizeSQLStr(DBDataWork::packArray($_REQUEST["track-link"]));

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

    private function ZayavkaEditorDelConfirm($idz)
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

    private function ZayavkaEditorDelete($idz)
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

    private function ZayavkaEditorEdit($zayavka, $idz)
    {
        ?>
        <h2>Редактирование заявки</h2>
        <form enctype="multipart/form-data" method="POST" action="">
            <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
            <p>
        <?php
        GUIHelpers::setHiddenField('idz', $idz);
        GUIHelpers::setHiddenField('caller', URLWork::getCurURL());
        ?>
                <label for="status">Статус заявки</label><br>
                <?php printStatusesSelector('status', $zayavka->data['status']) ?><br>
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
                <br>
                <label for="status">Номинации</label>
                <br>
                    <?php printNominationsSelector(self::ZAYAVKA_CLASS_NAME, DBDataWork::unpackArray($zayavka->data['nominations'])); ?>
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
                <input name="link" id="link" type="text" size="50" value="<?= $zayavka->data['link'] ?>" />
                <br>
                <label for="route">Нитка маршрута</label><br>
                <input name="route" id="route" type="text" size="50" value="<?= $zayavka->data['route'] ?>" />
                <br style="clear:both;" />

                <label for="route">Ссылка на трек:</label><br>

                <?php
                foreach ($zayavka->getTrackLinks() as $trackLink) {
                    if (!empty($trackLink)) {
                        echo '<input type="text" name="track-link[]" size="40" maxlength="200" value="' . $trackLink . '"><br>';
                    }
                }
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
            </script>

            <label for="description">Описание (3-4 предложения):</label>
            <br />
            <textarea cols="60" rows="4" name="description" > <?= $zayavka->data['description'] ?> </textarea>
            <br />
            <label for="mileage">километраж</label>
            <br>
            <input type="text" name="mileage" size="10" value="<?= $zayavka->data['mileage'] ?>" />
            <br>
            <label for="name">ФИО организатора:</label>
            <br />
            <input maxlength="60" name="name" size="40" type="text" value="<?= $zayavka->data['name'] ?>" />
            <br>
            <label for="email">e-mail для обратной связи</label>
            <br />
            <input maxlength="40" name="email" size="40" type="text" value="<?= $zayavka->data['email'] ?>" />
            <br />
            <label for="city">Город проживания</label>
            <br />
            <input maxlength="40" name="city" size="40" type="text" value="<?= $zayavka->data['city'] ?>" />
            <br />
            <label for="command">Клуб (команда) и участники похода (всего, ФИО/ник, город)</label>
            <br />
            <textarea cols="60" rows="4" name="command" > <?= $zayavka->data['command'] ?> </textarea>
            <br />
            <label for="comments">Комментарий</label>
            <br />
            <textarea cols="60" rows="4" name="comments" > <?= $zayavka->data['comments'] ?> </textarea>
            <br><br>
            <label for="image">Картинка, характеризующая поход. Загрузить файл (только jpg)</label>
            <br>
            <input type="file" name="image" accept="image/*,image/jpeg" />
            <br>
            <label for="video_url">Ссылка на видео</label>
            <br>
            <input name="video_url" id="video_url" type="text" size="50" value="<?= $zayavka->data['video_url'] ?>" />
            <br>
            <p id="photo-block"><label for="">Загрузить фотографии:</label>
                <br>
                <input type="file" name="photo1" accept="image/*,image/jpeg"  /><br>
                <input type="file" name="photo2" accept="image/*,image/jpeg"  /><br>
                <input type="file" name="photo3" accept="image/*,image/jpeg"  />
            </p>
            <span>
                <br><br>
                <input type="submit" name="submit" id="submit" value="Сохранить заявку">
            </span>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span>
                <input type="submit" name="submit" id="submit" value="Удалить заявку">
            </span>
        </form>
        <?php
    }

}
