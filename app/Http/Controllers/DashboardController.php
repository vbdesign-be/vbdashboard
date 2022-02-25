<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Justijndepover\Teamleader\Teamleader;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;
use GuzzleHttp\Client;

// use MadeITBelgium\TeamLeader\TeamLeader;




class DashboardController extends Controller
{
    

    
    //justijn
    public function connectTeamleader(Request $request){
        $CLIENT_ID = "d4edfc96ff1d0814c57f3ed0a72cebc8";
        $CLIENT_SECRET = "5970126c1d1c11eecda444da5c4a4a85";
        $REDIRECT_URI = "https://vbdashboard.test/teamleader";
        $STATE = "test";
        
        $teamleader = new Teamleader($CLIENT_ID, $CLIENT_SECRET, $REDIRECT_URI, $STATE);
        
        

        header("Location: {$teamleader->redirectForAuthorizationUrl()}");

        
        if ($request->input('error')) {
            // your application should handle this error
        }
        
        if ($request->input('state') != $teamleader->getState()) {
            // state value does not match, your application should handle this error
        }
        
        $teamleader->setAuthorizationCode($request->input('code'));
        
        $teamleader->connect();

        

        
        
    }


    public function loadView(Request $request){

        $CLIENT_ID = "d4edfc96ff1d0814c57f3ed0a72cebc8";
        $CLIENT_SECRET = "5970126c1d1c11eecda444da5c4a4a85";
        $REDIRECT_URI = "https://vbdashboard.test/teamleader";
        $STATE = "test";

        $teamleader = new Teamleader($CLIENT_ID, $CLIENT_SECRET, $REDIRECT_URI, $STATE);



        ;

    

    }


    // //madeitbelgium
    // public function connectTeamleader(Request $request){
    //     $appUrl = "https://vbdashboard.test";
    //     $authUrl = "https://focus.teamleader.eu";
    //     $clientId = "d4edfc96ff1d0814c57f3ed0a72cebc8";
    //     $clientSecret = "5970126c1d1c11eecda444da5c4a4a85";
    //     $redirectUri = "https://vbdashboard.test/teamleader";
    //     $redirect_url = "https://vbdashboard.test/teamleader";
        
    //     $teamLeader = new TeamLeader($appUrl, $authUrl, $clientId, $clientSecret, $redirectUri, $client = null);

    //     $teamLeader->setRedirectUrl($redirect_url);
    //     $redirectTo = $teamLeader->getAuthorizationUrl();
    //     //naar /teamleader

       

    //     $accessTokenResult = $teamLeader->requestAccessToken($request->get('code'));
        
    //     $access_token = $teamLeader->getAccessToken();
    //     $refresh_token = $teamLeader->getRefreshToken();
    //     $expired_at = $teamLeader->getExpiresAt();
        
    //     $teamLeader->setAccessToken($access_token);
    //     $teamLeader->setRefreshToken($refresh_token);
    //     $teamLeader->setExpiresAt($expired_at);
    //     $refresh = $teamLeader->checkAndDoRefresh();
    //     if (false !== $refresh) {
    //         $access_token = $teamLeader->getAccessToken();
    //         $refresh_token = $teamLeader->getRefreshToken();
    //         $expired_at = $teamLeader->getExpiresAt();
    //         //Save data to database
    //         echo "jiplaaaa";
    //     }
        

    // }

    // public function loadView(Request $request){
    //     $appUrl = "https://vbdashboard.test";
    //     $authUrl = "https://focus.teamleader.eu";
    //     $clientId = "d4edfc96ff1d0814c57f3ed0a72cebc8";
    //     $clientSecret = "5970126c1d1c11eecda444da5c4a4a85";
    //     $redirectUri = "https://vbdashboard.test/teamleader";
    //     $redirect_url = "https://vbdashboard.test/teamleader";
        
    //     $teamLeader = new TeamLeader($appUrl, $authUrl, $clientId, $clientSecret, $redirectUri, $client = null);

        
        

    //     $accessTokenResult = $teamLeader->requestAccessToken($request->get('code'));
        
        
    //     $access_token = $teamLeader->getAccessToken();
    //     $refresh_token = $teamLeader->getRefreshToken();
    //     $expired_at = $teamLeader->getExpiresAt();
        
    //     $teamLeader->setAccessToken($access_token);
    //     $teamLeader->setRefreshToken($refresh_token);
    //     $teamLeader->setExpiresAt($expired_at);
    //     $refresh = $teamLeader->checkAndDoRefresh();
    //     if (false !== $refresh) {
    //         $access_token = $teamLeader->getAccessToken();
    //         $refresh_token = $teamLeader->getRefreshToken();
    //         $expired_at = $teamLeader->getExpiresAt();
    //         //Save data to database
    //         echo "jiplaaaa";
    //     }
    // }



    //eigen code

    // public function connectTeamleader(){

    //     $appUrl = "https://vbdashboard.test";
    //     $authUrl = "https://focus.teamleader.eu";
    //     $clientId = "d4edfc96ff1d0814c57f3ed0a72cebc8";
    //     $clientSecret = "5970126c1d1c11eecda444da5c4a4a85";
    //     $redirectUri = "https://vbdashboard.test/teamleader";
    //     $redirect_url = "https://vbdashboard.test/teamleader";

    //     // $response = Http::get('https://focus.teamleader.eu/oauth2/authorize?client_id='.$clientId.'}&response_type=code&state=test&redirect_uri='. $redirectUri);
        
    //     header("Location: https://focus.teamleader.eu/oauth2/authorize?client_id=d4edfc96ff1d0814c57f3ed0a72cebc8&response_type=code&state=test&redirect_uri=https://vbdashboard.test/teamleader");
    //     exit;
    // }

    // public function loadView(Request $request){
        
    //     $appUrl = "https://vbdashboard.test";
    //     $authUrl = "https://focus.teamleader.eu";
    //     $clientId = "d4edfc96ff1d0814c57f3ed0a72cebc8";
    //     $clientSecret = "5970126c1d1c11eecda444da5c4a4a85";
    //     $redirectUri = "https://vbdashboard.test/teamleader";
    //     $redirect_url = "https://vbdashboard.test/teamleader";
    //     $code = $request->input('code');
        

    //     $data = [
    //             'code' => $code,
    //             'client_id' => $clientId,
    //             'client_secret' => $clientSecret,
    //             'redirect_uri' => $redirectUri,
    //             'grant_type' => 'authorization_code',
    //     ];

        
    //     $response = Http::post('https://focus.teamleader.eu/oauth2/access_token', $data);

    //     //check what is in response
    //     dd($response);
        

        

    //     // $data["client_id"] = "d4edfc96ff1d0814c57f3ed0a72cebc8";
    //     // $data["client_secret"] = "5970126c1d1c11eecda444da5c4a4a85";
    //     // $data["code"] = $request->input('code');
    //     // $data["grant_type"] = "authorization_code";
    //     // $data["redirect_uri"] = "https://vbdashboard.test/teamleader";

    //     // return view('teamleader', $data);
        
        
        
    // }

    // public function token(Request $request){

    //     // $response = Http::dd()->post('https://focus.teamleader.eu/oauth2/access_token', $request);

    //     // dd($response);
        
    // }

    

}
