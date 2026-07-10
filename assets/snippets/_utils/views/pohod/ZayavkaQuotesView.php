<?php

class ZayavkaQuotesView {

    private $quoteInfo;

    public function setData($quoteInfo) {
        $this->quoteInfo = $quoteInfo;
    }

    public function headerType1() {
        ?>
        <tr>
            <th width="50px">№ Заявки/<br>№ Цитаты/<br>код в списке</th>
            <th>Цитата</th>
			<th>Автор</th>
        </tr>
        <?php
    }
	
	 public function headerType1_3() {
        ?>
        <tr>
            <td>№ Заявки</td><td>№ Цитаты</td><td>№ в общем списке</td>
                   </tr>
        <?php
    }
	
    public function headerType2() {
        ?>
        <tr>
		<th></th>
            <th>Результат</th>
            <th>№ Заявки/<br>№ Цитаты/<br>код в списке</th>
            <th>Цитата</th>
			<th>Автор</th>
            <th>Оценка Финала/<br>Оценка Отбора/<br>Кол-во оценок/<br>Кол-во учтённых оценок</th>
        </tr>
        <?php
    }
	
	public function headerType2_mod() {
        ?>
        <tr>
		<th></th>
            <th>Результат</th>
            <th>№ Заявки/<br>№ Цитаты/<br>код в списке</th>
            <th>Цитата</th>
			<th>Автор</th>
            <th>Оценка/<br>Дисперсия/<br>Число оценок/<br>Число учтённых оценок</th>
        </tr>
        <?php
    }

	public function columnAuthor() {
		?>
		
		
	<td bgcolor="#edf6e3" align="left" valign="top" >
	Автор: <b>
	<?= $this->quoteInfo['quote']['name'] ?></b><br>
	(<?= $this->quoteInfo['quote']['city'] ?>)
  	
		</td>
	<?php
	}
	
	public function columnAuthor_top() {
		?>
		
		
	<td background="assets/images/logo/star5.png" align="left" valign="top" >
	Автор: <b>
	<?= $this->quoteInfo['quote']['name'] ?></b><br>
	(<?= $this->quoteInfo['quote']['city'] ?>)
  	
		</td>
	<?php
	}
	
	public function columnRegions(){
				?>
		<td></td>
		<td></td>
	<td align="left" valign="top" colspan="2">
	Регион: 
		<?= $this->quoteInfo['quote']['regions'] ?>
		</td>
	<?php
	}
	
    public function column1() {
        ?>
        <td bgcolor="#edf6e3" align="center" valign="top"><b><?= $this->quoteInfo['zayavka']['id'] ?>/<?= $this->quoteInfo['quote']['num'] ?>/<?= $this->quoteInfo['quote']['numInList'] ?></b></td>
        <?php
    }
	
	public function column1_top() {
        ?>
        <td background="assets/images/logo/star5.png" align="center" valign="top"><b><?= $this->quoteInfo['zayavka']['id'] ?>/<?= $this->quoteInfo['quote']['num'] ?>/<?= $this->quoteInfo['quote']['numInList'] ?></b></td>
        <?php
    }
	
	 public function column1_3() {
        ?>
		<tr>
        <td align="center" valign="top"><b><?= $this->quoteInfo['zayavka']['id'] ?></td><td><?= $this->quoteInfo['quote']['num'] ?></td>
		<td><?= $this->quoteInfo['quote']['numInList'] ?></b></td>
		</tr>
        <?php
    }

    public function column2() {
        ?>
        <td align="center" valign="top">
		
            <?php $this->quoteInfo['quote']['quoteText'];

			?>
        
		</td>
        <?php
    }
	
	public function column3() {
        ?>
        <td align="center" valign="top">
		<b>
            <?= $this->quoteInfo['quote']['photosName'] ?>
        </b>
		</td>
        <?php
    }

    public function hr() {
        echo '<tr height="6px"><td colspan="4"><hr style="color:#B2B2B2"></td></tr>';
    }
	public function hr5() {
        echo '<tr height="6px"><td colspan="6"><hr style="color:#B2B2B2"></td></tr>';
    }

}
