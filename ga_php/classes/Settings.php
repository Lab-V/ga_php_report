<?php
// REV. 20190806
// GLOBAL NS

define("PHP_FOLDER", __DIR__);
define("LAB_V_EVENT_LOG", "ga_php_error.log");    

require_once PHP_FOLDER . "/VisitorData.php";

// SET UP ENVIRONMENT
if (function_exists('date_default_timezone_set'))
{
    date_default_timezone_set('Europe/Moscow');
}

/**
*	Proceed save to log file PHP errors
*
*/
function err_handler($errno, $errmsg, $filename, $linenum)
{
    // TIME STAMP
    $date = date('Y-m-d H:i:s (T)');
    //$visitorIP = "X.X.X.X";
    // USER IP
    $visitorData = new VisitorData();
    $visitorIP = $visitorData->ip;
    try
    {
        // OPEN FILE	$errorLogPath
        $f = fopen(PHP_FOLDER . '/' . LAB_V_EVENT_LOG, "a");
        
        // LOCK IF POSSIBLE ELSE SCRIPT WAITS IN THIS LINE
        flock($f, LOCK_EX);

        // DEFINE ERROR MESSAGE
        $fullErrorDescr = $date."; ".$visitorIP."; ".$errno."; ".$errmsg."; ".$filename."; ".$linenum."\r\n";

        // SAVE TO FILE
        fwrite($f, $fullErrorDescr);

        // UNLOCK
        flock($f, LOCK_UN);

        // CLOSE FILE
        fclose($f);
    } catch (Exception $ex) {
        echo "error_log file open error: " . $ex->getMessage();
    }
}

// SHOW ERRORS ONLY
error_reporting(E_ERROR);

set_error_handler("err_handler");