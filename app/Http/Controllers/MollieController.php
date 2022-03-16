<?php

namespace App\Http\Controllers;

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
        $token = "test_g6CCJx8E7JFpwCM2j77wNW8M8zQ8NC";
        $data = [
            'amount' => [
                'currency' => 'EUR',
                'value' => $price
            ],
            'description' => 'aankoop domeinnaam: '.$domeinnaam,
            'redirectUrl' => 'https://vbdashboard.test/domeinen',
            'metadata' => [
                'order_id' => '12345',
          ]
        ];

        
        $res = Http::withToken("test_g6CCJx8E7JFpwCM2j77wNW8M8zQ8NC")->post('https://api.mollie.com/v2/payments', $data);
        $ans = json_decode($res->body());
        header("Location: {$ans->_links->checkout->href}");
        exit;
        
    }
}
