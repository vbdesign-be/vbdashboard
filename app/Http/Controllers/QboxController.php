<?php

namespace App\Http\Controllers;

use App\Models\Emailtest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QboxController extends Controller
{
    public static function getAllDomains(){
        $url = 'https://api.qboxmail.com/api/domains';
        $token = "cdwqFqPa6PQx0Gxab8ytj4JV3dU3abWk4nrZ5FPG-LSD-QTMA0peaEmd6Ah6G9rP";
        
        $res = Http::withHeaders([
            'X-Api-Token' => $token,
        ])->get($url);
        $data = json_decode($res);
        return $data->resources;
    }

    public static function makeDomain($domain){
        $url = 'https://api.qboxmail.com/api/domains';
        $token = "cdwqFqPa6PQx0Gxab8ytj4JV3dU3abWk4nrZ5FPG-LSD-QTMA0peaEmd6Ah6G9rP";
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

    public static function makeEmail($email, $code, $password, $name){
        $url = 'https://api.qboxmail.com/api/domains/'.$code.'/email_accounts';
        $token = "cdwqFqPa6PQx0Gxab8ytj4JV3dU3abWk4nrZ5FPG-LSD-QTMA0peaEmd6Ah6G9rP";
        $data = [
            'name' => $email,
            'password' => $password,
            'password_confirmation' => $password,
            'firstname' => $name
        ];
        $res = Http::withHeaders([
            'X-Api-Token' => $token,
        ])->post($url, $data);

        $data = json_decode($res);
        return $data;
        
    }
 
    public static function checkDns($code){
       $url = 'https://api.qboxmail.com/api/domains/'.$code.'/dns_ownership_check';
       $token = "cdwqFqPa6PQx0Gxab8ytj4JV3dU3abWk4nrZ5FPG-LSD-QTMA0peaEmd6Ah6G9rP";
        $res = Http::withHeaders([
            'X-Api-Token' => $token,
        ])->put($url);

        $data = json_decode($res);
        return $data;
    }

    public static function getDKIM($code){
        $url = 'https://api.qboxmail.com/api/domains/'.$code.'/dkim';
        $token = "cdwqFqPa6PQx0Gxab8ytj4JV3dU3abWk4nrZ5FPG-LSD-QTMA0peaEmd6Ah6G9rP";
        $res = Http::withHeaders([
            'X-Api-Token' => $token,
        ])->post($url);

        $data = json_decode($res);
        $test = new Emailtest();
        $test->test = $data->resources[0]->txt_record;
        $test->save();
        return $data->resources[0]->txt_record;
    }

    public static function verifyMX($code){
        $url = 'https://api.qboxmail.com/api/domains/'.$code.'/dns';
        $token = "cdwqFqPa6PQx0Gxab8ytj4JV3dU3abWk4nrZ5FPG-LSD-QTMA0peaEmd6Ah6G9rP";
        $res = Http::withHeaders([
            'X-Api-Token' => $token,
        ])->put($url);

        $data = json_decode($res);
        return $data;
    }

    public static function deleteEmail($code, $emailcode){
        $url = 'https://api.qboxmail.com/api/domains/'.$code.'/email_accounts/'.$emailcode;
        $token = "cdwqFqPa6PQx0Gxab8ytj4JV3dU3abWk4nrZ5FPG-LSD-QTMA0peaEmd6Ah6G9rP";
        $res = Http::withHeaders([
            'X-Api-Token' => $token,
        ])->delete($url);

        $data = json_decode($res);
        return $data;
    }

    public static function deleteDomain($code){
        $url = 'https://api.qboxmail.com/api/domains/'.$code;
        $token = "cdwqFqPa6PQx0Gxab8ytj4JV3dU3abWk4nrZ5FPG-LSD-QTMA0peaEmd6Ah6G9rP";
        $res = Http::withHeaders([
            'X-Api-Token' => $token,
        ])->delete($url);

        $data = json_decode($res);
        return $data;
    }

}
