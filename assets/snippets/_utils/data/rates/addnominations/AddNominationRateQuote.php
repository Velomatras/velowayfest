<?php

/**
 * класс работы с оценками по доп.номинациям
 *
 * @author admin
 */
class AddNominationRateQuote extends AddNominationRate{

    
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

            
            $userId = $rate['userid'];
            if ( !isset($this->usersParams[$userId]) || !$this->usersParams[$userId]['isValid']) {
                continue;   // не учитываем такую оценку
            }

            $validRatesNum++;
            $validRatesSum+= $rate['rate'];

            $validRates[] = $rate['rate'];
            $validRatesUser[] = ModXWork::getUserName($userId);
            $validRatesPercent[] = round($this->usersParams[$userId]['percent']);
            $validRatesDispersion[] = $this->usersParams[$userId]['dispersion'];

        }

        if($validRatesNum <= 0) {
            return 0;
        }

        return array($validRatesSum/$validRatesNum, count($rates), $validRatesNum);
    }

    

    protected function calcParticipantsRatesAvg() {
        $result = Array();
        $rates = $this->getAllNominationRates();

        foreach ($rates as $rate) {
           
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