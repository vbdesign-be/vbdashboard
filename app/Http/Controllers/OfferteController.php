<?php

namespace App\Http\Controllers;

use App\Models\Offerte;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferteController extends Controller
{
    public function offerte(){
        $data["user"] = User::find(Auth::id());
        $data["offertes"] = Offerte::where('company_id', $data["user"]->company->id)->get();
        
        return view('offerte/offerte', $data);
    }

    public function post(Request $request){

        $credentials = $request->validate([
            'titel' => 'required|max:255',
            'kostprijs' => 'required',
            'deadline' => 'required',
            'samenvatting' => 'required',
        ]);

        $offerte = new Offerte();
        $offerte->title = $request->input('titel');
        $offerte->summary = $request->input('samenvatting');
        $offerte->reference = "123";
        $offerte->company_id = $request->input('company');
        $offerte->estimated_value = $request->input('kostprijs');
        $offerte->estimated_closing_date = $request->input('deadline');
        $offerte->save();


        return redirect('/offerte');

        
    }
}
