<?php

class Zayavka2024 extends Zayavka {

    const MIN_START_DATE_FOR_VELOTRIPS = '01.01.2023';
    const MIN_START_DATE = '01.01.2024';

    static public $db_table_name = 'way_library';
    static public $YEAR_TAG = '2024';
    static public $COVER_IMG_SAVE_PATH = '/assets/images/way-2024';
    static public $PHOTO_SAVE_PATH = '/assets/images/way-2024/_photos';
    static protected $Nominations = Array(
        Array("Самый сложный поход", "hard"),
        Array("Самый оригинальный маршрут", "original"),
        Array("Лучший отчёт", "report"),
        // Array("Приз зрительских симпатий", "viewers"),        
        Array("Лучшая походная фотография", "photo"),
		//Array("Фотоконкурс от ПИК-99", "pik99"),
		//Array("Фотоконкурс от Снаряжение", "snar"),
        Array("Лучший видеоролик о походе", "video"),
		Array("Лучший фильм о походе", "movie"),
		Array("Видеолекция", "lecture"),
		Array("Лучшая цитата ВелоПути", "quote"),
        Array("Самый увлекательный отчёт", "exciting"),
        //Array("Самый продолжительный маршрут", "lasting"),
        //Array("Самый длинный маршрут", "longest"),
        //Array("Самый скоростной поход", "speedy"),
        Array("Самый познавательный поход", "informative"),
        Array("Самый автономный маршрут", "autonome"),
        Array("Самый необычный велопоход", "unusual"),
        Array("Лучший велопоход с детьми", "children"),
        Array('Самый приключенческий поход', "unfortun"),
		Array('Самый зимний поход', "winter"),
		Array('Лучший дебют', "debut"),
    );
    public $photosLinks;
	
	public function update($zayavkaNum) {
		global $mysqli;
        if (empty($this->data)) {
            return;
        }
		$id = $mysqli->insert_id;
		$id++;
		$result = $modx->db->update( $this->data, static::$db_table_name, 'id = "' . $id . '"' ); 
        //$db = new MyCRUD_Modx(static::$db_table_name, $mysqli);
       // $db->update(Array('id' => $zayavkaNum), $this->data);
    }


//Присваивает класс заявки
    public function defineClass() {
		$durMile = $this->data['mileage'];
        $duration = Period::get_trip_duration($this->data['period']);
		$stop = 0;
		if ($duration <= 3) {
			$class = 'ПВД';
		$stop = 1;
		}
        elseif ($duration > 28) {
            $class = 'Велопутешествия';
			$stop = 1;
		}
		if ($durMile < 400 && $stop == 0 )
		//(($duration > 3) and ( $duration < 11))
            $class = 'Короткие велопоходы';
        elseif (($durMile <= 800 && $durMile >= 400) && $stop == 0 )
		//(($duration >= 11) and ( $duration <= 16))
            $class = 'Велопоходы';
        elseif ($durMile > 800 && $stop == 0)  $class = 'Длинные велопоходы';
		//($duration <= 3)
		//	$class = 'ПВД';
		//(($duration >= 17) and ( $duration <= 28))
                   //elseif ($duration > 28)
           
        $this->data['class'] = $class;
    }

//Присваивает начальный статус (информирует если заявка не будет допушщена в судейские номинации)
    public function defineStatus($class) {
        $dates = Period::getDates($this->data['period']);
		$duration = Period::get_trip_duration($this->data['period']);
        if (( strtotime($dates[1]) < strtotime(self::MIN_START_DATE) && !( strtotime($dates[0]) >= strtotime(self::MIN_START_DATE_FOR_VELOTRIPS) &&
		($class == 'Велопутешествия' || duration >= 17)))
			|| $duration < 4 ) {
            $this->data['status'] = ZayavkaStatus::WAITING_FOR_VIEWERS_VOTING;
			$str = true;
            return $str;
        }
        $this->data['status'] = ZayavkaStatus::WAITING_FOR_APPROVE;
		$str = false;
		return $str;
    }
	
		
	function printNominationsSelector2($zayavkaType, $selectedValues = Array()) {
    $nominations = $zayavkaType::getNominationsInfo();
	$this->defineClass();
	$warning = $this->defineStatus($this->data['class']);
	$i = 1;
    foreach ($nominations as $name => $description) {
		
		GUIHelpers::getCheckbox('nominations[]', $name, in_array($name, $selectedValues));
		if ($warning && $i++ < 4) {
			echo "<strike>";
			echo $description;
			echo "</strike>";
		}
		
else echo $description;

		        cr();
    }
}
	

//снимает галку участия при выборе определённых статусов.	
    public function defineViewersNomination($status) {
        if ( $status == ZayavkaStatus::WAITING_FOR_VIEWERS_VOTING || $status == ZayavkaStatus::APPROVED_FOR_VIEWERS_VOTING){
//            $this->data['nominations'] = 'viewers';
            $this->removeFromNomination("hard");
            $this->removeFromNomination("original");
            $this->removeFromNomination("report");
        }
		if ($status == ZayavkaStatus::APPROVED_FOR_LIBRARY){
			$this->removeFromNomination("hard");
            $this->removeFromNomination("original");
            $this->removeFromNomination("report");
			$this->removeFromNomination("photo");
			$this->removeFromNomination("video");
			$this->removeFromNomination("movie");
			$this->removeFromNomination("quote");
			$this->removeFromNomination("exciting");
			$this->removeFromNomination("lasting");
			$this->removeFromNomination("longest");
			$this->removeFromNomination("speedy");
			$this->removeFromNomination("informative");
			$this->removeFromNomination("autonome");
			$this->removeFromNomination("unusual");
			$this->removeFromNomination("children");
			$this->removeFromNomination("unfortun");
			$this->removeFromNomination("debut");
			$this->removeFromNomination("lecture");
			$this->removeFromNomination("winter");
			
		}
    }
	
	//Считает число номинаций учитываемых в Гран-При
	public function getNominationsNumBest() {
		$nominations = DBDataWork::unpackArray($this->data['nominations']);
		$nom = count(DBDataWork::unpackArray($this->data['nominations']));
		$ext = 0; //число номинаций видео
		$ext2 = 0;
		foreach ($nominations as $name => $description) {
			if ($description == "video" || $description == "movie" || $description == "lecture") $ext++;
			if ($description == "quote" || $description == "debut") $ext2++; 
		}
		if ($ext > 1) $nomBest = $nom - ($ext - 1) - $ext2;
		else $nomBest = $nom - $ext2;
	
        return $nomBest;
    }

    /**
     * update приз зрит симпатий
     * skips zayavka class detection
     * @param type $status
     */
    public function updatePzs($zayavkaNum, $pzs)
    {
        $data = Array();
        $data['pzs'] = $pzs;
        $db = new MyCRUD_Modx(static::$db_table_name);
        $db->update(Array('id' => $zayavkaNum), $data);
    }
	public function updateDiff($zayavkaNum, $diff)
    {
        $data = Array();
        $data['rate_diff'] = $diff;
        $db = new MyCRUD_Modx(static::$db_table_name);
        $db->update(Array('id' => $zayavkaNum), $data);
    }
	public function updateOrg($zayavkaNum, $org)
    {
        $data = Array();
        $data['rate_org'] = $org;
        $db = new MyCRUD_Modx(static::$db_table_name);
        $db->update(Array('id' => $zayavkaNum), $data);
    }
	public function updateOtch($zayavkaNum, $otch)
    {
        $data = Array();
        $data['rate_otch'] = $otch;
        $db = new MyCRUD_Modx(static::$db_table_name);
        $db->update(Array('id' => $zayavkaNum), $data);
    }
	public function updateInf($zayavkaNum, $inf)
    {
        $data = Array();
        $data['rate_inf'] = $inf;
        $db = new MyCRUD_Modx(static::$db_table_name);
        $db->update(Array('id' => $zayavkaNum), $data);
    }
	public function updateAut($zayavkaNum, $aut)
    {
        $data = Array();
        $data['rate_aut'] = $aut;
        $db = new MyCRUD_Modx(static::$db_table_name);
        $db->update(Array('id' => $zayavkaNum), $data);
    }
	public function updateChi($zayavkaNum, $chi)
    {
        $data = Array();
        $data['rate_chi'] = $chi;
        $db = new MyCRUD_Modx(static::$db_table_name);
        $db->update(Array('id' => $zayavkaNum), $data);
    }
	public function updateUnu($zayavkaNum, $unu)
    {
        $data = Array();
        $data['rate_unu'] = $unu;
        $db = new MyCRUD_Modx(static::$db_table_name);
        $db->update(Array('id' => $zayavkaNum), $data);
    }
	public function updateUnf($zayavkaNum, $unf)
    {
        $data = Array();
        $data['rate_unf'] = $unf;
        $db = new MyCRUD_Modx(static::$db_table_name);
        $db->update(Array('id' => $zayavkaNum), $data);
    }
	public function updateFoto_1($zayavkaNum, $foto1)
    {
        $data = Array();
        $data['rate_foto_1'] = $foto1;
        $db = new MyCRUD_Modx(static::$db_table_name);
        $db->update(Array('id' => $zayavkaNum), $data);
    }
	public function updateFoto_2($zayavkaNum, $foto2)
    {
        $data = Array();
        $data['rate_foto_2'] = $foto2;
        $db = new MyCRUD_Modx(static::$db_table_name);
        $db->update(Array('id' => $zayavkaNum), $data);
    }
	public function updateFoto_3($zayavkaNum, $foto3)
    {
        $data = Array();
        $data['rate_foto_3'] = $foto3;
        $db = new MyCRUD_Modx(static::$db_table_name);
        $db->update(Array('id' => $zayavkaNum), $data);
    }
	public function updateVideo($zayavkaNum, $video)
    {
        $data = Array();
        $data['rate_video'] = $video;
        $db = new MyCRUD_Modx(static::$db_table_name);
        $db->update(Array('id' => $zayavkaNum), $data);
    }
	public function updateVideoLong($zayavkaNum, $videoLong)
    {
        $data = Array();
        $data['rate_videoLong'] = $videoLong;
        $db = new MyCRUD_Modx(static::$db_table_name);
        $db->update(Array('id' => $zayavkaNum), $data);
    }
	public function updateExc($zayavkaNum, $exc)
    {
        $data = Array();
        $data['rate_exciting'] = $exc;
        $db = new MyCRUD_Modx(static::$db_table_name);
        $db->update(Array('id' => $zayavkaNum), $data);
    }
	public function updateComm_exciting($zayavkaNum, $exc)
    {
        $data = Array();
        $data['comm_exciting'] = htmlspecialchars($exc, ENT_QUOTES);
        $db = new MyCRUD_Modx(static::$db_table_name);
        $db->update(Array('id' => $zayavkaNum), $data);
    }
	public function updateComm_video($zayavkaNum, $exc)
    {
        $data = Array();
        $data['comm_video'] = htmlspecialchars($exc, ENT_QUOTES);
        $db = new MyCRUD_Modx(static::$db_table_name);
        $db->update(Array('id' => $zayavkaNum), $data);
    }
	public function updateComm_foto1($zayavkaNum, $exc)
    {
        $data = Array();
        $data['comm_foto1'] = htmlspecialchars($exc, ENT_QUOTES);
        $db = new MyCRUD_Modx(static::$db_table_name);
        $db->update(Array('id' => $zayavkaNum), $data);
    }
	public function updateComm_foto2($zayavkaNum, $exc)
    {
        $data = Array();
        $data['comm_foto2'] = htmlspecialchars($exc, ENT_QUOTES);
        $db = new MyCRUD_Modx(static::$db_table_name);
        $db->update(Array('id' => $zayavkaNum), $data);
    }
	public function updateComm_foto3($zayavkaNum, $exc)
    {
        $data = Array();
        $data['comm_foto3'] = htmlspecialchars($exc, ENT_QUOTES);
        $db = new MyCRUD_Modx(static::$db_table_name);
        $db->update(Array('id' => $zayavkaNum), $data);
    }
	public function updateComm_movie($zayavkaNum, $exc)
    {
        $data = Array();
        $data['comm_movie'] = htmlspecialchars($exc, ENT_QUOTES);
        $db = new MyCRUD_Modx(static::$db_table_name);
        $db->update(Array('id' => $zayavkaNum), $data);
    }
	
	
	

}
?>
