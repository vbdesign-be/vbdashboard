<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AfspraakController extends Controller
{
    public function afspraak(){
        //view returnen met de widget van calendly
        return view('afspraak/afspraak');
    }
}
