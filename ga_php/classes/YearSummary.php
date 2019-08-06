<?php
// REV. 20190806
namespace GA\Lib;

// LOAD CLASS FROM GLOBAL NS
require_once __DIR__ . "/../GapiService.php";

class YearSummary extends \GapiService {
    private static $result = null;
    private static $instance;
	
    public function __construct($domainKey)
    {
        parent::__construct();
        
        $dimension = "ga:year";
        $output = "datatable";
        $maxResults = 1000;
        $startDate = "YYYY-MM-DD";
        $endDate = "yesterday";
        $metrics = "ga:uniquePageviews";
        
        if ($domainKey === "DOMAIN_ONE"){
            $filters = "ga:hostname==domain_one.tld";
        } else if ($domainKey === "DOMAIN_TWO") {
            $filters = "ga:hostname==domain_two.tld";
        }

        $queryParams = array(   "dimensions" =>$dimension,
                                "output" => $output,
                                "filters" => $filters,
                                "sort" => $dimension,
                                "max-results" => $maxResults);
        try 
        {
            $results = self::$analytics->data_ga->get(
                self::PROFILE_ID,
                $startDate,
                $endDate,
                $metrics,
                $queryParams);

            self::$result = $results["dataTable"]["modelData"];
        } catch (apiServiceException $e) {
            self::$result = 'YearSummary query error '.$e->getCode().':'.$e->getMessage();
        }	
    }

    public function getReport()
    {
        return self::$result;
    }
}
