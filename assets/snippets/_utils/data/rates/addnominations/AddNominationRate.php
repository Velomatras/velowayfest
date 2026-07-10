<?php

/**
 * класс работы с оценками по доп.номинациям
 *
 * @author admin
 */
class AddNominationRate {

    const USER_MIN_VOTES_LIMIT = 25;
    const USER_DISPERSION_LIMIT = 2.0;
    const MAX_RATE = 12;

    protected $db_voting_table_name;
    protected $nomination_name;
    protected $userID;
    protected $votesDB;
    protected $usersParams = Array();
    protected $participantsRatesAvg = Array();
	protected $mysqli = NULL;
        
    function __construct($db_voting_table_name, $nomination_name, $userID) {
		global $mysqli;
        $this->db_voting_table_name = $db_voting_table_name;
        $this->nomination_name = $nomination_name;
        $this->userID = $userID;
        $this->votesDB = new MyCRUD_Modx($this->db_voting_table_name, $mysqli);
		$this->mysqli = $mysqli;
    }

    public function getRate($idz) {
        $data = $this->votesDB->getRow(Array('userid' => $this->userID, 'id_z' => $idz, 'nomination' => $this->nomination_name));
        $rate = isset($data['rate']) ? $data['rate'] : 0;
        $rate_comment = isset($data['rate_comment']) ? $data['rate_comment'] : '';
        return Array($rate, $rate_comment);
    }

    public function getAllNominationRates() {
        return $this->votesDB->getRecords(Array('nomination' => $this->nomination_name));
    }

    public function getUserRates($userId) {
        return $this->votesDB->getRecords(Array('userid' => $userId, 'nomination' => $this->nomination_name));
    }

    public function getParticipantRates($idz) {
        return $this->votesDB->getRecords(Array('idz' => $idz, 'nomination' => $this->nomination_name));
    }
    
    public function calcResultRate($idz, $allNominationZayavkaNum) {

        $rates = $this->getZayavkaRates($idz);

        if (empty($this->usersParams)) {
            $this->calcVotersParams($allNominationZayavkaNum);
        }

        $validRatesNum = $validRatesSum = 0;
        $validRates=Array();
        $validRatesUser=Array();
        $validRatesPercent=Array();
        $validRatesDispersion=Array();

        foreach ($rates as $rate) {

            if (!$this->isRateValid($rate)) {
                continue;
            }

            $userId = $rate['userid'];
            if ( !isset($this->usersParams[$userId]) || !$this->usersParams[$userId]['isValid']) {
                continue;   // не учитываем такую оценку
            }

            $validRatesNum++;
            $validRatesSum+= $rate['rate'];

            $validRates[] = $rate['rate'];
			$gun = new ModXWork($userId, $this->mysqli);
            $validRatesUser[] = $gun->getUserName($userId);
            $validRatesPercent[] = round($this->usersParams[$userId]['percent']);
            $validRatesDispersion[] = $this->usersParams[$userId]['dispersion'];

        }

        if($validRatesNum <= 0) {
            return 0;
        }
//debug outpuy
//global $modx;
//if (isModerator($modx->getLoginUserID())) {
//  echo '<br>'.$idz.' ';
//  echo '$rates'.' ';
//        print_r($rates);cr();
//  echo '$validRatesUser'.' ';
//        print_r($validRatesUser);cr();
//    echo '$validRates'.' ';
//        print_r($validRates);cr();
//    echo '$validRatesPercent'.' ';
//        print_r($validRatesPercent);cr();
//    echo '$validRatesDispersion'.' ';
//        print_r($validRatesDispersion);cr();
//}
        return array($validRatesSum/$validRatesNum, count($rates), $validRatesNum);
    }

    public function getUserRatesNum() {
        return $this->votesDB->getRowsNum(Array('userid' => $this->userID, 'nomination' => $this->nomination_name));
    }

    public function insertRate($idz, $rate, $rateComment) {
        $this->votesDB->insert(Array(
            'userid' => $this->userID,
            'nomination' => $this->nomination_name,
            'id_z' => $idz,
            'rate' => $rate,
            'rate_comment' => $rateComment,
            )
        );
    }

    public function upsertRate($idz, $rate, $rateComment) {
        $this->votesDB->upsert(Array(
            'userid' => $this->userID,
            'nomination' => $this->nomination_name,
            'id_z' => $idz,
            'rate' => $rate,
            'rate_comment' => $rateComment,
            )
        );
    }

    public function deleteRate($idz) {
        $this->votesDB->delete(Array(
            'userid' => $this->userID,
            'nomination' => $this->nomination_name,
            'id_z' => $idz,
            )
        );
    }

    public function getAllComments($idz){
        $rates = $this->votesDB->getRecords(Array('id_z' => $idz, 'nomination' => $this->nomination_name));
        $s = '';
        foreach ($rates as $rate){
            if (!empty($rate['rate_comment']) && $rate['userid'] !== $this->userID){
				$gun = new ModXWork($userId, $this->mysqli);
            
                $s.= '<b>'.$gun->getUserName($rate['userid']).'</b><br>';
                $s.=htmlspecialchars($rate['rate_comment']).'<br>';
            }
        }
        return $s;
    }

    public function deleteAllUserRates(){
        $this->votesDB->delete(Array('userid' => $this->userID, 'nomination' => $this->nomination_name));
    }
    
    protected function getZayavkaRates($idz) {
        return $this->votesDB->getRecords(Array('id_z' => $idz, 'nomination' => $this->nomination_name));
    }

    protected function isRateValid($rate){
		$quote = "quote";
		if ($this->nomination_name == $quote) return true;
        if ( $rate['rate'] < 1 || $rate['rate'] > 12) { return false;}  // invalid rate
        if ( $rate['rate'] > 3 && $rate['rate'] < 10) { return true;} //valid rate without comment
        return !empty($rate['rate_comment']);    //valid rate which should be commented
    }

    protected function calcPercent($value, $totalValue){
        if ($totalValue <= 0){ return 0;}
        return $value/$totalValue*100;
    }

    protected function calcParticipantsRatesAvg() {
        $result = Array();
        $rates = $this->getAllNominationRates();

        foreach ($rates as $rate) {
            if (!$this->isRateValid($rate)) {
                continue;
            }
            $idz = $rate['id_z'];
            if (isset($result[$idz])) {
                $result[$idz]['sum'] = $result[$idz]['sum'] + $rate['rate'];
                $result[$idz]['num'] = $result[$idz]['num'] + 1;
            } else {
                $result[$idz]['sum'] = $rate['rate'];
                $result[$idz]['num'] = 1;
            }
        }

        foreach ($result as $idz => $data) {
            $result[$idz]['avg'] = $data['sum'] / $data['num'];
        }
        
        return $result;
    }

    protected function calcRatesAvgDispersion($rates) {
        
        if (empty($this->participantsRatesAvg)) {
            $this->participantsRatesAvg = $this->calcParticipantsRatesAvg();
        }

        $validRatesDispersionSum = 0.0;
        $validRatesNum = 0;
        foreach ($rates as $rate) {
            if (!$this->isRateValid($rate)) {
                continue;
            }
            if (!isset($this->participantsRatesAvg[$rate['id_z']])) {
                continue;  // вообще-то такого быть не должно!
            }
            $validRatesDispersionSum = $validRatesDispersionSum + abs($this->participantsRatesAvg[$rate['id_z']]['avg'] - $rate['rate']);
            $validRatesNum = $validRatesNum + 1;
        }

        if ($validRatesNum == 0) {
            return -1; // no valid rates
        }
        
        return $validRatesDispersionSum/$validRatesNum;
    }

    protected function calcVotersParams($allNominationZayavkaNum){

        $rates = $this->getAllNominationRates();

        foreach ($rates as $rate) {
            $userId = $rate['userid'];
            if ( isset($this->usersParams[$userId])) {
                continue;
            }

            $this->usersParams[$userId]['isValid'] = false;
            $userRates = $this->getUserRates($userId);

            $this->usersParams[$userId]['percent'] = $this->calcPercent(count($userRates), $allNominationZayavkaNum);
            if ($this->usersParams[$userId]['percent'] < static::USER_MIN_VOTES_LIMIT) {
                continue;
            }

            $avgDispersion = $this->calcRatesAvgDispersion($this->getUserRates($userId));
            $this->usersParams[$userId]['dispersion'] = $avgDispersion;

//global $modx; if (isModerator($modx->getLoginUserID())) {
//    echo $userId . " " . $avgDispersion . " ** ";
//}
            if ($avgDispersion < 0 || $avgDispersion > static::USER_DISPERSION_LIMIT) {
                continue;
            }

            $this->usersParams[$userId]['isValid'] = true;
        }
        return $this->usersParams;
    }

}