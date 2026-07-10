<?php
class AddNominationRate2023_2 extends AddNominationRate {
    const USER_MIN_VOTES_LIMIT = 10;
	const USER_DISPERSION_LIMIT = 2.5;
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
            $validRatesUser[] = ModXWork::getUserName($userId);
            $validRatesPercent[] = round($this->usersParams[$userId]['percent']);
            $validRatesDispersion[] = $this->usersParams[$userId]['dispersion'];
			

        }
		$disp = ResultsReferee2023::dispers($validRates);

        if($validRatesNum <= 0) {
            return 0;
        }

        return array($validRatesSum/$validRatesNum, count($rates), $validRatesNum, $disp);
    }
	
}