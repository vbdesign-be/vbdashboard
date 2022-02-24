<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Justijndepover\Teamleader\Teamleader;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;

// use MadeITBelgium\TeamLeader\TeamLeader;




class DashboardController extends Controller
{
    

    
    //justijn
    // public function connectTeamleader(Request $request){
    //     $CLIENT_ID = "d4edfc96ff1d0814c57f3ed0a72cebc8";
    //     $CLIENT_SECRET = "5970126c1d1c11eecda444da5c4a4a85";
    //     $REDIRECT_URI = "https://vbdashboard.test/teamleader";
    //     $STATE = "test";
        
    //     $teamleader = new Teamleader($CLIENT_ID, $CLIENT_SECRET, $REDIRECT_URI, $STATE);
        
        

    //     header("Location: {$teamleader->redirectForAuthorizationUrl()}");

        
    //     if ($request->input('error')) {
    //         // your application should handle this error
    //     }
        
    //     if ($request->input('state') != $teamleader->getState()) {
    //         // state value does not match, your application should handle this error
    //     }
        
    //     $teamleader->setAuthorizationCode($request->input('code'));
        
    //     $teamleader->connect();

        

        
        
    // }


    // public function loadView(Request $request){

    //     $CLIENT_ID = "d4edfc96ff1d0814c57f3ed0a72cebc8";
    //     $CLIENT_SECRET = "5970126c1d1c11eecda444da5c4a4a85";
    //     $REDIRECT_URI = "https://vbdashboard.test/teamleader";
    //     $STATE = "test";

    //     $teamleader = new Teamleader($CLIENT_ID, $CLIENT_SECRET, $REDIRECT_URI, $STATE);



    //     // // // fetch data:
    //     // // $teamleader->crm->get();

    //     // // you should always store your tokens at the end of a call
    //     // $accessToken = $teamleader->getAccessToken();
    //     // $refreshToken = $teamleader->getRefreshToken();
    //     // $expiresAt = $teamleader->getTokenExpiresAt();

    //     // dd($teamleader);

    //     // return view('teamleader');

    //     $code = $request->input("code");

    //     $teamleader->acquireAccessToken();

    // }


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

    public function connectTeamleader(){

        $appUrl = "https://vbdashboard.test";
        $authUrl = "https://focus.teamleader.eu";
        $clientId = "d4edfc96ff1d0814c57f3ed0a72cebc8";
        $clientSecret = "5970126c1d1c11eecda444da5c4a4a85";
        $redirectUri = "https://vbdashboard.test/teamleader";
        $redirect_url = "https://vbdashboard.test/teamleader";

        // $response = Http::get('https://focus.teamleader.eu/oauth2/authorize?client_id='.$clientId.'}&response_type=code&state=test&redirect_uri='. $redirectUri);
        
        header("Location: https://focus.teamleader.eu/oauth2/authorize?client_id=d4edfc96ff1d0814c57f3ed0a72cebc8&response_type=code&state=test&redirect_uri=https://vbdashboard.test/teamleader");
        exit;
    }

    public function loadView(Request $request){
        $appUrl = "https://vbdashboard.test";
        $authUrl = "https://focus.teamleader.eu";
        $clientId = "d4edfc96ff1d0814c57f3ed0a72cebc8";
        $clientSecret = "5970126c1d1c11eecda444da5c4a4a85";
        $redirectUri = "https://vbdashboard.test/teamleader";
        $redirect_url = "https://vbdashboard.test/teamleader";
        $code = $request->input('code');
        $data["client_id"] = "d4edfc96ff1d0814c57f3ed0a72cebc8";
        $data["client_secret"] = "5970126c1d1c11eecda444da5c4a4a85";
        $data["code"] = $request->input('code');
        $data["grant_type"] = "authorization_code";
        $data["redirect_uri"] = "https://vbdashboard.test/teamleader";

        return view('teamleader', $data);

        
        

        

        // $data = [
        //     "client_id" => $clientId,
        //     "client_secret" => $clientSecret,
        //     "code" => $request->input('code'),
        //     "grant_type" => "authorization_code",
        //     "redirect_uri" => $redirectUri
        // ];


        // $response = Http::dd()->post('https://focus.teamleader.eu/oauth2/access_token', );

        

        // $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJkNGVkZmM5NmZmMWQwODE0YzU3ZjNlZDBhNzJjZWJjOCIsImp0aSI6ImJlYWIwOTZhMjMyZDVmOTM1ODMxYmU3ZDgyNmJhODExNWZmNzM3NTA1NjgyY2M0OTk0ZThkMzkyMDI1Y2MzNmE2M2Q0ZGEwMTgxNDU4NzM3IiwiaWF0IjoxNjQ1NzE0MDUwLCJuYmYiOjE2NDU3MTQwNTAsImV4cCI6MTY0NTcxNzY1MCwic3ViIjoiMTQ5OTkxOjI3MjI2MyIsInNjb3BlcyI6WyJjb21wYW5pZXMiLCJjb250YWN0cyIsImludm9pY2VzIiwicXVvdGF0aW9ucyJdLCJwZXJtaXNzaW9ucyI6WyJhZG1pbiIsImJpbGxpbmciLCJjYWxlbmRhciIsImNvbXBhbmllcyIsImNvbnRhY3RzIiwiY3JlZGl0X25vdGVzIiwiZGFzaGJvYXJkIiwiZGVhbHMiLCJkZWxpdmVyeV9ub3RlcyIsImluc2lnaHRzIiwiaW52b2ljZXMiLCJvcmRlcl9jb25maXJtYXRpb25zIiwib3JkZXJzIiwicHJvZHVjdF9wdXJjaGFzZV9wcmljZSIsInByb2R1Y3RzIiwicHJvamVjdF9wbGFubmluZyIsInByb2plY3RzIiwicmVzb3VyY2VfcGxhbm5pbmciLCJzZXR0aW5ncyIsInN1YnNjcmlwdGlvbnMiLCJ0YXJnZXRzIiwidGlja2V0cyIsInRpbWVfdHJhY2tpbmciLCJ0b2RvcyIsInVzZXJzIiwid2ViaG9va3MiXX0.a7bgnbB6gWUzb_iczWehTSPvKJDK0W58koYMfy4CNe1z7Kzi-MYrX4GLW6GQRcB0xlnjtYp37-h8W6rXwI7JFvxb0Xi3YmV0E0sjYCNe6789N4EbW_mXGrIfXMuHNSmIjPjk2oHjmPRL4anfS3TDTuxuI7Lnh2dT94h6a_Lk-Uc";

        // $resp = Http::get('https://api.focus.teamleader.eu/contacts.list');

        // dd($resp);

        
    }

    public function token(Request $request){

        $response = Http::dd()->post('https://focus.teamleader.eu/oauth2/access_token', $request);

        dd($response);
    }

    

}
