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
        // dd($company);
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

        return view('company', $data);
    }
}
