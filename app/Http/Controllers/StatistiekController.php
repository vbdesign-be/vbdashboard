<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatistiekController extends Controller
{
    public function statistieken(){
        return view('statistieken/statistieken');
    }
}
