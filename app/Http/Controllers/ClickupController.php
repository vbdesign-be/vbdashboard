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
        header("Location: {$url}");
        exit;
    }

    public function accessToken(Request $request){
        $code = $request->input('code');
        $clientId = env('CLICKUP_ID');
        $clientSecret = env('CLICKUP_SECRET');
        $redirectUri = env('CLICKUP_REDIRECT');

        $url = 'https://app.clickup.com/api/v2/oauth/token';

        $data['client_id'] = $clientId;
        $data['client_secret'] = $clientSecret;
        $data["code"] = $code;

        $test = ['body' => json_encode($data)];

        $resp = Http::post($url.'?client_id='.$clientId.'&client_secret='.$clientSecret.'&code='.$code);

        $data = json_decode($resp->body());

        $clickup = new Clickup();
        $clickup->token = $data->access_token;
        $clickup->save();
        
        return redirect('/login');

    }

    public function getTasks(){
        $clickup = Clickup::find(1);
        $token = $clickup->token;
        
        $url = 'https://app.clickup.com/api/v2/list/40397755/task';

        $response = Http::withToken($token)->get($url);

        $data = json_decode($response->body());

        dd($data); 
        
    }
}
