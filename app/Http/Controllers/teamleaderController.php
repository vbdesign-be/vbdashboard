<?php

namespace App\Http\Controllers;

use App\Models\Teamleader as TeamleaderConnection;
use App\Models\User;
use Illuminate\Http\Request;
use Vbdesign\Teamleader\Facade\Teamleader;

class teamleaderController extends Controller
{
    //request token opvragen aan teamleader api
    public function requestToken(){
        $redirect = env('TEAMLEADER_REDIRECT');
        Teamleader::setRedirectUrl($redirect);
        $redirect = Teamleader::getAuthorizationUrl();
        return redirect($redirect);
    }
    
    //accestoken opvragen, de connectie met de api afronden en token opslaan
    public function teamleader(Request $request){
        $accessTokenResult = Teamleader::requestAccessToken($request->get('code'));
        
        $access_token = Teamleader::getAccessToken();
        $refresh_token = Teamleader::getRefreshToken();
        $expired_at = Teamleader::getExpiresAt();

        $teamleaderConnection = TeamleaderConnection::find(1)->first();
        $teamleaderConnection->accesToken = $access_token;
        $teamleaderConnection->refreshToken = $refresh_token;
        $teamleaderConnection->expiresAt = $expired_at;
        $teamleaderConnection->type = 'teamleader';
        $teamleaderConnection->state = 'connection';
        $teamleaderConnection->save();

        return redirect('/');
    }

    //fucntie die met de refreshtoken de connectie met de teamleader api terug aanvraagt
    //hebben we nodig omdat de connectie met teamleader api uitvalt na 15min
    public static function reAuthTL(){
        $apiConnection = TeamleaderConnection::where('type', 'teamleader')->first();
        
        Teamleader::setAccessToken($apiConnection->accesToken);
        Teamleader::setRefreshToken($apiConnection->refreshToken);
        Teamleader::setExpiresAt($apiConnection->expiresAt);

        $refresh = Teamleader::checkAndDoRefresh();
        
        if (false !== $refresh) {
            $access_token = Teamleader::getAccessToken();
            $refresh_token = Teamleader::getRefreshToken();
            $expired_at = Teamleader::getExpiresAt();

            $teamleaderConnection = TeamleaderConnection::find(1)->first();
            $teamleaderConnection->accesToken = $access_token;
            $teamleaderConnection->refreshToken = $refresh_token;
            $teamleaderConnection->expiresAt = $expired_at;
            $teamleaderConnection->type = 'teamleader';
            $teamleaderConnection->state = 'connection';
            $teamleaderConnection->save();

        }
        
    }
}
