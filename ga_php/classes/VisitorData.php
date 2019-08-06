<?php
// REV. 20190626
// GLOBAL NS

class VisitorData {
    public $target;
    public $referer;
    public $ip;
    public $proxy;
    
    function __construct()
    {
        $serverName = basename(getenv('HTTP_HOST'));

        //$pageName = basename($_SERVER['PHP_SELF']);
        $pageName = basename(filter_input(INPUT_SERVER, 'PHP_SELF', FILTER_SANITIZE_STRING));
        
        $this->target = $serverName.'/'.$pageName;
        
        //$queryString = basename($_SERVER['QUERY_STRING']);
        $queryString = basename(filter_input(INPUT_SERVER, 'QUERY_STRING', FILTER_SANITIZE_STRING));
        
        if (!empty($queryString))
        {
            $this->target .= '/?'.$queryString;
        }
        
        $this->referer = getenv('HTTP_REFERER') ? getenv('HTTP_REFERER') : 'unknown';
        
        // WORKS ONLY FOR ISSET()
        //$this->referer = getenv('HTTP_REFERER') ?? "unknown";
        //$this->ip = getenv('REMOTE_ADDR') ?? "unknown";
        $this->ip = getenv('REMOTE_ADDR') ? getenv('REMOTE_ADDR') : "unknown";
        
        $this->proxy = getenv('HTTP_X_FORWARDED_FOR') ? getenv('HTTP_X_FORWARDED_FOR') : "unknown";
        
        
    }
    
    public static function visitorDataArray()   // :array --PHP 7
    {
        return Array($this->target, $this->referer, $this->ip, $this->proxy);
    }
}