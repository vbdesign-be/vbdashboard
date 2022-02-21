<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OfferteController extends Controller
{
    public function offerte(){
        return view('offerte/offerte');
    }
}
