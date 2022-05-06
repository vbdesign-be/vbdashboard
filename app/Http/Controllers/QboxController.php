<?php

namespace App\Http\Controllers;

use App\Models\Emailtest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QboxController extends Controller
{
    //get alle domeinen die op qbox staan.
    public static function getAllDomains(){
        $url = 'https://api.qboxmail.com/api/domains';
        $token = env('QBOX_TOKEN');
        
        $res = Http::withHeaders([
            'X-Api-Token' => $token,
        ])->get($url.'?per=200');

        $data = json_decode($res);
        return $data->resources;
    }

    //domein op qbox maken
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

    //emailadress op een bepaald domein maken
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
    
    //verifieren van het a record
    public static function checkDns($code){
       $url = 'https://api.qboxmail.com/api/domains/'.$code.'/dns_ownership_check';
       $token = env('QBOX_TOKEN');
        $res = Http::withHeaders([
            'X-Api-Token' => $token,
        ])->put($url);

        $data = json_decode($res);
        return $data;
    }

    //dkim code van een bepaald domein opkahen
    public static function getDKIM($code){
        $url = 'https://api.qboxmail.com/api/domains/'.$code.'/dkim';
        $token = env('QBOX_TOKEN');
        $res = Http::withHeaders([
            'X-Api-Token' => $token,
        ])->post($url);

        $data = json_decode($res);
        return $data->resources[0]->txt_record;
    }

    //mx code verifieren
    public static function verifyMX($code){
        $url = 'https://api.qboxmail.com/api/domains/'.$code.'/dns';
        $token = env('QBOX_TOKEN');
        $res = Http::withHeaders([
            'X-Api-Token' => $token,
        ])->put($url);

        $data = json_decode($res);
        return $data;
    }

    //emailadress van een bepaald domein verwijderen
    public static function deleteEmail($code, $emailcode){
        $url = 'https://api.qboxmail.com/api/domains/'.$code.'/email_accounts/'.$emailcode;
        $token = env('QBOX_TOKEN');
        $res = Http::withHeaders([
            'X-Api-Token' => $token,
        ])->delete($url);

        $data = json_decode($res);
        return $data;
    }

    //alle emailadressen van een bepaald domein opvragen
    public static function getEmailsOfDomain($code){
        $url = 'https://api.qboxmail.com/api/domains/'.$code.'/email_accounts';
        $token = env('QBOX_TOKEN');
        $res = Http::withHeaders([
            'X-Api-Token' => $token,
        ])->get($url);

        $data = json_decode($res);
        return $data;
    }

    //info verkijgen over een bepaald domein
    public static function getDomainInfo($code){
        $url = 'https://api.qboxmail.com/api/domains/'.$code;
        $token = env('QBOX_TOKEN');
        $res = Http::withHeaders([
            'X-Api-Token' => $token,
        ])->get($url);

        $data = json_decode($res);
        if(!empty($data->resources[0])){
            return $data->resources[0];
        }else{
            return "";
        }
    }

    //domein verwijderen
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
