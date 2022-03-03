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



    public function register(){
        $this->reAuthTL();

        // $user = User::where("email", 'bert@vbdesign.be')->first();
        // $bert = TeamLeader::crm()->contact()->info($user->teamleader_id)->data;
        
        // if(empty($user)){
        //     echo 'niemand in de databank';
        // }else{
        //     if(empty($bert->tags)){
        //         $user1 = User::where("email", 'bert@vbdesign.be')->first();
        //         $user1->tag = 'empty';
        //         $user1->save();
        //     }else{
        //         $user1 = User::where("email", 'bert@vbdesign.be')->first();
        //         $user1->tag = $bert->tags[0];
        //         $user1->save();
        //     }
        // }



        for ($x = 1; $x <= 10; $x++) {
            $resp[] = TeamLeader::crm()->contact()->list(['filter' => ['tags' => [0 => "klant"]], 'page' => ['number' => $x, 'size' => 100]]);
        }
       

        for ($x = 0; $x < count($resp); $x++) {
            $users = $resp[$x]->data;
        
        
            

            foreach ($users as $u) {
                
                $emails = $u->emails;
                foreach ($emails as $e) {
                    $email = $e->email;
                }
                $checkUser = User::where('teamleader_id', $u->id)->first();
              
                if(empty($checkUser)) {
                    $newUser = new User();
                    $newUser->email = $email;
                    $newUser->teamleader_id = $u->id;
                    $newUser->tag = $u->tags[0];
                    $newUser->save();
                }else{
                    if (empty($u->tags)){
                        $user = User::where('teamleader_id', $u->id)->first();
                        $user->email = $email;
                        $user->teamleader_id = $u->id;
                        $user->tag = 'empty';
                        $user->save();
                    } else {
                        $user = User::where('teamleader_id', $u->id)->first();
                        dd($user);
                        $user->email = $email;
                        $user->teamleader_id = $u->id;
                        $user->tag = $u->tags[0];
                        $user->save();
                    }
                }
            }
            // return redirect('/login');
        }
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
