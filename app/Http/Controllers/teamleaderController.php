<?php

namespace App\Http\Controllers;

use App\Models\Teamleader as TeamleaderConnection;
use Illuminate\Http\Request;
use MadeITBelgium\TeamLeader\Facade\TeamLeader;

class teamleaderController extends Controller
{

    

    public function requestToken(){
        
        TeamLeader::setRedirectUrl('https://vbdashboard.test/teamleader');
        $redirect = TeamLeader::getAuthorizationUrl();
        return redirect($redirect);
        
    }
    

    public function teamleader(Request $request){
        
        $accessTokenResult = TeamLeader::requestAccessToken($request->get('code'));
        
        $access_token = TeamLeader::getAccessToken();
        $refresh_token = TeamLeader::getRefreshToken();
        $expired_at = TeamLeader::getExpiresAt();

        
        $teamleaderConnection = TeamleaderConnection::find(1)->first();
        $teamleaderConnection->accesToken = $access_token;
        $teamleaderConnection->refreshToken = $refresh_token;
        $teamleaderConnection->expiresAt = $expired_at;
        $teamleaderConnection->type = 'teamleader';
        $teamleaderConnection->state = 'connection';
        $teamleaderConnection->save();

    }


    public function contacts(){

        $this->reAuthTL();

        $contacts = TeamLeader::crm()->contact()->list();
        dd($contacts);
        


    }

    public function companies(){
        $this->reAuthTL();

        $companies = TeamLeader::crm()->company()->list();
        dd($companies);

    }



    private function reAuthTL()
    {
        $apiConnection = TeamleaderConnection::where('type', 'teamleader')->first();
        
        TeamLeader::setAccessToken($apiConnection->accesToken);
        TeamLeader::setRefreshToken($apiConnection->refreshToken);
        TeamLeader::setExpiresAt($apiConnection->expiresAt);

        
        $refresh = TeamLeader::checkAndDoRefresh();
        
        if (false !== $refresh) {
            $access_token = TeamLeader::getAccessToken();
            $refresh_token = TeamLeader::getRefreshToken();
            $expired_at = TeamLeader::getExpiresAt();

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
