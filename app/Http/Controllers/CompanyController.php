<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;
use MadeITBelgium\TeamLeader\Facade\TeamLeader;

class CompanyController extends Controller
{
    public function company($id){
        teamleaderController::reAuthTL();
        $data['user'] = Auth::user();
        $company = TeamLeader::crm()->company()->info($id);
        $data["company"] = $company->data;
        
        $emails = $data['company']->emails;
        foreach($emails as $e){
            if ($e->type === "primary") {
                $data['company']->email = $e->email;
            }
        }
        
        $telephones = $data['company']->telephones;
        for($x = 0; $x < count($telephones); $x++){
            if($telephones[$x]->type === "mobile"){
                $data['company']->mobile = $telephones[$x]->number;
            }
            if($telephones[$x]->type === "phone"){
                $data['company']->phone = $telephones[$x]->number;
            }
        }

        $addresses = $data['company']->addresses;
        foreach($addresses as $address){
            if($address->type === "primary"){
                $data['company']->street = $address->address->line_1;
                $data['company']->city = $address->address->city;
                $data['company']->postal = $address->address->postal_code;
            }
        }


        $company_users = TeamLeader::crm()->contact()->list(['filter' => ['company_id' => $data["company"]->id ]]);
        $data['company']->users = $company_users->data;

        $businessTypes = TeamLeader::crm()->company()->getBusinessTypes();
        $data["businessTypes"] = $businessTypes->data;
        return view('company', $data);
    }

    public function updateCompany(Request $request){
        teamleaderController::reAuthTL();

        $credentials = $request->validate([
            'bedrijfsnaam' => 'required|max:255',
            'bedrijfsemail' => 'required|email',
            'sector' => 'required',
            'btw-plichtig' => 'required',
            'bedrijfsvorm' => 'required'       
        ]);

        $company_id = $request->input('company_id');
        TeamLeader::crm()->company()->update($company_id, [
            'name' => $request->input('bedrijfsnaam'),
            'business_type_id' => $request->input('bedrijfsvorm'),
            'vat_number' => $request->input('btw-nummer'),
            'website' => $request->input('website'),
            'emails' => ['object' => ['type' => "primary", 'email' => $request->input('bedrijfsemail')]],
            'telephones' => ['object' => ['type' => "phone", 'number' => $request->input('telefoon')]], 
        ]);

        return redirect('/company/'.$company_id.'');


    }
}
