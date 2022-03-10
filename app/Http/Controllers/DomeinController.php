<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DomeinController extends Controller
{
    public function domeinen(){
        return view('domeinen/domeinen');
    }
}
