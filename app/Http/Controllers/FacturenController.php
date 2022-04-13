<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vbdesign\Teamleader\Facade\Teamleader;

class FacturenController extends Controller
{
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
        
        foreach ($comps as $c) {
            //kunnen maar dan 20 zijn dus enkele instantie in de array moet een offerte zijn
            $facturen[] = Teamleader::deals()->getInvoices(['filter'=> ['customer' => ['type' => 'company', 'id' => $c->data->id] ], 'page' => ['number' => 1, 'size' => 100]])->data;
        }
       $data['facturen'] = $facturen;
       
        //facturen meesturen en redirecten
        return view('facturen/facturen', $data);
    }

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

        //security
        for($x = 0; $x < count($facturen); $x++){
            foreach($facturen[$x] as $fac){
                if($fac->id === $factuur_id){
                    $download = Teamleader::deals()->downloadInvoice(['id' => $factuur_id, 'format' => 'pdf']);
                }
            }
        }

        if(!empty($download)){
            return redirect($download->data->location);
        }else{
            abort(403);
        }

    }
}
