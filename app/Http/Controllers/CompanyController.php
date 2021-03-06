<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;
use Vbdesign\Teamleader\Facade\Teamleader;

class CompanyController extends Controller
{   
    //informatie van het bedrijf verkrijgen
    public function company($id){
        teamleaderController::reAuthTL();
        $data['user'] = Auth::user();
        $company = Teamleader::crm()->company()->info($id);
        $data["company"] = $company->data;
        
        //bedrijf kan meerdere emails hebben.
        //Lus alle emails voor een bedrijf uit
        $emails = $data['company']->emails;
        foreach($emails as $e){
            if ($e->type === "primary") {
                $data['company']->email = $e->email;
            }
        }

        //bedrijf kan meerdere telefoons hebben.
        //Lus alle telefoons voor een bedrijf uit
        $telephones = $data['company']->telephones;
        for($x = 0; $x < count($telephones); $x++){
            if($telephones[$x]->type === "mobile"){
                $data['company']->mobile = $telephones[$x]->number;
            }
            if($telephones[$x]->type === "phone"){
                $data['company']->phone = $telephones[$x]->number;
            }
        }

        //Bedrijf kan meerdere adressen hebben
        //lus alle adresses en kijk welken de primary adres is.
        $addresses = $data['company']->addresses;
        foreach($addresses as $address){
            if($address->type === "primary"){
                $data['company']->street = $address->address->line_1;
                $data['company']->city = $address->address->city;
                $data['company']->postal = $address->address->postal_code;
                if(!empty($address->address->area_level_two)){
                    $data['company']->province = $address->address->area_level_two->id;
                }
                $data['company']->country = $address->address->country;
                
            }
        }
        
        //welke users zitten bij het bedrijf
        $company_users = Teamleader::crm()->contact()->list(['filter' => ['company_id' => $data["company"]->id, 'tags' => [0 => "klant"] ]]);
        foreach($company_users as $u){
            $data['company']->users = $u;
        }

        //welke businesstypes zijn er allemaal
        $businessTypes = Teamleader::crm()->company()->getBusinessTypes($data['company']->country);
        $data["businessTypes"] = $businessTypes->data;

        //welke provincies zijn er allemaal
        $provinces = Teamleader::crm()->company()->getProvinces($data['company']->country);
        $data['provinces'] = $provinces->data;

        //kijken of de ingelogde gebruiker een werknemer is van het bedrijf
            //ja? dan mag die de blade bekijken
            //nee?abort403
        foreach($data["company"]->users as $u){
            $user_ids[] = $u->id;
        }
        $check = in_array(Auth::user()->teamleader_id, $user_ids, TRUE);
        if($check){
            return view('company', $data);
        }else{
            abort(403);
        }
    }

    //informatie van een bedrijf updaten in teamleader
    public function updateCompany(Request $request){
        teamleaderController::reAuthTL();

        //checken of alles meegestuurd word
        $credentials = $request->validate([
            'bedrijfsnaam' => 'required|max:255',
            'bedrijfsemail' => 'required|email',     
        ]);

        $company_id = $request->input('company_id');

        //als de input telefoon niet leeg is-> update doen met telefoon
        if (!empty($request->input('telefoon'))) {
            Teamleader::crm()->company()->update($company_id, [
            'name' => $request->input('bedrijfsnaam'),
            'business_type_id' => $request->input('bedrijfsvorm'),
            'vat_number' => $request->input('btw-nummer'),
            'website' => $request->input('website'),
            'emails' => ['object' => ['type' => "primary", 'email' => $request->input('bedrijfsemail')]],
            'telephones' => ['object' => ['type' => "phone", 'number' => $request->input('telefoon')]],
            'addresses' => ['object' => ['type' => "primary", 'address' => [
                'line_1' => $request->input('straat'),
                'postal_code' => $request->input('postcode'),
                'city' => $request->input('stad'),
                'country' => $request->input('land'),
                'area_level_two_id' =>  $request->input('provincie'),
                ]]],
            ]);
        }else{
            //als de input telefoon leeg is-> update doen zonder
            Teamleader::crm()->company()->update($company_id, [
                'name' => $request->input('bedrijfsnaam'),
                'business_type_id' => $request->input('bedrijfsvorm'),
                'vat_number' => $request->input('btw-nummer'),
                'website' => $request->input('website'),
                'emails' => ['object' => ['type' => "primary", 'email' => $request->input('bedrijfsemail')]],
                'telephones' => [],
                'addresses' => ['object' => ['type' => "primary", 'address' => [
                    'line_1' => $request->input('straat'),
                    'postal_code' => $request->input('postcode'),
                    'city' => $request->input('stad'),
                    'country' => $request->input('land'),
                    'area_level_two_id' =>  $request->input('provincie'),
                    ]]],
                ]);
        }

        //gebruikers een update geven en redirecten
        $request->session()->flash('message', 'De gegevens van '. $request->input('bedrijfsnaam'). ' zijn ge??pdate');
        return redirect('/company/'.$company_id.'');
    }
}
