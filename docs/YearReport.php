<?php
// REV. 20190806

require_once '../ga_php/loader.php';

use GA\Lib\YearSummary;

function sendResult()
{
    $domainKey = filter_input(INPUT_POST, "domainKey",  FILTER_SANITIZE_STRING);
    
    $summaryObj = new YearSummary($domainKey);
    $actionResultArray = array();

    // OK / ERR_TIMEOUT / ERR_AUTH
    $actionResultArray["status"] = "OK";
    
    $actionResultArray["data"] = $summaryObj->getReport();

    header('Content-Type: application/json');
    print json_encode($actionResultArray);
}

 sendResult();