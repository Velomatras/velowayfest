<?php

abstract class Pohod {
    static public $db_table_name;
    static public $YEAR_TAG;
    static public $COVER_IMG_SAVE_PATH;
    public $data = Array();

    public function getCoverImgSavePath() {
        return static::$COVER_IMG_SAVE_PATH;
    }
    public function getDBName() {
        return static::$db_table_name;
    }

    public function uploadCoverPic($uploadFieldInputName, $zayavkaNum) {
        if (uploadCoverPic($uploadFieldInputName, $zayavkaNum, static::$COVER_IMG_SAVE_PATH))
            $this->data['pic_upload'] = '1';
    }

    public function clear() {
        $this->data = Array();
    }

    public function load($zayavkaNum) {
		global $mysqli;
        $db = new MyCRUD_Modx(static::$db_table_name, $mysqli);
        $this->data = $db->getRow(Array('id' => $zayavkaNum));
    }

    public function save() {
		global $mysqli;
        $db = new MyCRUD_Modx(static::$db_table_name, $mysqli);
        $this->zayavkaNum = $db->insert($this->data);
        return $this->zayavkaNum;
    }

    public function update($zayavkaNum) {
		global $mysqli;
        if (empty($this->data)) {
            return;
        }
        $db = new MyCRUD_Modx(static::$db_table_name, $mysqli);
        $db->update(Array('id' => $zayavkaNum), $this->data);
    }

    public function delete($zayavkaNum) {
		global $mysqli;
        if (!$zayavkaNum)
            return;
        $db = new MyCRUD_Modx(static::$db_table_name, $mysqli);
        $db->delete(Array('id' => $zayavkaNum), $this->data);
    }

    static public function getNewestZayavkaNum() {
		global $mysqli;
        $db = new MyCRUD_Modx(static::$db_table_name, $mysqli);
        return $db->getAutoincrementValue();
    }

    /**
     * @return type array
     */
    public function getTrackLinks() {
        return DBDataWork::unpackArray($this->data['track_link']);
    }
	
	public function getQuote() {
        return DBDataWork::unpackArray($this->data['quote']);
    }

    public function calc_comments() { // количество комментариев к походу
        //$commNum = 0;
		global $mysqli;
        $commentDB = new MyCRUD_Modx('jot_content', $mysqli);
        $commNum = $commentDB->getRowsNum(Array('uparent' => $this->data['id'], 'tagid' => static::$YEAR_TAG));

        if (!empty($this->data['comments'])) {
            $commNum++;   // учитываем также авторский комментарий
        }

        return $commNum;
    }
}
