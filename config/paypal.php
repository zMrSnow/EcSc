<?php

return array(
    /** set your paypal credential **/
    'client_id' =>'AeSF4NELkJMVzvYB7-8UlXDc40GHB7PdzYodb0DfEqwUN47PdQTJ3Y5Ck33FoY1MZ4fCgazA6RCwN6YF',
    'secret' => 'EBqhN9EsJ6r3FMw7xfVAVEw0qCuShJaKmnd-cLC26hLak7_CI4qTkfC3ZU58YGWKPtBclUr5928XwOJ5',
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
