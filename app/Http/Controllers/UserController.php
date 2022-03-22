<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Grosv\LaravelPasswordlessLogin\LoginUrl;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserLoginMail;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use MadeITBelgium\TeamLeader\Facade\TeamLeader;
use App\Models\Teamleader as TeamleaderConnection;

class UserController extends Controller
{

    public function profile(){

        teamleaderController::reAuthTL();

        $dataUser = Auth::user();

        $userUpdate = User::find(Auth::id());
        if(!$userUpdate->didLogin){
            $userUpdate->didLogin = 1;
            $userUpdate->save();
        }
        
        $resp = TeamLeader::crm()->contact()->info($dataUser->teamleader_id);
        $user = $resp->data;
        $phone = "";
        $mobile = "";
        $company_id = "";
        $avatar = $dataUser->avatar;
    
        $emails = $resp->data->emails;
        foreach($emails as $e){
            $email = $e->email;
        }

        $telephones = $resp->data->telephones;
        for($x = 0; $x < count($telephones); $x++){
            if($telephones[$x]->type === "mobile"){
                $mobile = $telephones[$x]->number;
            }

            if($telephones[$x]->type === "phone"){
                $phone = $telephones[$x]->number;
            }
        }

        $companies = $resp->data->companies;
        
        foreach($companies as $c){
            $company_id = $c->company->id;
            $comps[] = TeamLeader::crm()->company()->info($company_id);
        }

        
        

        $data['user'] = $user;
        $data['user']->email = $email;
        $data['user']->phone= $phone;
        $data['user']->mobile = $mobile;
        $data['user']->avatar = $avatar;
        $data['user']->companies = $comps;
        return view('profile', $data);
    }

    public function updateUser(Request $request){
        
        teamleaderController::reAuthTL();

        //checking
        $credentials = $request->validate([
            'voornaam' => 'required|max:255',
            'familienaam' => 'required|max:255',
            'email' => 'required|email',
        ]);

        $user = auth::user();
        $teamleader_id = $user->teamleader_id;
        $firstname = $request->input('voornaam');
        $lastname = $request->input('familienaam');
        $email = $request->input('email');
        $phone = $request->input('telefoon');
        $mobile = $request->input('gsm');
        
        if(empty($phone) && empty($mobile)){
            TeamLeader::crm()->contact()->update($teamleader_id, [
                'emails' => ['object' => ['type' => "primary", 'email' => $email]], 
                'first_name' => $firstname, 
                'last_name' => $lastname,
                'telephones' => [],
            ]);
        }elseif(empty($phone)){
            TeamLeader::crm()->contact()->update($teamleader_id, [
                'emails' => ['object' => ['type' => "primary", 'email' => $email]], 
                'first_name' => $firstname, 
                'last_name' => $lastname,
                'telephones' => ['object' => ['type' => "mobile", 'number' => $mobile]]
            ]);
        }elseif(empty($mobile)){
            TeamLeader::crm()->contact()->update($teamleader_id, [
                'emails' => ['object' => ['type' => "primary", 'email' => $email]], 
                'first_name' => $firstname, 
                'last_name' => $lastname,
                'telephones' => ['object' => ['type' => "phone", 'number' => $phone]]
            ]);
        }else{
            TeamLeader::crm()->contact()->update($teamleader_id, [
                'emails' => ['object' => ['type' => "primary", 'email' => $email]], 
                'first_name' => $firstname, 
                'last_name' => $lastname,
                'telephones' => ['object' => ['type' => "mobile", 'number' => $mobile], ['type' => 'phone', 'number' => $phone]]
            ]);
        }

        $newUser = User::find(Auth::id());
        $newUser->email = $email;
        $newUser->save();

        $request->session()->flash('message', 'je account is geüpdate');
        return redirect('/profiel');


    }

    public function updateAvatar(Request $request){
        $credentials = $request->validate([

            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $imageName = time().'.'.$request->avatar->extension();
        $request->avatar->move(public_path('img'), $imageName);
        $user = User::find(Auth::id());
        $user->avatar = $imageName;
        $user->save();

        $request->session()->flash('message', 'je avatar is geüpdate');
        return redirect('/profiel');

    }

    public static function getUser(){
        teamleaderController::reAuthTL();
        $user = TeamLeader::crm()->contact()->info(Auth::user()->teamleader_id);
        return $user;
    }
    
}