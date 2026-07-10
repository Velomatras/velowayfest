<?php

class ViewTableLibraryTempEntry {

    private $zayavka;
    private $zayavkaDetailsURL;

    public function setData($zayavka, $zayavkaDetailsURL) {
        $this->zayavka = $zayavka;
        $this->zayavkaDetailsURL = $zayavkaDetailsURL;
    }

    public function headerType1() {
        ?>
        <tr>
            <th width="150px">№ Заявки</th>
            <th>Маршрут /<br> Описание</th>
            <th>Организатор /<br>Сроки/<br> Класс</th>
            <th width="100px">Статус / Модератор <br></th>
        </tr>
        <?php
    }

    public function headerType1_StatNomResult($resultName = '') {
        ?>
        <tr>
            <th>Результат</th>
            <th width="150px">№ Заявки</th>
            <th>Маршрут/<br> Описание</th>
            <th>Организатор /<br>Сроки/<br> Класс</th>
            <?php if (!empty($resultName)) {
                echo "<th>$resultName</th>";
            }
            ?>
        </tr>
        <?php
    }
/*<th width = 50px>Трудность</th>
            <th width = 50px>Маршрут</th>
            <th width = 50px>Отчет</th>
            <th width = 50px>Сумма</th>*/
    public function headerType1_refResults($valueName) {
        ?>
        <tr>
            <th>Результат</th>
            <th width="150px">№ Заявки</th>
            <th>Маршрут/<br>Описание</th>
            <th>Организатор</th>
            <th width = 50px><?= $valueName ?></th>
        </tr>
       <?php
    }
    public function headerType2() {
        ?>
        <tr>
            <th>Результат</th>
            <th>№ Заявки</th>
            <th>Описание</th>
            <th>Автор</th>
            <th>Средняя оценка зрителей</th>
            <th>Число голосов зрителей</th>
            <th>Количество учтённых голосов</th>
        </tr>
        <?php
    }
    public function headerType3() {
        ?>
        <tr>
            <th>№ Заявки</th>
            <th>Описание</th>
            <th>Автор</th>
        </tr>
        <?php
    }
    public function headerType4() {
        ?>
        <tr>
            <th width="150px">№ Заявки</th>
            <th>Маршрут /<br> Описание</th>
            <th>Организатор /<br>Сроки</th>
            <th width="100px">Число голосов</th
        </tr>
        <?php
    }

    public function column1() {
        ?>
        <td align="center" valign="top"><b><?= $this->zayavka->data['id'] ?></b>
            <?php out_cover_image($this->zayavka->data['pic_upload'], $this->zayavka->getCoverImgSavePath(), $this->zayavka->data['id'],
                    $this->zayavka->data['pic'], $this->zayavka->data['description'], $this->zayavka->data['name']); ?>
        </td>
        <?php
    }

    public function column2() {
        ?>
        <td>
            <a href="<?= $this->zayavkaDetailsURL . '?idz=' . $this->zayavka->data['id'] ?>" target="_blank"
               title="<?= getRegionsNames($this->zayavka->data['region']) ?> "> <?= $this->zayavka->data['route'] ?> </a><br><br>
            <?= $this->zayavka->data['mileage'] ?> км <br><br>
            <?= $this->zayavka->data['description'] ?><br>
        </td>
        <?php
    }

    public function column2_noDescription() {
        ?>
        <td>
            <a href="<?= $this->zayavkaDetailsURL . '?idz=' . $this->zayavka->data['id'] ?>" target="_blank"
               title="<?= getRegionsNames($this->zayavka->data['region']) ?> "> <?= $this->zayavka->data['route'] ?> </a><br><br>
            <?= $this->zayavka->data['mileage'] ?> км <br><br>
        </td>
        <?php
    }

    public function column3() {
        ?>
        <td align="center" valign="top">
            <?= $this->zayavka->data['name'] ?><br>
            <?= $this->zayavka->data['city'] ?><br>
            <?= $this->zayavka->data['period'] . '<br>(' . get_trip_duration_text($this->zayavka->data['period']) . ')' ?>
            <br><br>
            <div style="color:#666666">
                <?= $this->zayavka->data['class'] ?>
            </div>
            <a href="<?= $this->zayavkaDetailsURL . '?idz=' . $this->zayavka->data['id'] ?>" target="_blank">Комментарии <?= $this->zayavka->calc_comments() ?> </a>
        </td>
        <?php
    }

    public function column4() {
        ?>
        <td align="center" bgcolor="<?= $this->zayavka->getStatusColor() ?>" >
            <?= $this->zayavka->getStatusStr() ?><br><br>
            <?php
            if ($this->zayavka->isApplied()) {
                echo $this->zayavka->getModerator() . '<br><br>';
            }
            ?>
        </td>
        <?php
    }


    public function column2_video() {
    ?>
    <td>
        <br><br>
        <h3><a href="<?= $this->zayavka->data['video_url'] ?>" target="_blank">Ссылка на видео</a></h3>
        <br>
        <?= htmlspecialchars($this->zayavka->data['description']) ?>
    </td>
    <?php
    }

    public function column3_video() {
    ?>
        <td align="center"><?= $this->zayavka->data[name] ?></td>
    <?php
    }

    public function placeColumn() {
        print_rate($this->zayavka->data['place']);
    }

    public function row() {
        echo '<tr>';
        $this->column1();
        $this->column2();
        $this->column3();
        $this->column4();
        echo '</tr>';
    }

    public function row_StatNomResult($resultValue = null) {
        echo '<tr>';
        $this->placeColumn();
        $this->column1();
        $this->column2();
        $this->column3();
        if (!empty($resultValue)){
            print_rate(round($resultValue));
        }
        echo '</tr>';
    }

    public function column2_exciting() {
    ?>
    <td>
        <br><br>
        <h3><a href="<?= $this->zayavka->data['link'] ?>" target="_blank">Ссылка на отчет</a></h3>
        <br>
        <?= htmlspecialchars($this->zayavka->data['description']) ?>
    </td>
    <?php
    }

    public function hr() {
        echo '<tr height="6px"><td colspan="4"><hr style="color:#B2B2B2"></td></tr>';
    }
}
z