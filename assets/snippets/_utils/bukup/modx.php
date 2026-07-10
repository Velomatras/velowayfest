<?php

// for working with Modx from static file
/* require_once '/var/www/config.core.php';
  require_once MODX_CORE_PATH.'model/modx/modx.class.php';
  $modx = new modX();
  $modx->initialize('web'); */

class ModXWork {

    private $userID = NULL;

    const MODX_USER_DATA = 'web_users';
    const MODX_USER_ATTRIBUTES = 'web_user_attributes';

    public function __construct($userID) {
        $this->userID = $userID;
		$sql = new connection();
		$mysqli = $sql->getConnect();
		}

    private function getUserWebgroupName($groupId) {
        $q = "SELECT name FROM webgroup_names WHERE id = '$groupId' LIMIT 1";
		$r = $mysqli->query($q);
        if (!$r){ return null;}
		while ($row = $r->fetch_array(MYSQLI_ASSOC)){
		$a = row['name'];	
		}
                return $a;
    }

    private function getUserWebgroupId($groupName) {
		$q = "SELECT id FROM webgroup_names WHERE name = '$groupName' LIMIT 1";
		$r = $mysqli->query($q);
        if (!$r){ return null;}
		while ($row = $r->fetch_array(MYSQLI_ASSOC)){
		$a = row['id'];	
		}
                return $a;
			       
    }

    private function getUserWebgroups() {
		
        $r = $mysqli->query("SELECT web_groups.webgroup FROM web_groups WHERE web_groups.webuser = '$this->userID'");
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

    public function isUserInGroup($groupName) {
        $groupId = $this->getUserWebgroupId($groupName);
        $groups = $this->getUserWebgroups();
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
    return $o->isUserInGroup('Moderator');
}
function isReferee($userID) {
    $o = new ModXWork($userID);
    return $o->isUserInGroup('Referee');
}
function isProgrammer($userID) {
    $o = new ModXWork($userID);
    return $o->isUserInGroup('Programmer');
}
function isExpert($userID) {
    $o = new ModXWork($userID);
    return $o->isUserInGroup('Expert');
}

