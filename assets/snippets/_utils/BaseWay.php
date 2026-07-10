<?php
class baseWay {
	//тут задаём имена рабочих таблиц БД для использования в сниппетах
	//префикс таблиц
	const PREFICS = "way_";
	//аттрибуты юзеров
	const USER_ATTRIBUTES = "user_attributes";
	//аттрибуты юзеров
	const USER_ATTRIBUTES_EXTENDED = "web_user_attributes_extended";
	//таблица юзеров
	const USERS = "users";
	//таблица библиотеки отчётов
	const LIBRARY = "library";
	//таблица групп в которых состоит юзер
	const GROUPS = "member_groups";
	//таблица имён групп
	const GROUPS_NAMES = "membergroup_names";
	
	//старая альтернативная запись protected static $library = "way_library";
		
public static function getAttributes(){
//старая альтернативная запись return static::$user_attributes;
return self::USER_ATTRIBUTES;
}

public static function getAttributesExtended(){
//старая альтернативная запись return static::$user_attributes;
return self::USER_ATTRIBUTES_EXTENDED;
}

public static function getUsers(){
return self::USERS;
}

public static function getGroups(){
return self::GROUPS;
}

public static function getGroupsNames(){
return self::GROUPS_NAMES;
}
		
public static function getLibrary(){
return self::LIBRARY;
}

public static function lineStandart(){
 echo '<tr height="6px"><td colspan="8"><hr style="color:#B2B2B2"></td></tr>';	
	
}
public static function getPrefics(){
	return self::PREFICS;
}
	
}
?>