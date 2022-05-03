<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PostmarkController extends Controller
{
    //domein creeren op postmark
    public static function createDomain($domain){
        $url = "https://api.postmarkapp.com";
        $res = Http::withHeaders([
            'X-Postmark-Account-Token' => env('POSTMARK_ACOUNT_CODE'),
            'Accept' => 'application/json',
            'Content-type' => 'application/json'
        ])->post($url.'/domains', ([
            'name' => $domain
        ]));
    
        $data = json_decode($res->body());
        return $data;
    }

    //dkim check doen op postmark
    public static function checkDKIM($id){
        $url = "https://api.postmarkapp.com";
        $res = Http::withHeaders([
            'X-Postmark-Account-Token' => env('POSTMARK_ACOUNT_CODE'),
            'Accept' => 'application/json'
        ])->put($url.'/domains/'.$id.'/verifyDkim');
    
        $data = json_decode($res->body());
        return $data;
    }

    //cname check doen op postmark
    public static function checkCNAME($id){
        $url = "https://api.postmarkapp.com";
        $res = Http::withHeaders([
            'X-Postmark-Account-Token' => env('POSTMARK_ACOUNT_CODE'),
            'Accept' => 'application/json'
        ])->put($url.'/domains/'.$id.'/verifyReturnPath');
    
        $data = json_decode($res->body());
        return $data;
    }

    //domein deleten
    public static function deleteDomain($id){
        $url = "https://api.postmarkapp.com";
        $res = Http::withHeaders([
            'X-Postmark-Account-Token' => env('POSTMARK_ACOUNT_CODE'),
            'Accept' => 'application/json'
        ])->delete($url.'/domains/'.$id);
    
        $data = json_decode($res->body());
        return $data;
    }

    //info over 1 domein verkrijgen
    public static function getOneDomain($id){
        $url = "https://api.postmarkapp.com";
        $res = Http::withHeaders([
            'X-Postmark-Account-Token' => env('POSTMARK_ACOUNT_CODE'),
            'Accept' => 'application/json'
        ])->get($url.'/domains/'.$id);
    
        $data = json_decode($res->body());
        return $data;
    }
    
}
