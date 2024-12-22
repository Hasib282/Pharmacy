<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default CORS Settings
    |--------------------------------------------------------------------------
    |
    | By default, all cross-origin requests are allowed. You can modify this
    | to specify more restrictive behavior.
    |
    */
    'defaults' => [
        'supports_credentials' => true, // Allows cookies to be sent along with the request
        'allowed_origins' => ['*'], // Change '*' to specific domains for security
        'allowed_headers' => ['*'], // List specific headers or use '*' for all
        'allowed_methods' => ['*'], // Allowed HTTP methods like GET, POST, PUT, DELETE, etc.
        'exposed_headers' => [],
        'max_age' => 0, // In seconds, tells the browser how long to cache the response
    ],

    /*
    |--------------------------------------------------------------------------
    | CORS Paths
    |--------------------------------------------------------------------------
    |
    | This allows you to define specific paths for which you want to enable CORS.
    |
    */
    'paths' => ['api/*', '*'], // This applies CORS to API routes and all other routes

    /*
    |--------------------------------------------------------------------------
    | CORS Request Method Exemptions
    |--------------------------------------------------------------------------
    |
    | If you need to exclude certain HTTP methods, you can specify them here.
    |
    */
    'allowed_methods' => [
        'GET', 'POST', 'PUT', 'DELETE', 'OPTIONS',
    ],

    /*
    |--------------------------------------------------------------------------
    | CORS Headers
    |--------------------------------------------------------------------------
    |
    | You can customize the list of headers that are allowed in CORS requests.
    |
    */
    'allowed_headers' => [
        'X-CSRF-Token', 'Accept', 'Authorization', 'Content-Type', 'Origin'
    ],

    /*
    |--------------------------------------------------------------------------
    | Allow Credentials
    |--------------------------------------------------------------------------
    |
    | If you need to allow cookies to be sent, you can enable this option.
    |
    */
    'supports_credentials' => true,

    /*
    |--------------------------------------------------------------------------
    | Exposed Headers
    |--------------------------------------------------------------------------
    |
    | You can specify the headers you want to expose to the browser. 
    | Leave empty if you don't want to expose any.
    |
    */
    'exposed_headers' => [],

    /*
    |--------------------------------------------------------------------------
    | Maximum Age
    |--------------------------------------------------------------------------
    |
    | Set the `max_age` directive for pre-flight requests.
    | Determines how long the browser should cache the preflight response.
    |
    */
    'max_age' => 3600, // 1 hour
];
