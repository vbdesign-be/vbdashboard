<?php

namespace App\Http\Controllers;

use App\Models\EmailOrder;
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
        $order = Order::where('domain', $domain)->where('user_id', Auth::id())->first();
        if(empty($order)){
            abort(403);
        }
        //order ophalen van de emailboxen met dat domein
        $emails = EmailOrder::where('order_id', $order->id)->get();
        //enkel de betaalde emailboxen
        
        foreach($emails as $email){
            if($email->payed === 1){
                $emailsPayed [] = $email;
            }
        }
        if(!empty($emailsPayed)){
            $data['emails'] = $emailsPayed;
        }else{
            $data['emails'] = "";
        }
        $data['domain'] = $order->domain;
        $data['placeholder'] = "info@".$domain;
        return view('domeinen/domeindetail', $data);
    }

    public function deleteEmail(Request $request){
        //domeincode ophalen
        $domain = $request->input('domain');
        $order = Order::where('domain', $domain)->first();
        

        $email = $request->input('email');
        
        
    }
}
