<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function projects(){
        $data['user'] = Auth::user();
        return view('projects/projects', $data);
    }
}
