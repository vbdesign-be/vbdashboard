<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Grosv\LaravelPasswordlessLogin\LoginUrl;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserLoginMail;
use App\Models\Company;
use App\Models\Emailtest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //return login view
    public function login(){
        $test = Emailtest::get();
        $data['test'] = $test;
        return view('login', $data);
    }


    //saving a new account in database
    public function store(Request $request){

        

        //checking
        $credentials = $request->validate([
            'voornaam' => 'required|max:255',
            'familienaam' => 'required|max:255',
            'email' => 'required|email',
            'bedrijfsnaam' => 'required|max:255',
            'bedrijfsemail' => 'required|email',
            'btw-nummer' => 'required|max:255'
        ]);
        
        //saving a new user
        $user = new User();
        $user->firstname = $request->input('voornaam');
        $user->lastname = $request->input('familienaam');
        $user->email = $request->input('email');
        $user->gsm = $request->input('gsm');
        $user->save();

        $newUser = User::where('email', $request->input('email'))->first();

        $company = new Company();
        $company->name = $request->input('bedrijfsnaam');
        $company->email = $request->input('bedrijfsemail');
        $company->VAT = $request->input('btw-nummer');
        $company->phone = $request->input('telefoon');
        $company->adress = $request->input('straat');
        $company->postalcode = $request->input('postcode');
        $company->city = $request->input('plaats');
        $company->sector = $request->input('sector');
        $company->user_id = $newUser->id;
        $company->save();


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
            $request->session()->flash('error', 'Er is geen account gevonden met dit emailadres');
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
