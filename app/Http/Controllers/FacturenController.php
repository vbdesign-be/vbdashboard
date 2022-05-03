<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vbdesign\Teamleader\Facade\Teamleader;


class FacturenController extends Controller
{
    //lijst met alle facturen
    public function getFacturen(){
        teamleaderController::reAuthTL();
        //wie ingelogd?
        $teamleader_id = Auth::user()->teamleader_id;
        $user = Teamleader::crm()->contact()->info($teamleader_id)->data;
        $companies = $user->companies;
        foreach($companies as $c){
            $company_id = $c->company->id;
            $comps[] = Teamleader::crm()->company()->info($company_id);
        }
        $data['comps'] = $comps;
        
        //Voor elk bedrijf dat de klant heeft de facturen gaan ophalen
        foreach ($comps as $c) {
            //kunnen maar dan 20 zijn dus enkele instantie in de array moet een offerte zijn
            $facturen[] = Teamleader::deals()->getInvoices(['filter'=> ['customer' => ['type' => 'company', 'id' => $c->data->id] ], 'page' => ['number' => 1, 'size' => 100]])->data;
        }
        
        //facturen orderene op invoice_number-> laatste eerst
        $data['facturen'] = collect($facturen[0])->sortByDesc('invoice_number')->all();

        //facturen meesturen en redirecten
        return view('facturen/facturen', $data);
    }

    //downloaden van een factuur
    public function downloadFactuur($factuur_id){
        teamleaderController::reAuthTL();
        $teamleader_id = Auth::user()->teamleader_id;
        $user = Teamleader::crm()->contact()->info($teamleader_id)->data;
        $companies = $user->companies;
        foreach($companies as $c){
            $company_id = $c->company->id;
            $comps[] = Teamleader::crm()->company()->info($company_id);
        }
        
        foreach ($comps as $c) {
            //kunnen maar dan 20 zijn dus enkele instantie in de array moet een offerte zijn
            $facturen[] = Teamleader::deals()->getInvoices(['filter'=> ['customer' => ['type' => 'company', 'id' => $c->data->id] ], 'page' => ['number' => 1, 'size' => 100]])->data;
        }


        //security zodat enkel de gebruiker de factuur kan downloaden.
        for($x = 0; $x < count($facturen); $x++){
            foreach($facturen[$x] as $fac){
                if($fac->id === $factuur_id){
                    $download = Teamleader::deals()->downloadInvoice(['id' => $factuur_id, 'format' => 'pdf']);
                }
            }
        }
        
        //als download niet leeg is naar de download link anders abort.
        if(!empty($download)){
            return redirect($download->data->location);
        }else{
            abort(403);
        }
    }

    //functie waar de gebruiker een factuur betaald
    public function betaalFactuur($factuur_id){
        teamleaderController::reAuthTL();
        //factuur info
        $factuur = Teamleader::deals()->getInvoice(['id' => $factuur_id]);

        //security
        $teamleader_id = Auth::user()->teamleader_id;
        $user = Teamleader::crm()->contact()->info($teamleader_id)->data;
        $companies = $user->companies;
        foreach($companies as $c){
            $company_id = $c->company->id;
            $comps[] = Teamleader::crm()->company()->info($company_id);
        }
        foreach ($comps as $c) {
            $facturen[] = Teamleader::deals()->getInvoices(['filter'=> ['customer' => ['type' => 'company', 'id' => $c->data->id] ], 'page' => ['number' => 1, 'size' => 100]])->data;
        }


        //security zodat enkel de gebruiker de factuur kan downloaden.
        for($x = 0; $x < count($facturen); $x++){
            foreach($facturen[$x] as $fac){
                if($fac->id === $factuur_id){
                    $check = true;
                }
            }
        }
        
        //als check niet bestaat is de factuur niet van de persoon dus abort
        if(!isset($check)){
            abort(403);
        }

        //prijs uit de factuur halen
        $price = strval($factuur->total->payable->amount);

        // als er maar 1 cijfer achter punt->nul bijzetten(anders werkt mollie niet)
        $priceExplode = explode(".", $price);
        if(!isset($priceExplode[1])){
            $price = $price.".00";
        }elseif(strlen($priceExplode[1]) === 1){
            $price = $price."0";
        }

        //invoice number uit de factuur halen
        $number = $factuur->invoice_number;
        $explodeNumber = explode(" ", $number);
        $realNumber = $explodeNumber[0].$explodeNumber[1].$explodeNumber[2];
        //mollie payment creeren met id en prijs
        MollieController::createPaymentFactuur($factuur_id, $price, $realNumber);
    }

    //mollie payment is volbracht
    public function payedFactuur(Request $request){
        $credentials = $request->validate([
            'factuur_id' => 'required',
            'price' => 'required',
            'number' => 'required'
        ]);

        $factuur_id = $request->input('factuur_id');
        $price = floatval($request->input('price'));

        $number = $request->input('number');
        $explodeNumber = explode("/", $number);
        $realNumber = $explodeNumber[0].' / '.$explodeNumber[1];

        //datum weten van de payment;
        $date = new DateTime();
        $realDate = $date->format('Y-m-d\TH:i:sP');
    
        //teamleader laten weten dat de betaling gelukt is
        teamleaderController::reAuthTL();
        $res = Teamleader::deals()->invoicePayed(['id' => $factuur_id, 'payment' => ['amount' => $price, 'currency' => 'EUR'], 'paid_at' => $realDate]);

        //gebruiker laten weten dat de betaling gelukt is en redirecten
        $request->session()->flash('message', 'Factuur: '.$realNumber.' is betaald.');
        return redirect('facturen');
    }

    //pagina met lijst met alle creditnotas
    public function getCreditnotas(){
        teamleaderController::reAuthTL();
        //wie ingelogd?
        $teamleader_id = Auth::user()->teamleader_id;
        $user = Teamleader::crm()->contact()->info($teamleader_id)->data;
        $companies = $user->companies;
        foreach($companies as $c){
            $company_id = $c->company->id;
            $comps[] = Teamleader::crm()->company()->info($company_id);
        }
        $data['comps'] = $comps;
        
        foreach ($comps as $c) {
            //kunnen maar dan 20 zijn dus enkele instantie in de array moet een offerte zijn
            $facturen[] = Teamleader::deals()->getInvoices(['filter'=> ['customer' => ['type' => 'company', 'id' => $c->data->id] ], 'page' => ['number' => 1, 'size' => 100]])->data;
        }

        //voor elke factuur de creditnota en titel van de factuur gaan halen.
        for($x = 0; $x < count($facturen[0]); $x++){
            $notes[$x]['note'] = Teamleader::deals()->getCreditnotes(['filter' => [ 'invoice_id' => $facturen[0][$x]->id]]);
            $notes[$x]['title'] = $facturen[0][$x]->invoicee->name;
        }

        //gebruiker redirecten
        $data['creditnotas'] = $notes;
        return view('facturen/creditnotas', $data);
    }

    //het downloaden van een creditnota
    public function downloadCreditnota($credit_id){
        teamleaderController::reAuthTL();
        $teamleader_id = Auth::user()->teamleader_id;
        $user = Teamleader::crm()->contact()->info($teamleader_id)->data;
        $companies = $user->companies;
        foreach($companies as $c){
            $company_id = $c->company->id;
            $comps[] = Teamleader::crm()->company()->info($company_id);
        }

        //security
        $credit = Teamleader::deals()->getOneCreditnote(['id' => $credit_id]);
        foreach($comps as $c){
            if($c->data->id === $credit->invoicee->customer->id){
                $check = true;
            }
        }
        
        //als check bestaat is de creditnota van de ingelogde persoon
        if(isset($check)){
            $download = Teamleader::deals()->downloadCreditnota(['id' => $credit_id, 'format' => 'pdf']);
            return redirect($download->data->location);
        }else{
            abort(403);
        }
    }
    
}
