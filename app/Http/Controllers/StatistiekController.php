<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatistiekController extends Controller
{
    //deze controller wordt momenteel niet gebruikt. Niet verwijderd omdat deze in de toekomst wel gebruikt kan worden
    public function statistieken(){
        return view('statistieken/statistieken');
    }
}
