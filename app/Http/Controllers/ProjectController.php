<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function projects(Request $request){
        $user = Auth::user();
        if(!$user->didLogin){
            $request->session()->flash('login', 'Welkom op je dashboard, hieronder kan je je gegvens controleren en veranderen.');
            return redirect('/profiel');
        }


        $data['user'] = $user;
        return view('projects/projects', $data);
    }
}
