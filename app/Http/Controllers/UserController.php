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
        $resp = TeamLeader::crm()->contact()->info($dataUser->teamleader_id);
        $user = $resp->data;
        $phone = "";
        $mobile = "";
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

        
            
        
        $data['user'] = $user;
        $data['email'] = $email;
        $data['phone'] = $phone;
        $data['mobile'] = $mobile;
        $data['avatar'] = $avatar;
        return view('profile', $data);
    }

    public function updateUser(Request $request){
        //checking
        $credentials = $request->validate([
            'voornaam' => 'required|max:255',
            'familienaam' => 'required|max:255',
            'email' => 'required|email'
        ]);

        $id = Auth::id();

        $user = User::find($id);
        
        $user->firstname = $request->input('voornaam');
        $user->lastname = $request->input('familienaam');
        $user->email = $request->input('email');
        $user->save();

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

        return redirect('/profiel');

    }

   

    
}