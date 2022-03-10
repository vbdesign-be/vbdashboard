<?php

namespace App\Http\Controllers;

use App\Models\Vimexx;
use Google\Auth\AccessToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VimexxController extends Controller
{
    // public static function checkDomain(){

    // }

    // public static function connect(){
    //     $data = [
    //         'client_id' => '2004',
    //         'client_secret' => 'o8Ycs7SdMTaqiKoioMwOcIZ2EEo8AeCPkwJB5zAd',
    //         'grant_type' => 'password',
    //         'username' => 'bert@vbdesign.be',
    //         'password' => '3OwBDg3J5suF',
    //         'scope' => 'whmcs-access',
    //     ];

    //     $url = 'https://api.vimexx.nl/auth/token';

    //     $response = Http::post($url, $data);
        
    //     $vimexx = json_decode($response->body());

    //     return  $vimexx->access_token;
    // }

    public function connect(){
        $vimexx = new Vimexx();
        // $token = $vimexx->requestAccessToken('https://api.vimexx.nl/auth/token');
        
        $check = $vimexx->checkDomain('jonathanverhaegen.be');
        dd($check);
    }
}
