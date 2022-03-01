<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.eu.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    
    'teamleader' => [
        'client_id' => env('TEAMLEADER_CLIENT_ID'),
        'client_secret' => env('TEAMLEADER_CLIENT_SECRET'),
        'redirect_uri' => env('TEAMLEADER_REDIRECT_URI'),
        'state' => env('TEAMLEADER_STATE', 'FtvPC1SE2h3LVPEJZIsrfaVWTwwn7T0R'),
    ],

    
];
