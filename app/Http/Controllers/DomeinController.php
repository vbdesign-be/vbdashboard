<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DomeinController extends Controller
{
    public function domeinen(){
        $orders = Order::where('user_id', Auth::id())->get();


        
        foreach($orders as $order){
            if($order->payed){
                $data['orders'][] = $order;
            }
        }
        
        if(!empty($data['orders'])){
            return view('domeinen/domeinen', $data);
        }else{
            return view('domeinen/domeinen');
        }
        
    }

    public function detail($domain){
        //order ophalen met dat domein

        $order = Order::where('domain', $domain)->first();
        dd($order);

        //order ophalen van de emailboxen met dat domein

        //enkel de betaalde emailboxen

        //checken op user_id

        //data versturen
        
        $data['placeholder'] = "info@".$domain;
         return view('domeinen/domeindetail', $data);
    }

    public function deleteEmail(Request $request){
        $email = $request->input('email');
        dd($email);
    }
}
