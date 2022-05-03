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


    //fucntie die alle contactpersonen checkt in teamleader of ze de tag klant hebben
    //hebben ze klant->opslaan in database
    //waren ze klant en nu niet meer->verwijderen uit database
    public function register(){
        $this->reAuthTL();
        for ($x = 1; $x <= 10; $x++) {
            $resp[] = Teamleader::crm()->contact()->list([ 'page' => ['number' => $x, 'size' => 100]]);
        }

        foreach($resp as $r){
            foreach($r->data as $t){
                $users [] = $t;
            }
        }

        foreach ($users as $u) {
            $emails = $u->emails;
            foreach ($emails as $e) {
                $email = $e->email;
            }
                
            $checkUser = User::where('teamleader_id', $u->id)->first();

            if (!empty($u->tags[0])) {
                if ($u->tags[0] === 'klant') {
                    if (empty($checkUser)) {
                        $newUser = new User();
                        $newUser->email = $email;
                        $newUser->teamleader_id = $u->id;
                        $newUser->tag = $u->tags[0];
                        $newUser->save();
                    } else {
                        $user = User::where('teamleader_id', $u->id)->first();
                        $user->email = $email;
                        $user->teamleader_id = $u->id;
                        $user->tag = $u->tags[0];
                        $user->save();
                    }
                } else {
                    if (!empty($checkUser)) {
                        $checkUser->delete();
                    }
                }
            } elseif (empty($u->tags[0])) {
                if (!empty($checkUser)) {
                    $checkUser->delete();
                }
            }
        }
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
