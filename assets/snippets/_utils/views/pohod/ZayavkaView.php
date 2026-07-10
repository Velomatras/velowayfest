<?php

class ZayavkaView {

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
            <th>Маршрут (регион) /<br> Описание</th>
            <th>Автор отчёта /<br> Организатор /<br>Сроки/ Команда/<br>Класс </th>
            <th width="100px">Статус / Модератор <br></th>
        </tr>
		
        <?php
    }

    public function headerType1_StatNomResult($resultName = '') {
	$this->hr5();	
        ?>
        <tr>
            <th>Результат</th>
            <th width="150px">№ Заявки</th>
            <th>Маршрут/<br> Описание</th>
            <th>Автор отчёта /<br> Организатор /<br>Сроки/ Команда/<br>Класс </th>
            <?php if (!empty($resultName)) {
                echo "<th>$resultName</th>";
            }
            ?>
        </tr>
		        <?php
				$this->hr5();
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
	public function headerType5() {
        ?>
        <tr>
		    <th>Результат</th>
            <th width="150px">№ Заявки</th>
            <th>Маршрут /<br> Описание</th>
            <th>Организатор /<br>Сроки</th>
            <th width="100px">Число голосов</th
        </tr>
        <?php
    }
	public function headerType6() {
        ?>
        <tr>
            <th>Результат</th>
            <th>№ Заявки</th>
            <th>Описание</th>
            <th>Автор</th>
            <th>Средняя оценка ФИНАЛА</th>
			<th>Средняя оценка отбороч. этапа</th>
            <th>Число оценок зрителей</th>
            <th>Количество учтённых оценок*</th>
        </tr>
        <?php
    }

    public function column1() {
        ?>
        <td bgcolor="#edf6e3" align="center" valign="top"><b><?= $this->zayavka->data['id'] ?></b>
            <?php out_cover_image($this->zayavka->data['pic_upload'], $this->zayavka->getCoverImgSavePath(), $this->zayavka->data['id'],
                    $this->zayavka->data['pic'], $this->zayavka->data['description'], $this->zayavka->data['name']); ?>
        </td>
        <?php
    }
	
		
	public function column1_top() {
        ?>
        <td class="zero_padding" background="assets/images/logo/star5.png" align="center" valign="top"><b><?= $this->zayavka->data['id'] ?></b>
            <?php out_cover_image($this->zayavka->data['pic_upload'], $this->zayavka->getCoverImgSavePath(), $this->zayavka->data['id'],
                    $this->zayavka->data['pic'], $this->zayavka->data['description'], $this->zayavka->data['name']); ?>
        </td>
        <?php
    }
	
	 public function column1_video() {
        ?>
        <td align="center" valign="top"><b><?= $this->zayavka->data['id'] ?></b>
            <?php out_cover_image($this->zayavka->data['pic_upload'], $this->zayavka->getCoverImgSavePath(), $this->zayavka->data['id'],
                    $this->zayavka->data['pic'], $this->zayavka->data['description'], $this->zayavka->data['author_video']); ?>
        </td>
        <?php
    }
	
	public function column_flag() {
	
			$test = '';
			$regStroke = getRegionName($this->zayavka->data['region']);
			$regFlag = explode(',', $regStroke);
			$regSum = 0; // стран похода
			//$url_flag = "http://www.veloway.su/assets/images/flags/"."Россия".".gif";
			// Отобразить флаги посещённых стран
							foreach ($regFlag as $flag){
					$url_flag = "assets/images/flags/".$flag.".gif";
					$regSum = $regSum + 1;
					
					$test.= $flag ;
					?>
										<style>
										.frameFlag
   {
    border: 3px solid #f5fc80;
   }
  </style>
					<img src="<?= $url_flag ?>" title="<?= $flag ?>" width="40" height="22" alt="country flag image" class="frameFlag">
					<?php
				}
							
			?>
			<br>
			<?php
	}
	
	public function nominationsName() {
		$nomR = $this->nominationsRus2($this->zayavka->data['nominations']);
		
		?>
		
		Номинации: <?= $nomR?>
		<br><br>
		<?php
	}

    public function column2() {
        ?>
        <td>
            <a href="<?= $this->zayavkaDetailsURL . '?idz=' . $this->zayavka->data['id'] ?>" target="_blank"
               title="<?= getRegionsNames($this->zayavka->data['region']) ?> "> <?= $this->zayavka->data['route'] ?> </a><br><br>
			   <?= $this->column_flag(); ?>
			   <?= $this->zayavka->data['mileage'] ?> км <br><br>
            <?= $this->zayavka->data['description'] ?><br>
        </td>
        <?php
    }
	
	public function column2_expert() {
        ?>
        <td bgcolor="#edf6e3">
            <a href="<?= $this->zayavkaDetailsURL . '?idz=' . $this->zayavka->data['id'] ?>" target="_blank"
               title="<?= getRegionsNames($this->zayavka->data['region']) ?> "> <?= $this->zayavka->data['route'] ?> </a><br><br>
			   <?= $this->column_flag(); ?>
			   <?= $this->zayavka->data['mileage'] ?> км <br><br>
            <?= $this->zayavka->data['description'] ?><br>
        </td>
        <?php
    }
	
	public function column2_expert_top() {
        ?>
        <td background="assets/images/logo/star5_k.png">
            <a href="<?= $this->zayavkaDetailsURL . '?idz=' . $this->zayavka->data['id'] ?>" target="_blank"
               title="<?= getRegionsNames($this->zayavka->data['region']) ?> "> <?= $this->zayavka->data['route'] ?> </a><br><br>
			   <?= $this->column_flag(); ?>
			   <?= $this->zayavka->data['mileage'] ?> км <br><br>
            <?= $this->zayavka->data['description'] ?><br>
        </td>
        <?php
    }
	
	//Вывод регионов и названий номинаций!
	 public function column2b() {
        ?>
        <td>
            <a href="<?= $this->zayavkaDetailsURL . '?idz=' . $this->zayavka->data['id'] ?>" target="_blank"
               title="<?= getRegionsNames($this->zayavka->data['region']) ?> "> <?= $this->zayavka->data['route'] ?> </a><br><br>
			   <?= $this->column_flag(); ?>
			   <br>Регионы: <?= getRegionsNames($this->zayavka->data['region']) ?>
			   <br><br>
			   <?= $this->nominationsName(); ?>
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
			   <?= $this->column_flag(); ?>
            <?= $this->zayavka->data['mileage'] ?> км <br><br>
        </td>
        <?php
    }

	
	public function row_Description_forMap() {
		?>
		<td colspan="3">
		<?= $this->zayavka->data['description'] ?><br>
		</td>
		<?php
	}
	
    public function column3() {
        ?>
        <td align="center" valign="top">
            <b><?= $this->zayavka->data['name'] ?></b><br>
			 ( <?= $this->zayavka->data['city'] ?> )<br><br>
			<?php
		   if (!empty($this->zayavka->data['name2'])){
		   ?>
		   организатор: <?= $this->zayavka->data['name2'] ?> <br><br>
		   <?php
		   }
		   ?>
           
            <?= $this->zayavka->data['period'] . '<br>(' . get_trip_duration_text($this->zayavka->data['period']) . ')' ?>
            <br><br>
			<?= $this->zayavka->data['command'] ?><br><br>
            <div style="color:#666666">
                <?= $this->zayavka->data['class'] ?>
            </div>
            <a href="<?= $this->zayavkaDetailsURL . '?idz=' . $this->zayavka->data['id'] ?>" target="_blank">Комментарии <?= $this->zayavka->calc_comments() ?> </a>
        </td>
        <?php
    }
	
	public function column3_expert() {
        ?>
        <td bgcolor="#edf6e3" align="center" valign="top">
            <b><?= $this->zayavka->data['name'] ?></b><br>
			 ( <?= $this->zayavka->data['city'] ?> )<br><br>
			<?php
		   if (!empty($this->zayavka->data['name2'])){
		   ?>
		   организатор: <?= $this->zayavka->data['name2'] ?> <br><br>
		   <?php
		   }
		   ?>
           
            <?= $this->zayavka->data['period'] . '<br>(' . get_trip_duration_text($this->zayavka->data['period']) . ')' ?>
            <br><br>
			<?= $this->zayavka->data['command'] ?><br><br>
            <div style="color:#666666">
                <?= $this->zayavka->data['class'] ?>
            </div>
            <a href="<?= $this->zayavkaDetailsURL . '?idz=' . $this->zayavka->data['id'] ?>" target="_blank">Комментарии <?= $this->zayavka->calc_comments() ?> </a>
        </td>
        <?php
    }
	
	public function column3_expert_top() {
        ?>
        <td background="assets/images/logo/star5.png" align="center" valign="top">
            <b><?= $this->zayavka->data['name'] ?></b><br>
			 ( <?= $this->zayavka->data['city'] ?> )<br><br>
			<?php
		   if (!empty($this->zayavka->data['name2'])){
		   ?>
		   организатор: <?= $this->zayavka->data['name2'] ?> <br><br>
		   <?php
		   }
		   ?>
           
            <?= $this->zayavka->data['period'] . '<br>(' . get_trip_duration_text($this->zayavka->data['period']) . ')' ?>
            <br><br>
			<?= $this->zayavka->data['command'] ?><br><br>
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
        <?= htmlspecialchars_decode($this->zayavka->data['description'], ENT_QUOTES) ?>
    </td>
    <?php
    }
	
	public function column2_video_top() {
    ?>
    <td background="assets/images/logo/star5.png">
        <div class="zero_padding">
		<img src="assets/images/logo/fire.png" align="left" width="50px" /><br><br>
        <h3><a href="<?= $this->zayavka->data['video_url'] ?>" target="_blank">Ссылка на видео</a></h3>
        <br></div>
        <?= htmlspecialchars_decode($this->zayavka->data['description'], ENT_QUOTES) ?>
    </td>
    <?php
    }
	
	 public function column2_videoLong() {
    ?>
    <td bgcolor="#edf6e3">
        <br><br>
        <h3><a href="<?= $this->zayavka->data['videoLong_url'] ?>" target="_blank">Ссылка на видео</a></h3>
        <br>
        <?= htmlspecialchars_decode($this->zayavka->data['description'], ENT_QUOTES) ?>
    </td>
    <?php
    }
	
	 public function column2_videoLong_top() {
    ?>
    <td background="assets/images/logo/star5.png">
        <div class="zero_padding">
		<img src="assets/images/logo/fire.png" align="left" width="50px" /><br><br>
        <h3><a href="<?= $this->zayavka->data['videoLong_url'] ?>" target="_blank">Ссылка на видео</a></h3>
        <br></div>
        <?= htmlspecialchars_decode($this->zayavka->data['description'], ENT_QUOTES) ?>
    </td>
    <?php
    }
	
	public function column2_exciting() {
    ?>
    <td bgcolor="#edf6e3">
        <br><br>
        <h3><a href="<?= $this->zayavka->data['link'] ?>" target="_blank">Ссылка на отчет</a></h3>
        <br>
		<?= $this->column_flag(); ?>
		 <br>
        <?= htmlspecialchars_decode($this->zayavka->data['description'], ENT_QUOTES) ?>
    </td>
    <?php
    }
	
	public function column2_exciting_top() {
    ?>
    <td background="assets/images/logo/star5_k.png">
        <div class="zero_padding">
		<img src="assets/images/logo/fire.png" align="left" width="50px" /><br><br>
        <h3><a href="<?= $this->zayavka->data['link'] ?>" target="_blank">Ссылка на отчет</a></h3>
        <br>
		<?= $this->column_flag(); ?>
		 <br></div>
        <?= htmlspecialchars_decode($this->zayavka->data['description'], ENT_QUOTES) ?>
    </td>
    <?php
    }

    public function column3_video() {
		if (!empty($this->zayavka->data['author_video'])) {
    ?>
        <td align="center"><b><?= $this->zayavka->data['author_video'] ?></b></td>
    <?php
		}
		else {
			?>
        <td align="center"><b><?= $this->zayavka->data['name'] ?></b></td>
    <?php
		}
    }
	
	public function column3_video_top() {
		if (!empty($this->zayavka->data['author_videoLong'])) {
    ?>
        <td background="assets/images/logo/star5.png" align="center"><b><?= $this->zayavka->data['author_video'] ?></b></td>
    <?php
		}
		else {
			?>
        <td background="assets/images/logo/star5.png" align="center"><b><?= $this->zayavka->data['name'] ?></b></td>
    <?php
		}
    }
	
	public function column3_videoLong() {
		if (!empty($this->zayavka->data['author_videoLong'])) {
    ?>
        <td bgcolor="#edf6e3" align="center"><b><?= $this->zayavka->data['author_videoLong'] ?></b></td>
    <?php
		}
		else {
			?>
        <td align="center"><b><?= $this->zayavka->data['name'] ?></b></td>
    <?php
		}
    }
	
	
	
	public function column3_videoLong_top() {
		if (!empty($this->zayavka->data['author_videoLong'])) {
    ?>
        <td background="assets/images/logo/star5.png" align="center"><b><?= $this->zayavka->data['author_videoLong'] ?></b></td>
    <?php
		}
		else {
			?>
        <td background="assets/images/logo/star5.png" align="center"><b><?= $this->zayavka->data['name'] ?></b></td>
    <?php
		}
    }
	
	public function column3_exciting() {
		
			?>
        <td bgcolor="#edf6e3" align="center"><b><?= $this->zayavka->data['name'] ?></b></td>
    <?php
		
    }
	
	public function column3_exciting_top() {
		
			?>
        <td class="zero_padding" background="assets/images/logo/star5.png" align="center"><b><?= $this->zayavka->data['name'] ?></b></td>
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
	
	//с именами номинаций
	public function row2() {
        echo '<tr>';
        $this->column1();
		$this->column2b();
        $this->column3();
        $this->column4();
        echo '</tr>';
    }

    public function row_StatNomResult($resultValue = null) {
        echo '<tr>';
        $this->placeColumn();
        $this->column1();
        $this->column2_expert();
        $this->column3_expert();
        if (!empty($resultValue)){
            
            //echo '<span style=\"color: red\">';
            print_rate_red(round($resultValue));
			//echo '</span>';
			
        }
        echo '</tr>';
    }
	
	 public function row_StatNomResult_top($resultValue = null) {
        echo '<tr>';
        $this->placeColumn();
        $this->column1_top();
        $this->column2_expert_top();
        $this->column3_expert_top();
        if (!empty($resultValue)){
            
            
            print_rate_red(round($resultValue));
			
			
        }
        echo '</tr>';
    }

	public function row_forMap() {
        echo '<tr>';
        $this->column1();
        $this->column2_noDescription();
        $this->column3();
         echo '</tr>';
		 echo '<tr>';
		 $this->row_Description_forMap();
		 echo '</tr>';
    }
	
    

    public function hr() {
        echo '<tr height="6px"><td colspan="4"><hr style="color:#B2B2B2"></td></tr>';
    }
	public function hr7() {
        echo '<tr height="6px"><td colspan="7"><hr style="color:#B2B2B2"></td></tr>';
    }
	public function hr8() {
        echo '<tr height="6px"><td colspan="8"><hr style="color:#B2B2B2"></td></tr>';
    }
	public function hr5() {
        echo '<tr height="6px"><td colspan="5"><hr style="color:#B2B2B2"></td></tr>';
    }
	 public function hr2() {
        echo '<tr height="6px"><td colspan="3"><hr style="color:#B2B2B2"></td></tr>';
    }
	public function recom() {
        echo '<tr><td></td><td colspan="3"><b><img src="assets/images/golosovanie/recomm.png" hspace="30" vspace="30" alt="Смайл" width="30" height="30" 
  align="middle">          Рекомендуется!</img></b></td></tr>';
    }
	
	public function final_smile() {
        echo '<tr><td></td><td colspan="3"><b><img src="assets/images/golosovanie/recomm.png" hspace="30" vspace="30" alt="Смайл" width="30" height="30" 
  align="middle">          Участник финального этапа!</img></b></td></tr>';
    }

	public function UR_exists($url){
   $headers=get_headers($url);
   return stripos($headers[0],"200 OK")?true:false;
}
	public function idZayavka (){
		$id = $this->zayavka->data['id'];
		return $id;
	}
	public function nominationsRus2 ($nomRus){
	  	 $nomSearch = array("hard", "original", "report", "quote", "exciting", "informative", "autonome", "unusual", 
	"children", "unfortun", "video", "movie", "debut", "pik99", "snar", "photo", "~~");
	     $nomReplace = array("сложность", "оригинальность", "отчёт", "цитата", "увлекательность", "познавательность", "автономность", "необычность",
    "дети", "приключения", "видеоролик", "фильм", "дебют", "фото ПИК-99", "фото Снаряжение", "фотоконкурс", ", " );
	      $nomR = str_replace($nomSearch, $nomReplace, $nomRus);
    
return 	$nomR;	
  }
}
?>
