<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Grosv\LaravelPasswordlessLogin\LoginUrl;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserLoginMail;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function dashboard(){
        $data['user'] = Auth::user();
        return view('dashboard/dashboard', $data);
    }

    public function profile(){

        $sectoren = [
            'it',
            'entertainment',
            'sport'
        ];

        $data['user'] = Auth::user();
        $data['sectors'] = $sectoren;
        return view('profile', $data);
    }

    public function editUser(Request $request){
        //checking
        $credentials = $request->validate([
            'voornaam' => 'required|max:255',
            'familienaam' => 'required|max:255',
            'email' => 'required|email'
        ]);

        $user = User::find($request->id);
        $user->firstname = $request->input('voornaam');
        $user->lastname = $request->input('familienaam');
        $user->email = $request->input('email');
        $user->btwnumber = $request->input('btwnummer');
        $user->gsm = $request->input('gsm');
        $user->phone = $request->input('telefoon');
        $user->city = $request->input('stad');
        $user->sector = $request->input('sector');
        $user->save();

        // $request->session()->flash('message', 'je account is geüpdate');

        
        return redirect('/profile');


    }
    
}