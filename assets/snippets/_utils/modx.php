<?php

// for working with Modx from static file
/* require_once '/var/www/config.core.php';
  require_once MODX_CORE_PATH.'model/modx/modx.class.php';
  $modx = new modX();
  $modx->initialize('web'); */

class ModXWork {

    private $userID = NULL;
	private $mysqli = NULL;

    const MODX_USER_DATA = 'way_users';
    const MODX_USER_ATTRIBUTES = 'way_user_attributes';

    public function __construct($userID) {
		
        $this->userID = $userID;
		$ucon = new loginConnect();
 $this->mysqli = $ucon->getMysqli(); 
		//$this->mysqli = $mysqli;
		//$sql = new connection();
		//$mysqli = $sql->getConnect();
		}
		//public function __construct( public $userID) {
		//$sql = new connection();
		//$mysqli = $sql->getConnect();	
		//}

    private function getUserWebgroupName($groupId) {
        $q = "SELECT name FROM way_membergroup_names WHERE id = '$groupId' LIMIT 1";
		$r = $this->mysqli->query($q);
        if (!$r){ return null;}
		while ($row = $r->fetch_array(MYSQLI_ASSOC)){
		$a = $row['name'];	
		}
                return $a;
    }

    private function getUserWebgroupId($groupName) {
		$q = "SELECT id FROM way_membergroup_names WHERE name = '$groupName' LIMIT 1";
		 $r = $this->mysqli->query($q);
		
        if (!$r){ return null;}
		while ($row = $r->fetch_array(MYSQLI_ASSOC)){
		$a = $row['id'];	
		}
                return $a;
			       
    }

    private function getUserWebgroups($g) {
		 $g = $this->userID;
        $r = $this->mysqli->query("SELECT way_web_groups.webgroup FROM way_web_groups WHERE way_web_groups.webuser = '$g'");
        if (!$r) return null;
        $Webgroups = Array();
        for ($i = 0; $i < $r->num_rows; $i++) {
            $row = $r->fetch_array(MYSQLI_ASSOC);
            $Webgroups[] = $row['webgroup'];
        }
        return $Webgroups;
    }

    public function getUserWebgroupsNames() {
        $Webgroups = $this->getUserWebgroups($this->userID);
        if (empty($Webgroups))
            return Array();
        $names = Array();
        foreach ($Webgroups as $group)
            $names[] = $this->getUserWebgroupName($group);
        return $names;
    }

    public function isUserInGroup($groupName, $userID) {
        $groupId = $this->getUserWebgroupId($groupName);
		 $groups = $this->getUserWebgroups($userID);
		   return in_array($groupId, $groups) ? true : false;
    }

    static public function getUserName($userId) {
        $db = new MyCRUD_Modx(self::MODX_USER_DATA);
        $data = $db->getRow(array('id' => $userId));
        return $data['username'];
    }

    static public function getUserEmail($userId) {
        $db = new MyCRUD_Modx(self::MODX_USER_ATTRIBUTES);
        $data = $db->getRow(array('id' => $userId));
        return $data['email'];
    }

    static public function getUserByEmail($email) {
        $db = new MyCRUD_Modx(self::MODX_USER_ATTRIBUTES);
        $data = $db->getRow(array('email' => $email));
        return $data ? $data['id'] : NULL;
    }


}

function isModerator($userID) {
    $o = new ModXWork($userID);
	$moderator = 'Moderator';
    return $o->isUserInGroup($moderator, $userID);
}
function isReferee($userID) {
    $o = new ModXWork($userID);
    return $o->isUserInGroup('Referee', $userID);
}
function isProgrammer($userID) {
    $o = new ModXWork($userID);
    return $o->isUserInGroup('Programmer', $userID);
}
function isExpert($userID) {
    $o = new ModXWork($userID);
	$expert = 'Expert';
    return $o->isUserInGroup($expert, $userID);
}
function isRegistered($userID) {
    $o = new ModXWork($userID);
	$registered = 'Registered';
    return $o->isUserInGroup($registered, $userID);
}





