<?php

return [

    /*
    |--------------------------------------------------------------------------
    | AWS Region where secrets are stored
    |--------------------------------------------------------------------------
    |
    | The AWS Region where secrets are stored.
    |
    */
    'enable-secrets-manager' => (bool) env('ENABLE_SECRETS_MANAGER', false),

    /*
    |--------------------------------------------------------------------------
    | Cache Enabled
    |--------------------------------------------------------------------------
    |
    | Boolean if you would like to enable cache. Datastore requests can add an additional 100-250ms
    | of latency to each request. It is recommended to use caching to significantly reduce this latency.
    |
    */

    'cache-enabled' => true, // boolean

    /*
    |--------------------------------------------------------------------------
    | Cache Expiry
    |--------------------------------------------------------------------------
    |
    | The length of time that the Cache should be enabled for in minutes. 30-60 minutes is recommended.
    |
    */

    'cache-expiry' => 30, // minutes

    /*
    |--------------------------------------------------------------------------
    | Cache Store
    |--------------------------------------------------------------------------
    |
    | Define the cache store that you wish to use (this must be configured in your config.cache file).
    | Note: you can only use a store that does not require credentials to access it. As such file is suggested.
    |
    */

    'cache-store' => 'file',

    'cache-name' => 'aws-secrets-manager-env',

    /*
    |--------------------------------------------------------------------------
    | Debugging
    |--------------------------------------------------------------------------
    |
    | Enable debugging, latency introduced by this package on bootstrapping is calculated and logged
    | to the system log (viewable in stackdriver).
    |
    */

    'debug' => env('APP_DEBUG', false),

];
