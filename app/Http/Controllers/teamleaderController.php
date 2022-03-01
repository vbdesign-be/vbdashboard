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

        return redirect('/');

    }


    public function contacts(){

        $this->reAuthTL();

        // $contacts = TeamLeader::crm()->contact()->list();

        $contacts = TeamLeader::crm()->contact()->info("83007810-b364-00b2-bc72-ff97826406ef");
        dd($contacts);
        


    }

    public function companies(){
        $this->reAuthTL();

        $companies = TeamLeader::crm()->company()->list();
        dd($companies);

    }

    public function facturen(){
        $this->reAuthTL();

        $facturen = TeamLeader::invoicing()->invoices()->list();
        dd($facturen);
    }

    public function offertes(){
        $this->reAuthTL();
        $offertes = TeamLeader::deals()->list($data = []);
        dd($offertes);
    }

    public function register(){
        $this->reAuthTL();
        $users = TeamLeader::crm()->contact()->list(['filter' => ['tags' => [0 => "klant"]] ]);
        dd($users);
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
