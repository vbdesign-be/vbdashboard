<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Grosv\LaravelPasswordlessLogin\LoginUrl;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserLoginMail;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //return login view
    public function login(){
        return view('login');
    }

    //return register view
    public function register(){

        //array with all sectors
        $sectoren = [
            'it',
            'entertainment',
            'sport'
        ];

        //getting data of account with teamleader api and sending it to view->todo

         $data["sectors"] = $sectoren;
         return view('register', $data);

    }

    //saving a new account in database
    public function store(Request $request){

        

        //checking
        $credentials = $request->validate([
            'voornaam' => 'required|max:255',
            'familienaam' => 'required|max:255',
            'email' => 'required|email'
        ]);
        
        //saving a new user
        $user = new User();
        $user->firstname = $request->input('voornaam');
        $user->lastname = $request->input('familienaam');
        $user->email = $request->input('email');
        $user->company = $request->input('bedrijfsnaam');
        $user->btwnumber = $request->input('btwnummer');
        $user->gsm = $request->input('gsm');
        $user->phone = $request->input('telefoon');
        $user->adress = $request->input('adres');
        $user->city = $request->input('stad');
        $user->sector = $request->input('sector');
        $user->save();

        $request->flash();

        $request->session()->flash('message', 'je account is aangemaakt, log in om ons platform te gebruiken');

        //todo: saving data of user in teamleader via api

        return redirect('/login');
    }

    //function wich checks of user canlogin
    public function canLogin(Request $request){
        //checking of email is filled in
        $credentials = $request->validate([
            'email' => 'required|email'
        ]);

        //getting data of the user out of database
        $user = User::where('email', $request->input('email'))->first();
        
        if(!$user){
            //no user found:
            $request->session()->flash('error', 'Er is geen account gevonden met dit emailadress');
            return redirect('login');
        }else{
            //user found:
            $generator = new LoginUrl($user);
            
            //generating the loginlink for in the mail
            $data['url'] = $generator->generate();
            $data['user'] = $user;

            //sending the email
            Mail::to($user->email)->send(new UserLoginMail($data));

            //message flashen
            $request->flash();
            $request->session()->flash('message', 'We hebben een mail gestuurd naar ' . $user->email . ' met een loginlink');
            
            //load waiting view
            return redirect('/login');
        
        }
    }


    //user logout
    public function logout(){
        Auth::logout();
        return redirect('./login');
    }


}
