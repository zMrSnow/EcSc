<?php

use App\Info;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/*try {
    $client_id = Info::where("name", "=", "paypal_client_id")->firstOrFail();
    $client_id = $client_id->value;
    $secret = Info::where("name", "=", "paypal_secret")->firstOrFail();
    $secret = $secret->value;
} catch (ModelNotFoundException $e) {
    $client_id = "";
    $secret = "";
}*/

return array(
    /** set your paypal credential **/
    'client_id' => "",
    'secret' => "",
    /**
     * SDK configuration
     */
    'settings' => array(
        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => 'sandbox',
        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 1000,
        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,
        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',
        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'FINE'
    ),
);
