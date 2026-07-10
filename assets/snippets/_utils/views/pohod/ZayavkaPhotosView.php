<?php

class ZayavkaPhotosView {

    private $photoInfo;

    public function setData($photoInfo) {
        $this->photoInfo = $photoInfo;
    }

    public function headerType1() {
        ?>
        <tr>
            <th width="50px">№ Заявки/<br>фотографии/<br>№ в общем списке</th>
            <th>Фотография</th>
			<th>Автор/регион</th>
        </tr>
        <?php
    }
	
	 public function headerType1_3() {
        ?>
        <tr>
            <td>№ Заявки</td><td>№ Фото</td><td>№ в общем списке</td>
                   </tr>
        <?php
    }
	
    public function headerType2() {
        ?>
        <tr>
            <th>Результат</th>
            <th>№ Заявки/<br>фотографии/<br>№ в общем списке</th>
            <th>Фотография</th>
			<th>Автор/регион</th>
            <th>оценка Финала/<br>оценка Отбора<br>всего голосов/<br>учтенных голосов</th>
        </tr>
        <?php
    }

	public function columnAuthor() {
		?>
		<td></td>
		<td></td>
	<td align="left" valign="top" colspan="2">
	Автор: <b>
	<?= $this->photoInfo['photo']['name'] ?>
	</b>
		</td>
	<?php
	}
	
	public function columnAuthor1() {
		?>
		<td></td>
		<td></td>
	<td align="left" valign="top" colspan="2">
	Автор: <b>
	<?php
  $author = $this->photoInfo['zayavka']['author_foto1'];
  $authorOth = $this->photoInfo['photo']['name'];
  if (!empty($author)) echo $author;
  else echo $authorOth;
  ?>
	</b>
		</td>
	<?php
	}
	
	public function columnAuthor1_top() {
		?>
		<td background="assets/images/logo/star_top1.png" align="center" valign="top"><b><?= $this->photoInfo['zayavka']['id'] ?>/<?= $this->photoInfo['photo']['num'] ?>/<?= $this->photoInfo['photo']['numInList'] ?></b></td>
		
		<td border="0"  height="90px" background="assets/images/logo/star_top1.png"></td>
	<td bgcolor="#f9fab0" border="0"  align="left" valign="top" colspan="2">
	Автор: <b>
	<?php
  $author = $this->photoInfo['zayavka']['author_foto1'];
  $authorOth = $this->photoInfo['photo']['name'];
  if (!empty($author)) echo $author;
  else echo $authorOth;
    ?>
	</b><br><br>
	Регион: 
		<b><?= $this->photoInfo['photo']['regions'] ?>
	</b>
		</td>
	<?php
	}
	
	public function columnAuthor_top_result($top, $numFoto) {
		if ($top != 0){
		?>
		<td background="assets/images/logo/star_top1.png" align="center" valign="top"><b><?= $this->photoInfo['zayavka']['id'] ?>/<?= $this->photoInfo['photo']['num'] ?>/<?= $this->photoInfo['photo']['numInList'] ?></b></td>
		<?php
		}
		else {
			?>
		<td align="center" valign="top"><b><?= $this->photoInfo['zayavka']['id'] ?>/<?= $this->photoInfo['photo']['num'] ?>/<?= $this->photoInfo['photo']['numInList'] ?></b></td>
		<?php
		}
		if ($top == 0){
			?>
		<td></td>
		<?php
		}
		else if ($top == 1){
			?>
		<td border="0"  height="90px" background="assets/images/logo/star_top1.png"></td>
		<?php
		}
		else if ($top == 2){
			?>
		<td border="0"  height="90px" background="assets/images/logo/star_top2.png"></td>
		<?php
		}
		else if ($top == 3){
			?>
		<td border="0"  height="90px" background="assets/images/logo/star_top3.png"></td>
		<?php
		}
		else if ($top == 4){
			?>
		<td border="0"  height="90px" background="assets/images/logo/star_top4.png"></td>
		<?php
		}
		else if ($top == 4){
			?>
		<td border="0"  height="90px" background="assets/images/logo/star_top5.png"></td>
		<?php
		}
		?>
	<td bgcolor="#f9fab0" border="0"  align="left" valign="top" colspan="2">
	Автор: <b>
	<?php
	if ($numFoto == 1)
  $author = $this->photoInfo['zayavka']['author_foto1'];
else if ($numFoto == 2)
  $author = $this->photoInfo['zayavka']['author_foto2'];
else if ($numFoto == 3)
  $author = $this->photoInfo['zayavka']['author_foto3'];
  $authorOth = $this->photoInfo['photo']['name'];
  if (!empty($author)) echo $author;
  else echo $authorOth;
    ?>
	</b><br><br>
	Регион: 
		<b><?= $this->photoInfo['photo']['regions'] ?>
	</b>
		</td>
	<?php
	}
	
	public function columnAuthor2() {
		?>
		<td></td>
		<td></td>
	<td align="left" valign="top" colspan="2">
	Автор: <b>
	<?php
  $author = $this->photoInfo['zayavka']['author_foto2'];
  $authorOth = $this->photoInfo['photo']['name'];
  if (!empty($author)) echo $author;
  else echo $authorOth;
  ?>
	</b>
		</td>
	<?php
	}
	
	public function columnAuthor2_top() {
		?>
		<td background="assets/images/logo/star_top1.png" align="center" valign="top"><b><?= $this->photoInfo['zayavka']['id'] ?>/<?= $this->photoInfo['photo']['num'] ?>/<?= $this->photoInfo['photo']['numInList'] ?></b></td>
		
		<td border="0" height="90px" background="assets/images/logo/star_top1.png"></td>
	<td bgcolor="#f9fab0" border="0"  align="left" valign="top" colspan="2">
	Автор: <b>
	<?php
  $author = $this->photoInfo['zayavka']['author_foto2'];
  $authorOth = $this->photoInfo['photo']['name'];
  if (!empty($author)) echo $author;
  else echo $authorOth;
  ?>
  </b><br><br>
  Регион: 
		<b><?= $this->photoInfo['photo']['regions'] ?>
	</b>
		</td>
	<?php
	}
	
	public function columnAuthor3() {
		?>
		<td></td>
		<td></td>
	<td align="left" valign="top" colspan="2">
	Автор: <b>
	<?php
  $author = $this->photoInfo['zayavka']['author_foto3'];
  $authorOth = $this->photoInfo['photo']['name'];
  if (!empty($author)) echo $author;
  else echo $authorOth;
  ?>
	</b>
		</td>
	<?php
	}
	
	public function columnAuthor3_top() {
		?>
		<td background="assets/images/logo/star_top1.png" align="center" valign="top"><b><?= $this->photoInfo['zayavka']['id'] ?>/<?= $this->photoInfo['photo']['num'] ?>/<?= $this->photoInfo['photo']['numInList'] ?></b></td>
		
		<td border="0" height="90px"  background="assets/images/logo/star_top1.png"></td>
	<td bgcolor="#f9fab0" border="0"  align="left" valign="top" colspan="2">
	Автор: <b>
	<?php
  $author = $this->photoInfo['zayavka']['author_foto3'];
  $authorOth = $this->photoInfo['photo']['name'];
  if (!empty($author)) echo $author;
  else echo $authorOth;
  ?>
  </b><br><br>
  Регион: 
		<b><?= $this->photoInfo['photo']['regions'] ?>
	</b>
		</td>
	<?php
	}
	
	public function columnRegions(){
				?>
		<td></td>
		<td></td>
	<td align="left" valign="top" colspan="2">
	Регион: 
		<?= $this->photoInfo['photo']['regions'] ?>
		</td>
	<?php
	}
	
    public function column1() {
        ?>
        <td align="center" valign="top"><b><?= $this->photoInfo['zayavka']['id'] ?>/<?= $this->photoInfo['photo']['num'] ?>/<?= $this->photoInfo['photo']['numInList'] ?></b></td>
        <?php
    }
	
	public function column1_new() {
        ?>
		<tr>
        <td  background="assets/images/logo/star_top1.png" align="center" valign="top"></td>
        <?php
    }
	
	
	
	public function column1_new_result() {
        ?>
		
        <td  background="assets/images/logo/star_top1.png" align="center" valign="top"></td>
        <?php
    }
	
	public function column1_new_result2() {
        ?>
		
        <td  background="assets/images/logo/star_top2.png" align="center" valign="top"></td>
        <?php
    }
	
	public function column1_new_result3() {
        ?>
		
        <td  background="assets/images/logo/star_top3.png" align="center" valign="top"></td>
        <?php
    }
	
	public function column1_new_result4() {
        ?>
		
        <td  background="assets/images/logo/star_top4.png" align="center" valign="top"></td>
        <?php
    }
	
	public function column1_new_result5() {
        ?>
		
        <td  background="assets/images/logo/star_top5.png" align="center" valign="top"></td>
        <?php
    }
	
	 public function column1_3() {
        ?>
		<tr>
        <td align="center" valign="top"><b><?= $this->photoInfo['zayavka']['id'] ?></td><td><?= $this->photoInfo['photo']['num'] ?></td>
		<td><?= $this->photoInfo['photo']['numInList'] ?></b></td>
		</tr>
        <?php
    }

    public function column2() {
        ?>
        <td class="zero_padding" align="center" valign="top" >
            <?php ImageWork::ShowImageBigSize($this->photoInfo['photo']['link'], 1, 1); ?>
        </td>
        <?php
    }
	
	public function column2_new() {
        ?>
        <td class="zero_padding"  background="assets/images/logo/star_top1.png" align="center" valign="top" >
            <?php ImageWork::ShowImageBigSize($this->photoInfo['photo']['link'], 1, 1); ?>
        </td>
		<td background="assets/images/logo/star_top1.png" align="center" valign="top"></td>
		</tr>
        <?php
    }
	
	public function column2_new_result() {
        ?>
        <td class="zero_padding"  background="assets/images/logo/star_top1.png" align="center" valign="top" >
            <?php ImageWork::ShowImageBigSize($this->photoInfo['photo']['link'], 1, 1); ?>
        </td>
		<td width="20px" background="assets/images/logo/star_top1.png" align="center" valign="top"></td>
		
        <?php
    }
	
		
	public function column3() {
        ?>
        <td align="center" valign="top">
		<b>
            <?= $this->photoInfo['photo']['photosName'] ?>
        </b>
		</td>
        <?php
    }
	
	public function column3_new() {
        ?>
		<tr><td></td>
        <td  align="center" valign="top">
		<b>
            <?= $this->photoInfo['photo']['photosName'] ?>
        </b>
		</td><td></td></tr>
        <?php
    }
	
	public function column3_new_result() {
        ?>
		<td class="zero_padding"  background="assets/images/logo/star_top1.png" align="center" valign="top"></td>
		<td class="zero_padding"  background="assets/images/logo/star_top1.png" align="center" valign="top">
		<b>
            <?= $this->photoInfo['photo']['photosName'] ?>
        </b>
		</td>
		<td class="zero_padding"  background="assets/images/logo/star_top1.png" align="center" valign="top"></td>
        <?php
    }

    public function hr() {
        echo '<tr height="6px"><td colspan="4"><hr style="color:#B2B2B2"></td></tr>';
    }

}
