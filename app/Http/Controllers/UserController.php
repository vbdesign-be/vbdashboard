<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Grosv\LaravelPasswordlessLogin\LoginUrl;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserLoginMail;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    

    public function profile(){
        $data["user"] = User::find(Auth::id());
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

        $request->image->move(public_path('img'), $imageName);

    }


    
}