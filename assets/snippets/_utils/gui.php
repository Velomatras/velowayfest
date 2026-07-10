<?php

class GUISelector {

    private $name = '';
    private $values = Array();
    private $ExcludeValues = Array();
    private $IncludeValues = Array();
    private $default_value = NULL;
    private $makeZeroOption = true;

    public function __construct($name) {
        $this->name = $name;
    }

    private function printSelectorOption($name, $value) {
        $selected = ( $this->default_value !== NULL) && ($value == $this->default_value) ? ' selected ' : '';
        echo '<option ' . $selected . ' value="' . $value . '" >' . $name . '</option>';
    }

    public function setExcludeValues($ExcludeValues) {
        $this->ExcludeValues = $ExcludeValues;
    }

    public function setIncludeValues($IncludeValues) {
        $this->IncludeValues = $IncludeValues;
    }

    public function setZeroOption($zeroOptionFlg) {
        $this->makeZeroOption = $zeroOptionFlg;
    }

    public function setValuesFromArray($values) {
        $this->values = $values;
    }

    public function setValuesFromSequence($start_value, $end_value) {
        $this->values = Array();
        for ($value = $start_value; $value <= $end_value; $value++)
            $this->values["$value"] = $value;
    }

    public function setDefaultValue($value) {
        $this->default_value = $value;
    }

    public function draw() {
        echo "<select id=\"$this->name\" name=\"$this->name\">";
        if ($this->makeZeroOption)
            $this->printSelectorOption('   ', 0);
        foreach ($this->values as $value => $valueName)
            if (!in_array($value, $this->ExcludeValues))
                $this->printSelectorOption($valueName, $value);
        foreach ($this->IncludeValues as $value => $valueName) {
            if (!in_array($value, $this->ExcludeValues))
                $this->printSelectorOption($valueName, $value);
        }
        echo "</select>";
    }

    public function makeYearInput() {
        $YEAR_SEARCH_DEEPNESS = 16;
        $cur_year = date('Y');
        $this->setValuesFromSequence($cur_year - $YEAR_SEARCH_DEEPNESS, $cur_year);
    }

    public function makeMonthInput() {
        $this->setValuesFromArray(Array(1 => 'январь', 2 => 'февраль', 3 => 'март', 4 => 'апрель', 5 => 'май', 6 => 'июнь',
            7 => 'июль', 8 => 'август', 9 => 'сентябрь', 10 => 'октябрь', 11 => 'ноябрь', 12 => 'декабрь'));
    }

    public function makeDayInput() {
        $this->setValuesFromSequence(1, 31);
    }

}

class GUIHelpers {

    static public function getSelectorOption($name, $value, $isDefaultOption = false) {
        $selected = $isDefaultOption ? ' selected ' : '';
        return '<option ' . $selected . ' value="' . $value . '" >' . $name . '</option>';
    }

    static public function getSelectorFromArray($name, $values, $default_value = NULL, $makeZeroOption = true, $ExcludeValues = Array()) {
        echo "<select id=\"$name\" name=\"$name\">";
        if ($makeZeroOption)
            echo "<option value=\"0\">   </option>";
        foreach ($values as $value => $valueName) {
            if (in_array($value, $ExcludeValues))
                continue;
            if (isset($default_value) and ( $value == $default_value))
                echo "<option selected value=\"$value\">$valueName</option>";
            else
                echo "<option value=\"$value\">$valueName</option>";
        }
        echo "</select>";
    }

    static public function setHiddenField($name, $value) {
        if (isset($value))
            echo "<input type=\"hidden\" name=\"$name\" value=\"$value\">";
    }

    static public function getCheckbox($name, $value, $is_checked = NULL) {
        if (isset($is_checked))
            if ($is_checked) {
                echo "<input type=\"checkbox\" id=\"$name\" name=\"$name\" value = \"$value\" checked=\"checked\">";
                return;
            }
        echo "<input type=\"checkbox\" id=\"$name\" name=\"$name\" value = \"$value\">";
    }

    static public function getTextInput($name, $defaultValue = NULL, $size = NULL, $max_input_len = 255) {
        echo <<< HEREDOC
            <input name="$name" id="$name" type="text" maxlength="$max_input_len"
HEREDOC;
        if (isset($defaultValue))
            echo ' value="' . $defaultValue . '"';
        if (isset($size))
            echo ' size="' . $size . '"';
        echo '/>';
    }

    static public function getTextAreaInput($name, $defaultValue=NULL, $rowsNum = 1, $colsNum=50, $id='', $itemClass=''){
    ?>
        <textarea name="<?= $name ?>" id="<?= $id ?>" <?= !empty($itemClass) ? 'class="'.$itemClass.'"' : '' ?>
            rows="<?= $rowsNum ?>" cols="<?= $colsNum ?>"  wrap="soft" ><?= $defaultValue ?></textarea>
    <?php
    }

    static public function getTextInputsFromArray($valuesArray, $name, $size = NULL, $max_input_len = 255) {
        if (sizeof($valuesArray) > 0)
            foreach ($valuesArray as $value)
                if (!empty($value)) {
                    self::getTextInput($name . '[]', $value);
                    cr();
                }
    }

    static public function printError($msg) {
        echo '<div class="errors">' . $msg . '</div>';
    }

    static public function printLink($url, $caption = '') {
        if ($url !== '')
            echo '<a href="' . htmlspecialchars($url) . '" target="_blank">' . $caption . '</a>';
    }

    static public function printLinksArray($linksArray, $caption = '') {
        $s = '';
        if (!empty($linksArray)) {
            $links = DBDataWork::unpackArray($linksArray);
            if (sizeof($links) > 0) {
                $s.="$caption ";
                for ($i = 0; $i < (sizeof($links)); $i++)
                    if (!empty($links[$i]))
                        $s.='<a href=" ' . $links[$i] . ' " target="_blank">' . ($i + 1) . '</a>&nbsp';
            }
        }
        echo $s;
    }

}

class GUIForm {

    public function __construct($id = '', $action = '') {
        echo '<form method="POST" id="' . $id . '" action="' . $action . '">';
    }

    public function makeEnd() {
        echo'<input type="submit" name="submit" id="submit" value="Сохранить">
            </form>';
    }

}

function cr() {
    echo '<br>';
}

function sp() {
    echo '&nbsp;';
}

?>