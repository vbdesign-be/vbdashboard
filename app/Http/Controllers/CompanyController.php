<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class CompanyController extends Controller
{
    public function update(Request $request){
        
        $credentials = $request->validate([
            'bedrijfsnaam' => 'required|max:255',
            'bedrijfsemail' => 'required|email',
            'btw-nummer' => 'required|max:255'
        ]);

        $user = User::find(Auth::id())->first();

        $company = Company::find($user->company->id)->first();

        $company->name = $request->input('bedrijfsnaam');
        $company->email = $request->input('bedrijfsemail');
        $company->VAT = $request->input('btw-nummer');
        $company->phone = $request->input('telefoon');
        $company->adress = $request->input('straat');
        $company->postalcode = $request->input('postcode');
        $company->city = $request->input('plaats');
        $company->VAT = $request->input('btw-nummer');
        $company->sector = $request->input('sector');
        $company->save();

        $request->session()->flash('message', ''. $request->input('bedrijfsnaam'). ' is geüpdate ' );

        return redirect('/profiel');
        


        



    }
}
