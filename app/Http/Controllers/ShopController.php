<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ShopController extends Controller
{
    public function shop(){

        return view('shop/shop');
    }

    public function searchDomain(Request $request){

        $credentials = $request->validate([
            'domeinnaam' => 'required|max:255',
        ]);

        $domain = $request->input('domeinnaam');

        if(str_ends_with($domain, ".be")){
            $data["domain"] = $domain;
        }else{
            $data["domain"] = "";
            $request->session()->flash('error', $domain.' is geen domeinnaam');
        }

        $token = VimexxController::connect();

        //domein beschikbaar check

        $domainSplit = explode('.', $domain, 2);

        $data = [
            'sld' => $domainSplit[0],
            'tld' => $domainSplit[1]
        ];

        $url = 'https://api.vimexx.nl/wefact/domain/available';
        
        $response = Http::withToken($token)->post($url, $data);
        dd($response->body());


        return view('shop/shop', $data);

    }
}
