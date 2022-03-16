<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Vimexx;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $vimexx = new Vimexx();
            $check = $vimexx->checkDomain($domain);
            $data["check"] = $check;
        
            if($check === "Beschikbaar"){
                $data['checkColor'] = "green";
            }else{
                $data['checkColor'] = "red";
            }
        }else{
            $data["domain"] = "";
            $request->session()->flash('error', $domain.' is geen domeinnaam');
        }
        return view('shop/shop', $data);

    }

    public function cart(Request $request){
        $domain = $request->input('domain');
        $data["domain"] = $domain;
        $data["mailbox"] = "info@".$domain;
        return view('shop/cart', $data);
    }

    public function buyDomain(Request $request){
        
        $domain = $request->input("domain");

       

        if(!empty($domain)){

            $order = new Order();
            $order->domain = $domain;
            $order->user_id = Auth::id();
            $order->payed = false;
            $order->save();

            //molliepayment starten


            //redirecten naar domeinnamen met een message
            
            $request->session()->flash('message', 'We hebben je aankoop goed ontvangen. We zijn nu bezig met je domeinnaam te registeren. Dit kan 24u duren.');
            MollieController::createPayment('4.99', $domain);
            return redirect('domeinen');


        }
        
    }
}
