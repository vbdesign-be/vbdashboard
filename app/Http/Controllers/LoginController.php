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
use Vbdesign\Teamleader\Facade\Teamleader;


class LoginController extends Controller
{
    //return login view
    public function login(){
        $test = Emailtest::get();
        $data['test'] = $test;
        return view('login', $data);
    }

    //functie die kijkt of een gebruiker kan inloggen
    public function canLogin(Request $request){
        //checken of het emailveld is ingevuld
        $credentials = $request->validate([
            'email' => 'required|email'
        ]);

        //de user gaan halen uit de database
        $user = User::where('email', $request->input('email'))->first();

        
        if(!$user){
            //geen gebruiker gevonden:
            $request->session()->flash('error', 'Er is geen account gevonden met dit emailadres');
            return redirect('login');
        }else{
            //gebruiker gevonden:
            $generator = new LoginUrl($user);
            
            //genereeren van de magic ogin link voor in de mail
            $data['url'] = $generator->generate();

            //alle info over de gebruiker gaan halen
            teamleaderController::reAuthTL();
            $data['user'] = Teamleader::crm()->contact()->info($user->teamleader_id)->data;

            //verzenden van de loginmail
            Mail::to($user->email)->send(new UserLoginMail($data));

            //gebruiker feedback geven
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
