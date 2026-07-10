<?php

class ZayavkaLibrary extends Pohod {
	
	const MIN_START_DATE_FOR_VELOTRIPS = '01.01.2020';
    const MIN_START_DATE = '01.01.2021';

       static public $db_table_name = 'way_library';
    static public $YEAR_TAG = 'no_';
    static public $COVER_IMG_SAVE_PATH = '/assets/images/way-no_';
    static public $PHOTO_SAVE_PATH = '/assets/images/way-no_/_photos';
    
    public $photosLinks;

    	public function defineClass() {
        $duration = Period::get_trip_duration($this->data['period']);
		if ($duration < 3)
            $class = 'ПВД';
        elseif (($duration > 3) and ( $duration < 10))
            $class = 'Короткие велопоходы';
        elseif (($duration >= 10) and ( $duration <= 16))
            $class = 'Велопоходы';
        elseif (($duration >= 17) and ( $duration <= 28))
            $class = 'Длительные велопоходы';
        elseif ($duration > 28)
            $class = 'Велопутешествия';
        // $this->data['class'] = $class;
    }
	
	
	public function save() {
        $db = new MyCRUD_Modx(static::$db_table_name);
        $this->zayavkaNum = $db->insert($this->data);
        return $this->zayavkaNum;
    }

    public function update($zayavkaNum) {
        if (empty($this->data)) {
            return;
        }
        $db = new MyCRUD_Modx(static::$db_table_name);
        $db->update(Array('id' => $zayavkaNum), $this->data);
		//$db->update(Array('idz' => $zayavkaNum), $this->data);
    }

}
?>
