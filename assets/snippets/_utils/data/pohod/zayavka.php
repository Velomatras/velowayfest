<?php

abstract class Zayavka extends Pohod {

    static protected $Nominations = Array();

    abstract public function defineClass();

    static public function getNominationsInfo() {
        $r = array();
        foreach (static::$Nominations as $nomination){
            $r[$nomination[1]] = $nomination[0];
        }
        return $r;
    }

    public function isApplied() {
        return ZayavkaStatus::isApplied($this->data['status']);
    }

    public function getStatusStr() {
        return ZayavkaStatus::getStatusStr($this->data['status']);
    }

    public function getStatusColor() {
        return ZayavkaStatus::getStatusColor($this->data['status']);
    }

    public function getModerator() {
        return ModXWork::getUserName($this->data['moderator']);
    }

    public function save() {
        $this->defineClass();
        $this->defineStatus($this->data['class']);
        $this->defineViewersNomination($this->data['status']);
        return parent::save();
    }

    public function update($zayavkaNum) {
        $this->defineClass();
        $this->defineViewersNomination($this->data['status']);
        return parent::update($zayavkaNum);
    }

    public function removeFromNomination($nomination) {
        $nominations = DBDataWork::unpackArray($this->data['nominations']);
        $found = array_search($nomination, $nominations);
        if ($found === false) {
            return;
        }
        unset($nominations[$found]);
        $this->data['nominations'] = DBDataWork::packArray($nominations);
    }

    public function isInNomination($nomination) {
        $nominations = DBDataWork::unpackArray($this->data['nominations']);
        return in_array($nomination, $nominations);
    }

    public function getNominationsNum() {
        return count(DBDataWork::unpackArray($this->data['nominations']));
    }
}

function printStatusesSelector($selectorName, $selectedValue = null, $makeZeroOption = false) {
    $statuses = ZayavkaStatus::getStatusesInfo();
    GUIHelpers::getSelectorFromArray($selectorName, $statuses, $selectedValue, $makeZeroOption);
}

function printNominationsSelector($zayavkaType, $selectedValues = Array()) {
    $nominations = $zayavkaType::getNominationsInfo();
    foreach ($nominations as $name => $description) {
		 //$warning = $this->defineStatus($this->data['class']);
		  
        GUIHelpers::getCheckbox('nominations[]', $name, in_array($name, $selectedValues));
		
		
//if ($warning) $description = "!!! $description";
 echo $description;

		        cr();
    }
}


?>
