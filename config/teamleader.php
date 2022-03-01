<?php

return [
    'api_url'       => env('TEAMLEADER_API_URL', 'https://api.focus.teamleader.eu'),
    'auth_url'      => env('TEAMLEADER_AUTH_URL', 'https://focus.teamleader.eu'),
    'client_id'     => env('TEAMLEADER_ID', 'd4edfc96ff1d0814c57f3ed0a72cebc8'),
    'client_secret' => env('TEAMLEADER_SECRET', '5970126c1d1c11eecda444da5c4a4a85'),
    'redirect_uri'  => env('TEAMLEADER_REDIRECT', 'https://vbdashboard.test/teamleader'),
    'client'        => null,
];
