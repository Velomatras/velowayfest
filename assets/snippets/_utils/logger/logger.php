<?php
define("PRINT_DEBUG_LOGS", 0);

// error and debug logger
function printDebugLog($logValue, $funcName = '') {
    if (PRINT_DEBUG_LOGS == 1){
        if ($funcName !== '') {
            echo 'FUNCTION: ' . $funcName . ' ';
        }
        if (is_array($logValue))
            print_r($logValue);
        else
            echo $logValue;
        echo '<br>';
        die();
    }
}