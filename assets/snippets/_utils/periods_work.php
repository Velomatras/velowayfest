<?php
class Period{
	public static function makePeriodStr($day1, $month1, $year1, $day2, $month2, $year2){
		return sprintf('%02d.%02d.%4d - %02d.%02d.%4d', $day1, $month1, $year1, $day2, $month2, $year2);		
	}	
	public static function getDates($period){return empty($period) ? NULL : explode("-", $period);}
	public static function explodeDates($period){
		if ( empty($period) )
			return NULL;
		$dates = self::getDates($period);
		return array_merge(explode(".", $dates[0]), explode(".", $dates[1]));
	}
	public static function get_trip_duration($period){ // из строки со сроками получаем длительность похода в днях
		if (empty($period)) return 0;
		$dates = self::getDates($period);
		if (empty($dates[1]) || empty($dates[0])) return 0;
		$duration = date_diff(date_create($dates[1]), date_create($dates[0]))->format('%a');
		
		$duration = $duration + 1;
		return $duration;
	}
	public static function get_trip_duration_text($period){	
	// из строки со сроками - длительность похода с добавлением дней в правильном падеже
		$s = '';
		if (!empty($period)){ 
			$duration = get_trip_duration($period);		
			$s=$duration." ".get_value_units_text($duration, 'день', 'дня', 'дней');			
		}
		return $s;
}
	public static function get_trip_duration_text2($duration){ 
	// длительность похода с добавлением дней в правильном падеже 
		$s = '';
		if (!empty($duration))		
			$s=$duration." ".get_value_units_text($duration, 'день', 'дня', 'дней');				
		return $s;
	}
}
// for backward compatibility with old code
function makePeriodStr($day1, $month1, $year1, $day2, $month2, $year2){
	return Period::makePeriodStr($day1, $month1, $year1, $day2, $month2, $year2);}
function get_trip_duration($period){return Period::get_trip_duration($period);}
function get_trip_duration_text($period){return Period::get_trip_duration_text($period);}
function get_trip_duration_text2($duration){return Period::get_trip_duration_text2($period);}

?>