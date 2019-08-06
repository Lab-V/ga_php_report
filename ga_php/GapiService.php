<?php
// REV. 20190806
// GLOBAL NS

class GapiService 
{
    protected static $analytics;
    const PROFILE_ID = "YOUR_PROFILE_ID";
    
    public function __construct()
    {
        require_once __DIR__ . '/vendor/autoload.php';
        
        $KEY_FILE_LOCATION = __DIR__ . '/service-account-credentials.json';

        // Create and configure a new client object.
        $client = new Google_Client();
        $client->setApplicationName("Lab-V sample google analytics report");
        $client->setAuthConfig($KEY_FILE_LOCATION);
        $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
        self::$analytics = new Google_Service_Analytics($client);
    }
}
