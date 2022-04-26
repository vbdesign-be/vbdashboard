<?php

namespace App\Http\Controllers;

use App\Models\Clickup;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ClickupController extends Controller
{
    public function requestToken(){
        $clientId = env('CLICKUP_ID');
        $clientSecret = env('CLICKUP_SECRET');
        $redirectUri = env('CLICKUP_REDIRECT');
        
        $url = 'https://app.clickup.com/api?client_id='. $clientId .'&redirect_uri='.$redirectUri;
        //redirecten naar de url om de connectie te laten starten
        header("Location: {$url}");
        exit;
    }

    public function accessToken(Request $request){
        //verschillende parameters voor de post ophalen
        $code = $request->input('code');
        $clientId = env('CLICKUP_ID');
        $clientSecret = env('CLICKUP_SECRET');
        $redirectUri = env('CLICKUP_REDIRECT');

        $url = 'https://app.clickup.com/api/v2/oauth/token';

        $data['client_id'] = $clientId;
        $data['client_secret'] = $clientSecret;
        $data["code"] = $code;

        //post doen naar de url om de accestoken te verkrijgen
        $resp = Http::post($url.'?client_id='.$clientId.'&client_secret='.$clientSecret.'&code='.$code);
        $data = json_decode($resp->body());

        //acces token van clickup opslaan
        $clickup = new Clickup();
        $clickup->token = $data->access_token;
        $clickup->save();
        
        //redirecten naar de loginpage
        return redirect('/login');

    }
}
