<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QboxController extends Controller
{
    public function getAllDomains(){
        $url = 'https://api.qboxmail.com/api/domains';
        $token = 'cdwqFqPa6PQx0Gxab8ytj4JV3dU3abWk4nrZ5FPG-LSD-QTMA0peaEmd6Ah6G9rP';
        $res = Http::withHeaders([
            'X-Api-Token' => $token,
        ])->get($url);
        $data = json_decode($res);
        dd($data);
    }
}
