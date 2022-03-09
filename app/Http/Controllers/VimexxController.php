<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VimexxController extends Controller
{
    public static function connect(){
        $data = [
            'client_id' => '2003',
            'client_secret' => 'EK6qd5oGlxNgdLmwGxDjiUeydEKGbpREyEO35y9c',
            'grant_type' => 'password',
            'username' => 'bert@vbdesign.be',
            'password' => '3OwBDg3J5suF',
            'scope' => 'whmcs-access',
        ];

        $url = 'https://api.vimexx.nl/auth/token';

        $response = Http::post($url, $data);
        
        $vimexx = json_decode($response->body());

        return  $vimexx->access_token;
    }
}
