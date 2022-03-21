<?php

namespace App\Http\Controllers;

use App\Models\EmailOrder;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MollieController extends Controller
{
    public static  function getPayments(){
        $token = "test_g6CCJx8E7JFpwCM2j77wNW8M8zQ8NC";
        $response = Http::withToken($token)->get('https://api.mollie.com/v2/payments');
        return json_decode($response)->_embedded;
    }

    public static function createPayment($price, $domeinnaam){
        $order = Order::where('domain', $domeinnaam)->first();
        $token = "test_g6CCJx8E7JFpwCM2j77wNW8M8zQ8NC";
        $data = [
            'amount' => [
                'currency' => 'EUR',
                'value' => $price
            ],
            'description' => 'aankoop domeinnaam: '.$domeinnaam,
            'redirectUrl' => 'https://vbdashboard.test/payed?order_id='.$order->id,
            'metadata' => [
                'type' => 'Order',
                'order_id' => $order->id,
          ]
        ];

        
        $res = Http::withToken("test_g6CCJx8E7JFpwCM2j77wNW8M8zQ8NC")->post('https://api.mollie.com/v2/payments', $data);
        $ans = json_decode($res->body());
        header("Location: {$ans->_links->checkout->href}");
        exit;
        
    }

    public static function createPaymentEmail($price, $email, $front, $password){
        $emailOrder = EmailOrder::where('email', $email)->first();
        $token = "test_g6CCJx8E7JFpwCM2j77wNW8M8zQ8NC";
        $data = [
            'amount' => [
                'currency' => 'EUR',
                'value' => $price
            ],
            'description' => 'aankoop emailbox: '.$email,
            'redirectUrl' => 'https://vbdashboard.test/payedEmail?emailorder_id='.$emailOrder->id.'&front='.$front.'&password='.$password,
            'metadata' => [
                'type' => 'EmailOrder',
                'emailOrder_id' => $emailOrder->id,
          ]
        ];

        $res = Http::withToken("test_g6CCJx8E7JFpwCM2j77wNW8M8zQ8NC")->post('https://api.mollie.com/v2/payments', $data);
        $ans = json_decode($res->body());
        header("Location: {$ans->_links->checkout->href}");
        exit;

    }

    
}
