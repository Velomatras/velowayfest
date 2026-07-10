<?php

class Zayavka2015 extends Zayavka {

    static public $db_table_name = 'way2015';
    static public $YEAR_TAG = '2015';
    static public $COVER_IMG_SAVE_PATH = '/assets/images/way-2015';
    static public $PHOTO_SAVE_PATH = '/assets/images/way-2015/_photos';
    static protected $Nominations = Array(
        Array("Самый сложный поход", "hard"),
        Array("Самый оригинальный маршрут", "original"),
        Array("Лучший отчёт", "report"),
        Array("Приз зрительских симпатий", "viewers"),
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
        Array('Самый «удачный» поход', "unfortun")
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

        if ( strtotime($dates[1]) < strtotime('01.01.2015') && !( strtotime($dates[0]) >= strtotime('01.01.2014') && $class == 'Велопутешествия') ) {
            $this->data['status'] = ZayavkaStatus::APPROVED_FOR_VIEWERS_VOTING;
            return;
        }
        $this->data['status'] = ZayavkaStatus::WAITING_FOR_APPROVE;
    }

    public function defineViewersNomination($status) {
        if ( $status == ZayavkaStatus::APPROVED_FOR_VIEWERS_VOTING){
            $this->data['nominations'] = 'viewers';
        }
    }

}

