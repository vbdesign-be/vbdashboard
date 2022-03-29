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
            $comps[] = TeamLeader::crm()->company()->info($company_id);
        }

        $data['comps'] = $comps;
       
        foreach ($comps as $c) {
            //kunnen maar dan 20 zijn dus enkele instantie in de array moet een offerte zijn
            $offertes[] = TeamLeader::deals()->list(['filter'=> ['customer' => ['type' => 'company', 'id' => $c->data->id] ], 'page' => ['number' => 1, 'size' => 100]])->data;
        }
        $data['offertes'] = $offertes;
    
        // //de quotation deal id de deal gaan opvragen
        // foreach($comps as $c){
        // foreach($test as $t){
        //     $deal = TeamLeader::deals()->info($t->deal->id)->data;
        //     if($deal->lead->customer->id === $c->data->id){
        //         $dealCompany[] = $t;
        //     }
        // }
        // }

        //als die deal bij het bedrijf hoort mag het in een array ofzo

        


        return view('offerte/offerte', $data);
    }

    public function getDeal($id){
        teamleaderController::reAuthTL();

        $dealId = $id;

        //lijst met alle quotations in
        for($x = 1; $x <= 10; $x++){
            $quotations [] = TeamLeader::deals()->getQuotations(['page' => ['number' => $x, 'size' => 50]])->data;
        }

        

        foreach($quotations as $q){
            foreach($q as $t){
                $offertes [] = $t;
            }
        }

        foreach($offertes as $f){
            $test = TeamLeader::deals()->getInfoQuotation($f->id);
            if($test->data->deal->id === $dealId){
                $offerte = $test;
            }
        }

        $download = TeamLeader::deals()->downloadQuotation(['id' => $offerte->data->id, 'format' => 'pdf']);

        $redirect = $download->data->location;

        return redirect($redirect);

    }

    public function post(Request $request){

        $credentials = $request->validate([
            'titel' => 'required|max:255',
            'bedrijf' => 'required',
            'kostprijs' => 'required',
            'deadline' => 'required',
            'samenvatting' => 'required',
        ]);

        $datum = $request->input('deadline');

        $jaar = substr($datum, 0,4);
        $maand = substr($datum, 5,2);
        $dag = substr($datum, 8,2);

        $newJaar = $dag . '-' . $maand . '-' . $jaar;
        
        dd($request->input('bedrijf'));

        $offerte = new Offerte();
        $offerte->title = $request->input('titel');
        $offerte->summary = $request->input('samenvatting');
        $offerte->reference = "123";
        $offerte->company_id = $request->input('company');
        $offerte->estimated_value = $request->input('kostprijs');
        $offerte->estimated_closing_date = $newJaar;
        $offerte->save();
        $request->session()->flash('message', 'Je offerte is goed ontvangen');

        //mail versturen naar bert met nieuwe offerte
        return redirect('/offerte');

        
    }
}
