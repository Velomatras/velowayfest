<?php

class ZayavkaStatus {
        const  WAITING_FOR_APPROVE = '0';
        const  APPROVED = '1';
        const  DECLINED = '-1';
        const  APPROVED_FOR_VIEWERS_VOTING = '-2';
		const  DECLINED_BY_USER = '-3';
		const  WAITING_FOR_VIEWERS_VOTING = '2';
		const  TAKEN = '3';
		const  APPROVED_FOR_LIBRARY = '-4';
		

	private static $STATUSES = Array(
	        self::TAKEN => Array("взята в обработку", "#dd97ee"),
            self::WAITING_FOR_APPROVE => Array("обрабатывается", "#00CCFF"),
			self::WAITING_FOR_VIEWERS_VOTING => Array("обрабатывается (внимание! не допускается в судейские номинации)", "#87e5fc"),
			self::APPROVED_FOR_VIEWERS_VOTING => Array("принята кроме судейских номинаций", "#fcf9a1"),
			self::APPROVED_FOR_LIBRARY => Array("принята только в библиотеку", "#cccccc"),
			self::APPROVED => Array("принята", "#a4f087"),
            self::DECLINED => Array("отклонена", "#ffb9b9"),
			self::DECLINED_BY_USER => Array("отклонена по просьбе участника", "#ffb9b9")
           
			
			
			
	);
	
	//Возвращает номер статуса соответствующий данному названию статуса
	static public function getStatusNum($statusStr){
            foreach (self::$STATUSES as $num => $statusInfo) {
                if ($statusInfo[0] == $statusStr) {
                       return $num;
                }
            }
            return false;
	}
	
	//Возвращает название статуса соответствующее полученному номеру
	static public function getStatusStr($statusNum){
		return isset(self::$STATUSES[$statusNum]) ? self::$STATUSES[$statusNum][0] : '';
	}
	
	//Задание цвета соответстувующего статусу. Если переменная статуса не определена выводит чёрный!
	static public function getStatusColor($statusNum){
		{return isset(self::$STATUSES[$statusNum]) ? self::$STATUSES[$statusNum][1] : "#000000";}
	}
	static public function getStatusesInfo(){
		$r = Array();
		foreach (self::$STATUSES as $num => $statusInfo)
			 $r[$num] = $statusInfo[0];
		return $r;
	}
	
	//Проверка, что статус не является дефолтным
	static public function isApplied($status){
	//	return ( isset(self::$STATUSES[$status]) && ($status !== '0' && $status !== '2') );
		return ( isset(self::$STATUSES[$status]) );
	}
	
	
}