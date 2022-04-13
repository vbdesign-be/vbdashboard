<?php

namespace App\Http\Controllers;

use App\Mail\NewOfferte;
use App\Mail\NewOfferteMail;
use App\Models\Offerte;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vbdesign\Teamleader\Facade\Teamleader;


class OfferteController extends Controller
{
    public function offerte(){
        teamleaderController::reAuthTL();

        $userId = Auth::user()->teamleader_id;
        $user = Teamleader::crm()->contact()->info($userId)->data;
        $companies = $user->companies;
        foreach($companies as $c){
            $company_id = $c->company->id;
            $comps[] = Teamleader::crm()->company()->info($company_id);
        }

        $data['comps'] = $comps;
       
        foreach ($comps as $c) {
            //kunnen maar dan 20 zijn dus enkele instantie in de array moet een offerte zijn
            $offertes[] = Teamleader::deals()->list(['filter'=> ['customer' => ['type' => 'company', 'id' => $c->data->id] ], 'page' => ['number' => 1, 'size' => 100]])->data;
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

    public function getDeal($deal_id){
        teamleaderController::reAuthTL();
        
        //security bij
        $userId = Auth::user()->teamleader_id;
        $user = Teamleader::crm()->contact()->info($userId)->data;
        $companies = $user->companies;
        foreach($companies as $c){
            $company_id = $c->company->id;
            $comps[] = Teamleader::crm()->company()->info($company_id)->data;
        }
        
        
        foreach($comps as $c){
            $deal = Teamleader::deals()->list(['filter'=> ['ids' => [$deal_id]]])->data[0];
            if($deal->lead->customer->id !== $c->id){
                abort(403);
            }
        }
        
        if(empty($deal)){
            abort(403);
        }

        //lijst met alle quotations in
        for($x = 1; $x <= 10; $x++){
            $quotations [] = Teamleader::deals()->getQuotations(['page' => ['number' => $x, 'size' => 50]])->data;
        }

        foreach($quotations as $q){
            foreach($q as $t){
                $offertes [] = $t;
            }
        }

        foreach($offertes as $f){
            $test = Teamleader::deals()->getInfoQuotation($f->id);
            if($test->data->deal->id === $deal_id){
                $offerte = $test;
            }
        }

        $download = Teamleader::deals()->downloadQuotation(['id' => $offerte->data->id, 'format' => 'pdf']);

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

        $data['title'] = $request->input('titel');
        $data['company_id'] = $request->input('bedrijf');
        $data['estimated_value'] = $request->input('kostprijs');
        $data['summary'] = $request->input('samenvatting');
        $datum = $request->input('deadline');

        $jaar = substr($datum, 0,4);
        $maand = substr($datum, 5,2);
        $dag = substr($datum, 8,2);
        $data['estimated_closing_date'] = $dag . '-' . $maand . '-' . $jaar;

        
        //offerte in database
        $offerte = new Offerte();
        $offerte->title = $data['title'];
        $offerte->summary = $data['summary'];
        $offerte->reference = "123";
        $offerte->company_id = $data['company_id'];
        $offerte->estimated_value = $data['estimated_value'];
        $offerte->estimated_closing_date = $data['estimated_closing_date'];
        $offerte->save();
        $request->session()->flash('message', 'Je offerte is goed ontvangen');
        
        //gegevens van de persoon(naam voornaam)
        teamleaderController::reAuthTL();
        $data['user'] =  TeamLeader::crm()->contact()->info(Auth::user()->teamleader_id)->data;
        $companies = $data['user']->companies;
        foreach($companies as $c){
            if($c->company->id === $data['company_id']){
                $data['position'] = $c->position;
            }
        }
        //gegevens van het bedrijf mee doorsturen
        $data['company'] = TeamLeader::crm()->company()->info($data['company_id'])->data;
        //mail versturen naar bert met nieuwe offerte
        Mail::to('jonathan_verhaegen@hotmail.com')->send(new NewOfferteMail($data));
        //redirecten
        return redirect('/offerte');
    }
}
