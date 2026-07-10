<?php

class Zayavka2019 extends Zayavka {

    const MIN_START_DATE_FOR_VELOTRIPS = '01.01.2018';
    const MIN_START_DATE = '01.01.2019';

    static public $db_table_name = 'way2019';
    static public $YEAR_TAG = '2019';
    static public $COVER_IMG_SAVE_PATH = '/assets/images/way-2019';
    static public $PHOTO_SAVE_PATH = '/assets/images/way-2019/_photos';
    static protected $Nominations = Array(
        Array("Самый сложный поход", "hard"),
        Array("Самый оригинальный маршрут", "original"),
        Array("Лучший отчёт", "report"),
        // Array("Приз зрительских симпатий", "viewers"),        
        Array("Лучшая походная фотография", "photo"),
        Array("Лучший видеоролик о походе", "video"),
        Array("Самый увлекательный отчёт", "exciting"),
        Array("Самый продолжительный маршрут", "lasting"),
        Array("Самый длинный маршрут", "longest"),
        Array("Самый скоростной поход", "speedy"),
        Array("Самый познавательный маршрут", "informative"),
        Array("Самый автономный маршрут", "autonome"),
        Array("Самый необычный велопоход", "unusual"),
        Array("Лучший велопоход с детьми", "children"),
        Array('Самый приключенческий поход', "unfortun"),
        Array('Лучший дебют', "debut"),
    );
    public $photosLinks;

    public function defineClass() {
        $duration = Period::get_trip_duration($this->data['period']);
        if (($duration > 4) and ( $duration < 11))
            $class = 'Короткие велопоходы';
        elseif (($duration >= 11) and ( $duration <= 16))
            $class = 'Велопоходы';
        elseif (($duration >= 17) and ( $duration <= 28))
            $class = 'Длительные велопоходы';
        elseif ($duration > 28)
            $class = 'Велопутешествия';
        $this->data['class'] = $class;
    }

    public function defineStatus($class) {
        $dates = Period::getDates($this->data['period']);
        if ( strtotime($dates[1]) < strtotime(self::MIN_START_DATE) && !( strtotime($dates[0]) >= strtotime(self::MIN_START_DATE_FOR_VELOTRIPS) && $class == 'Велопутешествия') ) {
            $this->data['status'] = ZayavkaStatus::APPROVED_FOR_VIEWERS_VOTING;
            return;
        }
        $this->data['status'] = ZayavkaStatus::WAITING_FOR_APPROVE;
    }

    public function defineViewersNomination($status) {
        if ( $status == ZayavkaStatus::APPROVED_FOR_VIEWERS_VOTING){
//            $this->data['nominations'] = 'viewers';
            $this->removeFromNomination("hard");
            $this->removeFromNomination("original");
            $this->removeFromNomination("report");
        }
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
	public function updateExc($zayavkaNum, $exc)
    {
        $data = Array();
        $data['rate_exciting'] = $exc;
        $db = new MyCRUD_Modx(static::$db_table_name);
        $db->update(Array('id' => $zayavkaNum), $data);
    }

}

