<?php

namespace App\Http\Controllers;

use App\Models\EmailOrder;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MollieController extends Controller
{
    //wanneer een gebruiker een domeinnaam wilt kopen
    public static function createPayment($price, $domeinnaam){
        $order = Order::where('domain', $domeinnaam)->first();
        $token = env('MOLLIE_TOKEN');
        $url = env('MOLLIE_URL');
        $data = [
            'amount' => [
                'currency' => 'EUR',
                'value' => $price
            ],
            'description' => 'aankoop domeinnaam: '.$domeinnaam,
            'redirectUrl' => $url.'/payed?order_id='.$order->id,
            'metadata' => [
                'type' => 'Order',
                'order_id' => $order->id,
          ]
        ];

        $res = Http::withToken($token)->post('https://api.mollie.com/v2/payments', $data);
        $ans = json_decode($res->body());
        //redirecten naar de redirect link van mollie. Hier word de betaling uitgevoerd
        header("Location: {$ans->_links->checkout->href}");
        exit;
        
    }

    //wanneer een gebruiker een email wilt kopen
    public static function createPaymentEmail($price, $email, $front, $password){
        $emailOrder = EmailOrder::where('email', $email)->first();
        $token = env('MOLLIE_TOKEN');
        $url = env('MOLLIE_URL');
        $data = [
            'amount' => [
                'currency' => 'EUR',
                'value' => $price
            ],
            'description' => 'aankoop emailbox: '.$email,
            'redirectUrl' => $url.'/payedEmail?emailorder_id='.$emailOrder->id.'&front='.$front.'&password='.$password,
            'metadata' => [
                'type' => 'EmailOrder',
                'emailOrder_id' => $emailOrder->id,
          ]
        ];

        $res = Http::withToken($token)->post('https://api.mollie.com/v2/payments', $data);
        $ans = json_decode($res->body());
        header("Location: {$ans->_links->checkout->href}");
        exit;

    }

    //wanneer een gebruiker een site wilt transferen
    public static function createPaymentTransfer($price, $domain, $code){
        $order = Order::where('domain', $domain)->first();
        $token = env('MOLLIE_TOKEN');
        $url = env('MOLLIE_URL');
        $data = [
            'amount' => [
                'currency' => 'EUR',
                'value' => $price
            ],
            'description' => 'verhuis domeinnaam: '.$domain,
            'redirectUrl' => $url.'/payedTransfer?order_id='.$order->id.'&code='.$code,
            'metadata' => [
                'type' => 'Order',
                'order_id' => $order->id,
          ]
        ];
        $res = Http::withToken($token)->post('https://api.mollie.com/v2/payments', $data);
        $ans = json_decode($res->body());
        header("Location: {$ans->_links->checkout->href}");
        exit;
    }

    //wanneer een gebruiker een factuur wilt betalen
    public static function createPaymentFactuur($factuur_id, $price, $number){
        $token = env('MOLLIE_TOKEN');
        $url = env('MOLLIE_URL');
        $data = [
            'amount' => [
                'currency' => 'EUR',
                'value' => $price
            ],
            'description' => 'Betaling factuur: '.$number,
            'redirectUrl' => $url.'/factuur/payedFactuur?factuur_id='.$factuur_id.'&price='.$price.'&number='.$number,
            'metadata' => [
                'type' => 'Factuur',
                'factuur_id' => $factuur_id,
                'factuur_nummer' => $number,
          ]
        ];

        $res = Http::withToken($token)->post('https://api.mollie.com/v2/payments', $data);
        $ans = json_decode($res->body());
        header("Location: {$ans->_links->checkout->href}");
        exit;
    }

    
}
