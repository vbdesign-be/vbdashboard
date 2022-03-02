<?php

namespace App\Http\Controllers;

use App\Models\Teamleader as TeamleaderConnection;
use App\Models\User;
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

    public function updateBert(){
        $this->reAuthTL();
        $user = User::where('email', 'bert@vbdesign.be')->first();
        $teamleader_id = $user->teamleader_id;

        TeamLeader::crm()->contact()->update($teamleader_id, ['emails' => ['object' => ['type' => "primary", 'email' => 'bert@vbdesign']]]);
        TeamLeader::crm()->contact()->update($teamleader_id, ['telephones' => ['object' => ['type' => "mobile", 'number' => '0498745612']]]);
    }

    public function register(){
        $this->reAuthTL();

        for($x = 1; $x <= 10; $x++){
            $resp[] = TeamLeader::crm()->contact()->list(['filter' => ['tags' => [0 => "klant"]], 'page' => ['number' => $x, 'size' => 100]]);
        }

        for($x = 0; $x < count($resp); $x++){
            $users = $resp[$x]->data;

            foreach($users as $u){

                $emails = $u->emails;
                foreach($emails as $e){
                    $email = $e->email;
                }
                
               $checkUser = User::where('teamleader_id', $u->id)->first();
               if(!$checkUser){
                   $newUser = new User();
                   $newUser->email = $email;
                   $newUser->teamleader_id = $u->id;
                   $newUser->save();
               }
           }

        }

        return redirect('/login');
        
    }

   

    public function registerBert(){
        $this->reAuthTL();
        
        //kijken of ze klant tag hebben

        $resp = TeamLeader::crm()->contact()->list(['filter' => ['tags' => [0 => "klant"], 'email' => ['type' => 'primary', 'email' => 'bert@vbdesign.be']]]);

        $userNew = $resp->data[0];

        $checkUser = User::where('email', $userNew->emails[0]->email)->first();

        if($checkUser){
                
        }else{
            $user = new User();
            $user->email = $userNew->emails[0]->email;
            $user->teamleader_id = $userNew->id;
            $user->save();
                
        }

        return redirect("/login");

        
    }



    public static function reAuthTL()
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
