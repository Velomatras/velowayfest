<?php

/**
 * класс работы с оценками по эксп.номинациям
 * !!! unfinished, not used yet!
 *
 * @author admin
 */
class ExpertNominationRate2016 {

    private $db_voting_table_name;
    private $nominations = Array('informative', 'autonome', 'unusual', 'children', 'unfortun');

    private $nomination_name;
    private $userID;
    private $votesDB;
    private $usersParams = Array();
    private $participantsRatesAvg = Array();

    function __construct($db_voting_table_name, $nomination_name, $userID) {
        $this->db_voting_table_name = $db_voting_table_name;
        $this->nomination_name = $nomination_name;
        $this->userID = $userID;
        $this->votesDB = new MyCRUD_Modx($this->db_voting_table_name);
    }

    function getExpertVotes($userID, $idz) {
        $db = new MyCRUD_Modx($this->db_voting_table_name);
        $pohod = $db->getRow(array('userid' => $userID, 'idz' => $idz));
        if (empty($pohod)) {
            return Array(0, 0, 0, 0, 0);
        }
        return Array($pohod['informative'], $pohod['autonome'], $pohod['unusual'], $pohod['children'], $pohod['unfortun']);
    }

    function subcat_num_to_name($subcat) {
        if ($subcat == 1) $valueName = 'Информативный';
        if ($subcat == 2) $valueName = 'Автономный';
        if ($subcat == 3) $valueName = 'Необычный';
        if ($subcat == 4) $valueName = 'С детьми';
        if ($subcat == 5) $valueName = 'Приключенческий';
        if ($subcat == 6) $valueName = 'Сумма оценок';
        return $valueName;
    }

    function subcat_num_to_internalName($subcat) {
        if ($subcat == 1) return 'inf';
        elseif ($subcat == 2) return 'auto';
        elseif ($subcat == 3) return 'unus';
        elseif ($subcat == 4) return 'child';
        elseif ($subcat == 5) return 'unfor';
        else return null;
    }

}