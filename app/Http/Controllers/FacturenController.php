<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacturenController extends Controller
{
    public function getFacturen(){
        //wie ingelogd?

        //teamleader id en facturen ophalen

        //facturen meesturen en redirecten
        return view('facturen/facturen');
    }
}
