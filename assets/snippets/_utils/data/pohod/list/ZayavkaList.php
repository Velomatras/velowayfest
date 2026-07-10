<?php

class ZayavkaList {
    public $list = Array();
    private $zayavkaType;
    public function __construct($zayavkaType) {
        $this->zayavkaType = $zayavkaType;
    }

    public function load($filterCondition=array(), $sortByField = 'id', $sortOrder = '') {
        $this->list = array();
        $db = new MyCRUD_Modx($this->zayavkaType->getDBName());
        $data = $db->getRecords($filterCondition, $sortByField, true, $sortOrder);
        if ($data){
            $this->list = $data;
        }
    }

    public function loadUsingQuery($query) {
        $db = new MyCRUD_Modx($this->zayavkaType->getDBName());
        $data = $db->getRecordsUsingQuery($query);
        if ($data){
            $this->list = $data;
        }
    }

    public function getCount() {
        return count($this->list);
    }
}

function printNominationsSelectorForList($zayavkaType, $selectorName, $selectedValue = NULL, $makeZeroOption = true, $addOptions = Array()) {
    $selector = new GUISelector($selectorName);
    $selector->setValuesFromArray($zayavkaType::getNominationsInfo());
    $selector->setExcludeValues(Array("lasting", "longest", "speedy"));
    $selector->setIncludeValues($addOptions);
    $selector->setDefaultValue($selectedValue);
    $selector->draw();
    $curUrl = URLWork::getCurURLNoParams();
    ?>
    <script type="text/javascript">
        jQuery("#<?php echo $selectorName ?>").change(function () {
            newValue = jQuery("#<?php echo $selectorName ?> ").val();
            location.href = "<?php echo $curUrl . '?' . $selectorName ?>=" + newValue;
        });
    </script>
    <?php
}
