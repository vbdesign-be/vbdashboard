<?php

namespace App\Http\Controllers;

use App\Models\Infoteamleader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use MadeITBelgium\TeamLeader\TeamLeader;




class DashboardController extends Controller
{
    
    public function connectTeamleader(Request $request){
        $appUrl = "https://vbdashboard.test";
        $authUrl = "https://focus.teamleader.eu";
        $clientId = "d4edfc96ff1d0814c57f3ed0a72cebc8";
        $clientSecret = "5970126c1d1c11eecda444da5c4a4a85";
        $redirectUri = "https://vbdashboard.test/teamleader";
        $redirect_url = "https://vbdashboard.test/teamleader";

    
        $teamLeader = new TeamLeader($appUrl, $authUrl, $clientId, $clientSecret, $redirectUri, $client = null);

        $teamLeader->setRedirectUrl($redirect_url);
        $redirectTo = $teamLeader->getAuthorizationUrl();

        
        $accessTokenResult = $teamLeader->requestAccessToken($request->input('code'));
        // $access_token = $teamLeader->getAccessToken();
        // $refresh_token = $teamLeader->getRefreshToken();
        // $expired_at = $teamLeader->getExpiresAt();

        // $refresh = $teamLeader->checkAndDoRefresh();

        dd($accessTokenResult);
        // if (false !== $refresh) {
        //     $access_token = $teamLeader->getAccessToken();
        //     $refresh_token = $teamLeader->getRefreshToken();
        //     $expired_at = $teamLeader->getExpiresAt();
        //     //Save data to database

        //     $data["token"]

        //     return view('teamleader', $data);
        // }   
        
        

    }

    public function getConnection(Request $request){

        // $appUrl = "https://vbdashboard.test";
        // $authUrl = "https://focus.teamleader.eu";
        // $clientId = "d4edfc96ff1d0814c57f3ed0a72cebc8";
        // $clientSecret = "5970126c1d1c11eecda444da5c4a4a85";
        // $redirectUri = "https://vbdashboard.test/teamleader";
        // $redirect_url = "https://vbdashboard.test/teamleader";

    
        // $teamLeader = new TeamLeader($appUrl, $authUrl, $clientId, $clientSecret, $redirectUri, $client = null);

        // $accessTokenResult = $teamLeader->requestAccessToken($request->input('code'));
        // $access_token = $teamLeader->getAccessToken();
        // $refresh_token = $teamLeader->getRefreshToken();
        // $expired_at = $teamLeader->getExpiresAt();

        return view('teamleader');
    }

    // public function connectTeamleader(Request $request){
    //     $CLIENT_ID = "d4edfc96ff1d0814c57f3ed0a72cebc8";
    //     $CLIENT_SECRET = "5970126c1d1c11eecda444da5c4a4a85";
    //     $REDIRECT_URI = "https://vbdashboard.test/teamleader";
    //     $STATE = "test";
        
        
    //     return view('teamleader');
        
    // }

    // public function getConnection(Request $request){

        
        
    //     // $CLIENT_ID = "d4edfc96ff1d0814c57f3ed0a72cebc8";
    //     // $CLIENT_SECRET = "5970126c1d1c11eecda444da5c4a4a85";
    //     // $REDIRECT_URI = "https://vbdashboard.test/teamleader";
    //     // $STATE = "test";
    //     // $teamleader = new Teamleader($CLIENT_ID, $CLIENT_SECRET, $REDIRECT_URI, $STATE);

    //     if ($request->input('error')) {
    //         // your application should handle this error
    //     }
        
    //     if ($request->input('state') != $teamleader->getState()) {
    //         // state value does not match, your application should handle this error
    //     }
        
    //     $teamleader->setAuthorizationCode($request->input('code'));
    //     $teamleader->connect();
        
    //     // store these values:
    //     $accessToken = $teamleader->getAccessToken();
    //     $refreshToken = $teamleader->getRefreshToken();
    //     $expiresAt = $teamleader->getTokenExpiresAt();

    //     return view('teamleader');
        
    // }

}
