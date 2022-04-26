<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class cloudflareController extends Controller
{
    //informatie van een domein op cloudflare verkrijgen
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

    //cloudflare zone voor domeinnaam creeren
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

    //eerste a record creeeren om qbox met cloudflare te verbinden
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

    //mx record creeeren om cloudflare met qbox mail te verbinden
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

    //spf record creeeren om cloudflare met qbox mail te verbinden
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

    //dkim record creeeren om cloudflare met qbox mail te verbinden
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

    //dmarc record creeeren om cloudflare met qbox mail te verbinden
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

    //alle dns record van een domeinnaam zone verkrijgen
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

    //nieuwe dns record maken
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

    //dns record updaten
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
            'priority' => 1
        ]));
        
        $data = json_decode($res->body());
        return $data;
    }

    //dns record verwijderen
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

    //domein zone verwijderen
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
