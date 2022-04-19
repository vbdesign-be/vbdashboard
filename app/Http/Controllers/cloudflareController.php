<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class cloudflareController extends Controller
{
    public function test(){
        $url = "https://api.cloudflare.com/client/v4/";
        
        $res = Http::withHeaders([
            'X-Auth-Key' => env('CLOUDFLARE_AUTH_KEY'),
            'X-Auth-Email' => 'bert@vbdesign.be',
            'X-Auth-User-Service-Key' => env('CLOUDFLARE_USER_KEY')
        ])->get($url.'/accounts/46ec306d71921c8086e04f573412597f');
        $data = json_decode($res->body());
        dd($data->result);
    }

    public static function getOneDomain($domain){
        $url = "https://api.cloudflare.com/client/v4/";
        
        $res = Http::withHeaders([
            'X-Auth-Key' => env('CLOUDFLARE_AUTH_KEY'),
            'X-Auth-Email' => 'bert@vbdesign.be',
            'X-Auth-User-Service-Key' => env('CLOUDFLARE_USER_KEY')
        ])->get($url.'/zones?name='.$domain.'&account.id=46ec306d71921c8086e04f573412597f');
        $data = json_decode($res->body());
        return $data->result;
    }

    public static function createZone($domain){
        $url = "https://api.cloudflare.com/client/v4/";
        
        $res = Http::withHeaders([
            'X-Auth-Key' => env('CLOUDFLARE_AUTH_KEY'),
            'X-Auth-Email' => 'bert@vbdesign.be',
            'X-Auth-User-Service-Key' => env('CLOUDFLARE_USER_KEY')
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
            'X-Auth-Key' => env('CLOUDFLARE_AUTH_KEY'),
            'X-Auth-Email' => 'bert@vbdesign.be',
            'X-Auth-User-Service-Key' => env('CLOUDFLARE_USER_KEY')
        ])->post($url.'zones/'.$zone.'/dns_records', ([
            'type' => 'A',
            'name' => $name,
            'content' => $ip,
            'ttl' => 900
        ]));
        
        $data = json_decode($res->body());
        return $data;
    }

    public static function createMXRecord($zone, $number ){
        $url = "https://api.cloudflare.com/client/v4/";
        
        $res = Http::withHeaders([
            'X-Auth-Key' => env('CLOUDFLARE_AUTH_KEY'),
            'X-Auth-Email' => 'bert@vbdesign.be',
            'X-Auth-User-Service-Key' => env('CLOUDFLARE_USER_KEY')
        ])->post($url.'zones/'.$zone.'/dns_records', ([
            'type' => 'MX',
            'name' => '',
            'content' => 'mx0'.$number.'.qboxmail.com',
            'ttl' => 900,
            'priority' => $number+0
        ]));
        
        $data = json_decode($res->body());
        return $data;
    }

    public static function createSPFRecord($zone ){
        $url = "https://api.cloudflare.com/client/v4/";
        
        $res = Http::withHeaders([
            'X-Auth-Key' => env('CLOUDFLARE_AUTH_KEY'),
            'X-Auth-Email' => 'bert@vbdesign.be',
            'X-Auth-User-Service-Key' => env('CLOUDFLARE_USER_KEY')
        ])->post($url.'zones/'.$zone.'/dns_records', ([
            'type' => 'TXT',
            'name' => '',
            'content' => 'v=spf1 include:spf.qboxmail.com mx a -all',
            'ttl' => 900,
        ]));
        
        $data = json_decode($res->body());
        return $data;
    }

    public static function createDKIMRecord($zone, $record ){
        $url = "https://api.cloudflare.com/client/v4/";
        
        $res = Http::withHeaders([
            'X-Auth-Key' => env('CLOUDFLARE_AUTH_KEY'),
            'X-Auth-Email' => 'bert@vbdesign.be',
            'X-Auth-User-Service-Key' => env('CLOUDFLARE_USER_KEY')
        ])->post($url.'zones/'.$zone.'/dns_records', ([
            'type' => 'TXT',
            'name' => '',
            'content' => $record,
            'ttl' => 900,
        ]));
        
        $data = json_decode($res->body());
        return $data;
    }

    public static function createDMARCRecord($zone ){
        $url = "https://api.cloudflare.com/client/v4/";
        
        $res = Http::withHeaders([
            'X-Auth-Key' => env('CLOUDFLARE_AUTH_KEY'),
            'X-Auth-Email' => 'bert@vbdesign.be',
            'X-Auth-User-Service-Key' => env('CLOUDFLARE_USER_KEY')
        ])->post($url.'zones/'.$zone.'/dns_records', ([
            'type' => 'TXT',
            'name' => '_dmarc.mycompany.com',
            'content' => 'v=DMARC1; p=quarantine; rua=mailto:rua@dmarc.qboxmail.com; ruf=mailto:ruf@dmarc.qboxmail.com',
            'ttl' => 900,
        ]));
        
        $data = json_decode($res->body());
        return $data;
    }

    public static function getDNSRecords($zone){
        $url = "https://api.cloudflare.com/client/v4/";
        
        $res = Http::withHeaders([
            'X-Auth-Key' => env('CLOUDFLARE_AUTH_KEY'),
            'X-Auth-Email' => 'bert@vbdesign.be',
            'X-Auth-User-Service-Key' => env('CLOUDFLARE_USER_KEY')
        ])->get($url.'zones/'.$zone.'/dns_records');
        $data = json_decode($res->body());
        return $data->result;
    }

    public static function createNewDNSRecord($zone, $type, $name, $content){
        $url = "https://api.cloudflare.com/client/v4/";
        
        $res = Http::withHeaders([
            'X-Auth-Key' => env('CLOUDFLARE_AUTH_KEY'),
            'X-Auth-Email' => 'bert@vbdesign.be',
            'X-Auth-User-Service-Key' => env('CLOUDFLARE_USER_KEY')
        ])->post($url.'zones/'.$zone.'/dns_records', ([
            'type' => $type,
            'name' => $name,
            'content' => $content,
            'ttl' => 900,
        ]));
        
        $data = json_decode($res->body());
        return $data;
    }

    public static function editDNS($zone, $dns_id, $type, $name, $content){
        $url = "https://api.cloudflare.com/client/v4/";
        
        $res = Http::withHeaders([
            'X-Auth-Key' => env('CLOUDFLARE_AUTH_KEY'),
            'X-Auth-Email' => 'bert@vbdesign.be',
            'X-Auth-User-Service-Key' => env('CLOUDFLARE_USER_KEY')
        ])->put($url.'zones/'.$zone.'/dns_records/'.$dns_id, ([
            'type' => $type,
            'name' => $name,
            'content' => $content,
            'ttl' => 900,
        ]));
        
        $data = json_decode($res->body());
        return $data;
    }

    public static function deleteDNS($zone, $dns_id){
        $url = "https://api.cloudflare.com/client/v4/";
        
        $res = Http::withHeaders([
            'X-Auth-Key' => env('CLOUDFLARE_AUTH_KEY'),
            'X-Auth-Email' => 'bert@vbdesign.be',
            'X-Auth-User-Service-Key' => env('CLOUDFLARE_USER_KEY')
        ])->delete($url.'zones/'.$zone.'/dns_records/'.$dns_id);
        
        $data = json_decode($res->body());
        return $data;
    }

    public static function deleteZone($zone){
        $url = "https://api.cloudflare.com/client/v4/";
        $res = Http::withHeaders([
            'X-Auth-Key' => env('CLOUDFLARE_AUTH_KEY'),
            'X-Auth-Email' => 'bert@vbdesign.be',
            'X-Auth-User-Service-Key' => env('CLOUDFLARE_USER_KEY')
        ])->delete($url.'zones/'.$zone);
        
        $data = json_decode($res->body());
        return $data;
    }

}
