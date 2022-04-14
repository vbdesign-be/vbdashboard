<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QboxController extends Controller
{
    public static function getAllDomains(){
        $url = 'https://api.qboxmail.com/api/domains';
        $token = env('QBOX_TOKEN');
        
        $res = Http::withHeaders([
            'X-Api-Token' => $token,
        ])->get($url);
        $data = json_decode($res);
        return $data->resources;
    }

    public static function makeDomain($domain){
        $url = 'https://api.qboxmail.com/api/domains';
        $token = env('QBOX_TOKEN');
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
        $token = env('QBOX_TOKEN');
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
 
    public static function checkDns(){
       $url = 'https://api.qboxmail.com/api/domains/'."test".'/dns_ownership_check';
       $token = env('QBOX_TOKEN');
       dd($token. "   ". $url);
        $res = Http::withHeaders([
            'X-Api-Token' => $token,
        ])->put($url);

        $data = json_decode($res);
        return $data;
    }

    public static function getDKIM($code){
        $url = 'https://api.qboxmail.com/api/domains/'.$code.'/dkim';
        $token = env('QBOX_TOKEN');
        $res = Http::withHeaders([
            'X-Api-Token' => $token,
        ])->post($url);

        $data = json_decode($res);
        return $data->resources[0]->txt_record;
    }

    public static function verifyMX($code){
        $url = 'https://api.qboxmail.com/api/domains/'.$code.'/dns';
        $token = env('QBOX_TOKEN');
        $res = Http::withHeaders([
            'X-Api-Token' => $token,
        ])->put($url);

        $data = json_decode($res);
        return $data;
    }

    public static function deleteEmail($code, $emailcode){
        $url = 'https://api.qboxmail.com/api/domains/'.$code.'/email_accounts/'.$emailcode;
        $token = env('QBOX_TOKEN');
        $res = Http::withHeaders([
            'X-Api-Token' => $token,
        ])->delete($url);

        $data = json_decode($res);
        return $data;
    }

    public static function deleteDomain($code){
        $url = 'https://api.qboxmail.com/api/domains/'.$code;
        $token = env('QBOX_TOKEN');
        $res = Http::withHeaders([
            'X-Api-Token' => $token,
        ])->delete($url);

        $data = json_decode($res);
        return $data;
    }

}
