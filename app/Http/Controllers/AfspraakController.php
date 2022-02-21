<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AfspraakController extends Controller
{
    public function afspraak(){
        return view('afspraak/afspraak');
    }
}
