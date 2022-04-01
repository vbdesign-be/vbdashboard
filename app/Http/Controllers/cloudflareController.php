<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CloudflareController extends Controller
{
    public function test(){
        $url = "https://api.cloudflare.com/client/v4/";
        
        $res = Http::withHeaders([
            'X-Auth-Key' => '300860cc6227c1aa84c0943e4ab1faf4ae80f',
            'X-Auth-Email' => 'bert@vbdesign.be',
            'X-Auth-User-Service-Key' => 'v1.0-4c1d29c10a1522177f175f20-1ff2845b62538aea7e1e829bf570d8c453ed099fd51d937acf7b761b02b5534dd198361822532e9356eba42ef01f8a621db3423545a53c73d18bdbaf1b8f43d2b7269e7a5d9f0b'
        ])->get($url.'/accounts/46ec306d71921c8086e04f573412597f');
        $data = json_decode($res->body());
        dd($data->result);
    }

    public static function getOneDomain($domain){
        $url = "https://api.cloudflare.com/client/v4/";
        
        $res = Http::withHeaders([
            'X-Auth-Key' => '300860cc6227c1aa84c0943e4ab1faf4ae80f',
            'X-Auth-Email' => 'bert@vbdesign.be',
            'X-Auth-User-Service-Key' => 'v1.0-4c1d29c10a1522177f175f20-1ff2845b62538aea7e1e829bf570d8c453ed099fd51d937acf7b761b02b5534dd198361822532e9356eba42ef01f8a621db3423545a53c73d18bdbaf1b8f43d2b7269e7a5d9f0b'
        ])->get($url.'/zones?name='.$domain.'&account.id=46ec306d71921c8086e04f573412597f');
        $data = json_decode($res->body());
        return $data->result;
    }

    public static function createZone($domain){
        $url = "https://api.cloudflare.com/client/v4/";
        
        $res = Http::withHeaders([
            'X-Auth-Key' => '300860cc6227c1aa84c0943e4ab1faf4ae80f',
            'X-Auth-Email' => 'bert@vbdesign.be',
            'X-Auth-User-Service-Key' => 'v1.0-4c1d29c10a1522177f175f20-1ff2845b62538aea7e1e829bf570d8c453ed099fd51d937acf7b761b02b5534dd198361822532e9356eba42ef01f8a621db3423545a53c73d18bdbaf1b8f43d2b7269e7a5d9f0b'
        ])->post($url.'/zones', ([
            'name' => $domain,
            'account' => [
                'id' => '46ec306d71921c8086e04f573412597f'
            ] 
        ]));
        
        $data = json_decode($res->body());
        return $data;
        
    }

    public static function createDnsRecord($zone, $name, $ip) {
        $url = "https://api.cloudflare.com/client/v4/";
        
        $res = Http::withHeaders([
            'X-Auth-Key' => '300860cc6227c1aa84c0943e4ab1faf4ae80f',
            'X-Auth-Email' => 'bert@vbdesign.be',
            'X-Auth-User-Service-Key' => 'v1.0-4c1d29c10a1522177f175f20-1ff2845b62538aea7e1e829bf570d8c453ed099fd51d937acf7b761b02b5534dd198361822532e9356eba42ef01f8a621db3423545a53c73d18bdbaf1b8f43d2b7269e7a5d9f0b'
        ])->post($url.'zones/'.$zone.'/dns_records', ([
            'type' => 'A',
            'name' => $name,
            'content' => $ip,
            'ttl' => 1
        ]));
        
        $data = json_decode($res->body());
        return $data;
    }

    public static function createMXRecord($zone, $number ){
        $url = "https://api.cloudflare.com/client/v4/";
        
        $res = Http::withHeaders([
            'X-Auth-Key' => '300860cc6227c1aa84c0943e4ab1faf4ae80f',
            'X-Auth-Email' => 'bert@vbdesign.be',
            'X-Auth-User-Service-Key' => 'v1.0-4c1d29c10a1522177f175f20-1ff2845b62538aea7e1e829bf570d8c453ed099fd51d937acf7b761b02b5534dd198361822532e9356eba42ef01f8a621db3423545a53c73d18bdbaf1b8f43d2b7269e7a5d9f0b'
        ])->post($url.'zones/'.$zone.'/dns_records', ([
            'type' => 'MX',
            'name' => '',
            'content' => 'mx0'.$number.'.qboxmail.com',
            'ttl' => 1,
            'priority' => $number+0
        ]));
        
        $data = json_decode($res->body());
        return $data;
    }

    public static function createSPFRecord($zone ){
        $url = "https://api.cloudflare.com/client/v4/";
        
        $res = Http::withHeaders([
            'X-Auth-Key' => '300860cc6227c1aa84c0943e4ab1faf4ae80f',
            'X-Auth-Email' => 'bert@vbdesign.be',
            'X-Auth-User-Service-Key' => 'v1.0-4c1d29c10a1522177f175f20-1ff2845b62538aea7e1e829bf570d8c453ed099fd51d937acf7b761b02b5534dd198361822532e9356eba42ef01f8a621db3423545a53c73d18bdbaf1b8f43d2b7269e7a5d9f0b'
        ])->post($url.'zones/'.$zone.'/dns_records', ([
            'type' => 'TXT',
            'name' => '',
            'content' => 'v=spf1 include:spf.qboxmail.com mx a -all',
            'ttl' => 1,
        ]));
        
        $data = json_decode($res->body());
        return $data;
    }

    public static function createDKIMRecord($zone, $record ){
        $url = "https://api.cloudflare.com/client/v4/";
        
        $res = Http::withHeaders([
            'X-Auth-Key' => '300860cc6227c1aa84c0943e4ab1faf4ae80f',
            'X-Auth-Email' => 'bert@vbdesign.be',
            'X-Auth-User-Service-Key' => 'v1.0-4c1d29c10a1522177f175f20-1ff2845b62538aea7e1e829bf570d8c453ed099fd51d937acf7b761b02b5534dd198361822532e9356eba42ef01f8a621db3423545a53c73d18bdbaf1b8f43d2b7269e7a5d9f0b'
        ])->post($url.'zones/'.$zone.'/dns_records', ([
            'type' => 'TXT',
            'name' => '',
            'content' => $record,
            'ttl' => 1,
        ]));
        
        $data = json_decode($res->body());
        return $data;
    }

    public static function createDMARCRecord($zone ){
        $url = "https://api.cloudflare.com/client/v4/";
        
        $res = Http::withHeaders([
            'X-Auth-Key' => '300860cc6227c1aa84c0943e4ab1faf4ae80f',
            'X-Auth-Email' => 'bert@vbdesign.be',
            'X-Auth-User-Service-Key' => 'v1.0-4c1d29c10a1522177f175f20-1ff2845b62538aea7e1e829bf570d8c453ed099fd51d937acf7b761b02b5534dd198361822532e9356eba42ef01f8a621db3423545a53c73d18bdbaf1b8f43d2b7269e7a5d9f0b'
        ])->post($url.'zones/'.$zone.'/dns_records', ([
            'type' => 'TXT',
            'name' => '_dmarc.mycompany.com',
            'content' => 'v=DMARC1; p=quarantine; rua=mailto:rua@dmarc.qboxmail.com; ruf=mailto:ruf@dmarc.qboxmail.com',
            'ttl' => 1,
        ]));
        
        $data = json_decode($res->body());
        return $data;
    }

    public static function getDNSRecords($zone){
        $url = "https://api.cloudflare.com/client/v4/";
        
        $res = Http::withHeaders([
            'X-Auth-Key' => '300860cc6227c1aa84c0943e4ab1faf4ae80f',
            'X-Auth-Email' => 'bert@vbdesign.be',
            'X-Auth-User-Service-Key' => 'v1.0-4c1d29c10a1522177f175f20-1ff2845b62538aea7e1e829bf570d8c453ed099fd51d937acf7b761b02b5534dd198361822532e9356eba42ef01f8a621db3423545a53c73d18bdbaf1b8f43d2b7269e7a5d9f0b'
        ])->get($url.'zones/'.$zone.'/dns_records');
        $data = json_decode($res->body());
        return $data->result;
    }
}
