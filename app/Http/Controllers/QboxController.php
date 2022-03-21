<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QboxController extends Controller
{
    public static function getAllDomains(){
        $url = 'https://api.qboxmail.com/api/domains';
        $token = 'cdwqFqPa6PQx0Gxab8ytj4JV3dU3abWk4nrZ5FPG-LSD-QTMA0peaEmd6Ah6G9rP';
        $res = Http::withHeaders([
            'X-Api-Token' => $token,
        ])->get($url);
        $data = json_decode($res);
        return $data->resources;
    }

    public static function makeDomain($domain){
        $url = 'https://api.qboxmail.com/api/domains';
        $token = 'cdwqFqPa6PQx0Gxab8ytj4JV3dU3abWk4nrZ5FPG-LSD-QTMA0peaEmd6Ah6G9rP';
        $data = [
            'name' => $domain,
            'postmaster_password' => "VBdashboardTest123",
            'postmaster_password_confirmation' => "VBdashboardTest123",
        ];
        $res = Http::withHeaders([
            'X-Api-Token' => $token,
        ])->post($url, $data);

        $data = json_decode($res);
        return $data->resource_code;
    }

    public static function makeEmail($email, $code){
        $url = 'https://api.qboxmail.com/api/domains/'.$code.'/email_accounts';
        $token = 'cdwqFqPa6PQx0Gxab8ytj4JV3dU3abWk4nrZ5FPG-LSD-QTMA0peaEmd6Ah6G9rP';
        $data = [
            'name' => $email,
            'password' => "Test123",
            'password_confirmation' => "Test123",
        ];
        $res = Http::withHeaders([
            'X-Api-Token' => $token,
        ])->post($url, $data);

        $data = json_decode($res);
        dd($data);
    }

}
