<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Credentials
    |--------------------------------------------------------------------------
    |
    | If you're using API credentials, change these settings. Get your
    | credentials from https://dashboard.nexmo.com | 'Settings'.
    |
    */

    'api_key'    => function_exists('env') ? env('NEXMO_KEY', 'bfb9de6e') : 'bfb9de6e',
    'api_secret' => function_exists('env') ? env('NEXMO_SECRET', 'rt1VcJZgAGbTyrZ3') : 'rt1VcJZgAGbTyrZ3',

    /*
    |--------------------------------------------------------------------------
    | Signature Secret
    |--------------------------------------------------------------------------
    |
    | If you're using a signature secret, use this section. This can be used
    | without an `api_secret` for some APIs, as well as with an `api_secret`
    | for all APIs.
    |
    */

    'signature_secret' => function_exists('env') ? env('NEXMO_SIGNATURE_SECRET', '') : '',

    /*
    |--------------------------------------------------------------------------
    | Private Key
    |--------------------------------------------------------------------------
    |
    | Private keys are used to generate JWTs for authentication. Generation is
    | handled by the library. JWTs are required for newer APIs, such as voice
    | and media
    |
    */

    'private_key' => function_exists('env') ? env('NEXMO_PRIVATE_KEY', 'private.key') : 'private.key',
    'application_id' => function_exists('env') ? env('NEXMO_APPLICATION_ID', '2e913efb-cea5-45fb-8a00-f76ff79ad7b2') : '2e913efb-cea5-45fb-8a00-f76ff79ad7b2',

    /*
    |--------------------------------------------------------------------------
    | Application Identifiers
    |--------------------------------------------------------------------------
    |
    | Add an application name and version here to identify your application when
    | making API calls
    |
    */

    'app' => ['name' => function_exists('env') ? env('NEXMO_APP_NAME', 'Dzly') : 'Dzly',
        'version' => function_exists('env') ? env('NEXMO_APP_VERSION', '1.1.2') : '1.1.2']
];
