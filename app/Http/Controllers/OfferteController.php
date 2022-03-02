<?php

namespace App\Http\Controllers;

use App\Models\Offerte;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MadeITBelgium\TeamLeader\Facade\TeamLeader;

class OfferteController extends Controller
{
    public function offerte(){
        teamleaderController::reAuthTL();

        $userId = Auth::user()->teamleader_id;
        $user = TeamLeader::crm()->contact()->info($userId)->data;
        $companies = $user->companies;
        foreach($companies as $c){
            $company_id = $c->company->id;
        }

        $offertes = TeamLeader::deals()->list($data = []);
        dd($offertes);

        return view('offerte/offerte');
    }

    public function post(Request $request){

        $credentials = $request->validate([
            'titel' => 'required|max:255',
            'kostprijs' => 'required',
            'deadline' => 'required',
            'samenvatting' => 'required',
        ]);

        $datum = $request->input('deadline');

        $jaar = substr($datum, 0,4);
        $maand = substr($datum, 5,2);
        $dag = substr($datum, 8,2);

        $newJaar = $dag . '-' . $maand . '-' . $jaar;
        

        $offerte = new Offerte();
        $offerte->title = $request->input('titel');
        $offerte->summary = $request->input('samenvatting');
        $offerte->reference = "123";
        $offerte->company_id = $request->input('company');
        $offerte->estimated_value = $request->input('kostprijs');
        $offerte->estimated_closing_date = $newJaar;
        $offerte->save();
        $request->session()->flash('message', 'Je offerte is goed ontvangen');
        return redirect('/offerte');

        
    }
}
