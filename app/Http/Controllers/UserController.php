<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Grosv\LaravelPasswordlessLogin\LoginUrl;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserLoginMail;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Vbdesign\Teamleader\Facade\Teamleader;
use App\Models\Teamleader as TeamleaderConnection;

class UserController extends Controller
{
    //profile pagina van de ingelogde gebruiker
    public function profile(){
        teamleaderController::reAuthTL();
        $dataUser = Auth::user();
        $userUpdate = User::find(Auth::id());

        //kijken of het de eerste keer is dat de gebruiker inlogd en dit wijzigen
        if(!$userUpdate->didLogin){
            $userUpdate->didLogin = 1;
            $userUpdate->save();
        }
        
        $resp = Teamleader::crm()->contact()->info($dataUser->teamleader_id);
        $user = $resp->data;
        $phone = "";
        $mobile = "";
        $company_id = "";
        $avatar = $dataUser->avatar;
        
        //gebruiker kan in teamleader meerdere emails hebben
        $emails = $resp->data->emails;
        foreach($emails as $e){
            $email = $e->email;
        }

        //gebruiker kan in teamleader meerdere telefoonnummers hebben
        $telephones = $resp->data->telephones;
        for($x = 0; $x < count($telephones); $x++){
            if($telephones[$x]->type === "mobile"){
                $mobile = $telephones[$x]->number;
            }

            if($telephones[$x]->type === "phone"){
                $phone = $telephones[$x]->number;
            }
        }

        //bedrijven van een gebruiker ophalen
        $companies = $resp->data->companies;
        foreach($companies as $c){
            $company_id = $c->company->id;
            $comps[] = Teamleader::crm()->company()->info($company_id);
        }

        $data['user'] = $user;
        $data['user']->email = $email;
        $data['user']->phone= $phone;
        $data['user']->mobile = $mobile;
        $data['user']->avatar = $avatar;
        $data['user']->companies = $comps;
        return view('profile', $data);
    }

    //informatie van de gebruiker updaten
    public function updateUser(Request $request){
        teamleaderController::reAuthTL();

        //kijken of alle velden zijn ingevuld
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
        
        //userinformatie in teamleader updaten
        if(empty($phone) && empty($mobile)){
            Teamleader::crm()->contact()->update($teamleader_id, [
                'emails' => ['object' => ['type' => "primary", 'email' => $email]], 
                'first_name' => $firstname, 
                'last_name' => $lastname,
                'telephones' => [],
            ]);
        }elseif(empty($phone)){
            Teamleader::crm()->contact()->update($teamleader_id, [
                'emails' => ['object' => ['type' => "primary", 'email' => $email]], 
                'first_name' => $firstname, 
                'last_name' => $lastname,
                'telephones' => ['object' => ['type' => "mobile", 'number' => $mobile]]
            ]);
        }elseif(empty($mobile)){
            Teamleader::crm()->contact()->update($teamleader_id, [
                'emails' => ['object' => ['type' => "primary", 'email' => $email]], 
                'first_name' => $firstname, 
                'last_name' => $lastname,
                'telephones' => ['object' => ['type' => "phone", 'number' => $phone]]
            ]);
        }else{
            Teamleader::crm()->contact()->update($teamleader_id, [
                'emails' => ['object' => ['type' => "primary", 'email' => $email]], 
                'first_name' => $firstname, 
                'last_name' => $lastname,
                'telephones' => ['object' => ['type' => "mobile", 'number' => $mobile], ['type' => 'phone', 'number' => $phone]]
            ]);
        }

        //userinformatie in database updaten
        $updateUser = User::find(Auth::id());
        $updateUser->email = $email;
        $updateUser->firstname = $firstname;
        $updateUser->lastname = $lastname;
        $updateUser->save();

        $request->session()->flash('message', 'je account is ge??pdate');
        return redirect('/profiel');
    }

    //avatar van een gebruiker updaten
    public function updateAvatar(Request $request){
        //checken of het avatar veld is ingevukd
        $credentials = $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        //foto opslaan in de public map
        $imageName = time().'.'.$request->avatar->extension();
        $request->avatar->move(public_path('img'), $imageName);
        $user = User::find(Auth::id());
        $user->avatar = $imageName;
        $user->save();

        $request->session()->flash('message', 'je avatar is ge??pdate');
        return redirect('/profiel');
    }

    //teamleader informatie van een bepaalde user verkrijgen
    public static function getUser(){
        teamleaderController::reAuthTL();
        $user = TeamLeader::crm()->contact()->info(Auth::user()->teamleader_id);
        return $user;
    }
}