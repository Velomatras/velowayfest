<?php

class LibraryEntry extends Pohod {
    const OTCHET_LINK_OK_STATUS = 0;
    const OTCHET_LINK_BAD_STATUS = 2;


    static public $db_table_name = 'way_library';
    static public $YEAR_TAG = '';
    static public $COVER_IMG_SAVE_PATH = '/assets/images/way-library';
    static public $CoverImgLongestDimension = 1000;

    public function __construct($entryData) {
        $this->data = $entryData;
    }

}
