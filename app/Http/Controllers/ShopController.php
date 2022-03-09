<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        return view('shop/shop', $data);

    }
}
