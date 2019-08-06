<?php
// REV. 20190805
// GLOBAL NS

require_once 'Settings.php';

/**
 * Description of MyException
 *
 * @author I
 */
class MyException extends Exception {
    
    const SOURCE_NAME_PREFIX = "GASAMPLE.LC Exception: ";
    private static $userIP;
    
    public function __construct($message = null, $code = 0)
    {
        parent::__construct($message, $code);
        
        $visitorData = new VisitorData();
        self::$userIP = $visitorData->ip;
        
        //self::$userIP = "X.X.X.X";
        self::writeLog($this->code, self::SOURCE_NAME_PREFIX.$message, $this->file, $this->line);
    }
    
    public static function writeLog($errno, $errmsg, $filename, $linenum)
    {
        $date = date('Y-m-d H:i:s (T)');
    
        try
        {
            // OPEN FILE	$errorLogPath
            $f = fopen(PHP_FOLDER . '/' . LAB_V_EVENT_LOG, "a");

            // LOCK IF POSSIBLE ELSE SCRIPT WAITS IN THIS LINE
            flock($f, LOCK_EX);

            // DEFINE ERROR MESSAGE
            $fullErrorDescr = $date."; ".self::$userIP."; ".$errno."; ".$errmsg."; ".$filename."; ".$linenum."\r\n";

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
}
