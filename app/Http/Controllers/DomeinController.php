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

    public function detail($domein){
        dd($domein);
    }
}
