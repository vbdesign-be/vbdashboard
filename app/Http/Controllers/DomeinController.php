<?php

namespace App\Http\Controllers;

use App\Models\EmailOrder;
use App\Models\Order;
use App\Models\Vimexx;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\cloudflareController;
use App\Http\Controllers\QboxController;
use App\Jobs\checkDnsINfo;

class DomeinController extends Controller
{
    public function domeinen(){
        $orders = Order::where('user_id', Auth::id())->get();
        foreach($orders as $order){
            if($order->payed){
                $data['orders'][] = $order;
            }
        }
        if(!empty($data['orders'])){
            return view('domeinen/domeinen', $data);
        }else{
            return view('domeinen/domeinen');
        }
        
    }

    public function detail($domain){
        //order ophalen met dat domein
        $order = Order::where('domain', $domain)->where('user_id', Auth::id())->first();
        if (empty($order)) {
            abort(403);
        }
        //informatie over een bepaald domein vimexx
        $vimexx = new Vimexx();
        $info = $vimexx->getDomainInformation($domain);
        //dd($info);
        //datum
        $datum= $info['Information']['expiration_date'];
        $jaar = substr($datum, 0, 4);
        $maand = substr($datum, 5, 2);
        $dag = substr($datum, 8, 2);
        $data['expiration_date'] = $dag . '-' . $maand . '-' . $jaar;
        
        //alle nameservers
        $data['nameservers'] = $info['Information']['nameservers'];
        //heeft klant emailbox bij ons?
        foreach ($data['nameservers'] as $server) {
            if (str_contains($server, "cloudflare")) {
                $nameserverCheck[] = true;
            } else {
                $nameserverCheck[] = false;
            }
        }

        

        if (in_array(true, $nameserverCheck)) {
            $data['isCloudflare'] = true;
            //indien cloudflare niet bestaat, cloudflare maken
            $check = cloudflareController::getOneDomain($domain);
            if (empty($check)) {
                cloudflareController::createZone($domain);
            }

            //aantal dns records
            $check = cloudflareController::getOneDomain($domain);
            $dns = cloudflareController::getDNSRecords($check[0]->id);
            
            if (!empty($dns)) {
                foreach ($dns as $d) {
                    if($d->type === "MX") {
                        if (str_contains($d->content, "qbox")) {
                            $data['checkDns'] = true;
                        }
                    }else{
                        $data['checkDns'] = true;
                    }
                }
            }else{
                $data['checkDns'] = true;
            }
            $data['numberDNS'] = count($dns);
            //aantal emails
            $emails = QboxController::getEmailsOfDomain($order->resource_code);
            if (!empty($emails->resources)) {
                //van de emailboxen een order maken;
                foreach ($emails->resources as $email) {
                    //checken of emailbox al bestaat
                    if (empty(EmailOrder::where('email', $email->email_address)->first())) {
                        $newEmailOrder = new EmailOrder();
                        $newEmailOrder->order_id =  $order->id;
                        $newEmailOrder->email = $email->email_address;
                        $newEmailOrder->resource_code = $email->domain_code;
                        $newEmailOrder->status = "active";
                        $newEmailOrder->payed = 1;
                        $newEmailOrder->save();
                    }
                }
                $data['numberEmails'] = count($emails->resources);
            } else {
                $data['numberEmails'] = 0;
            }
        } else {
            $data['isCloudflare'] = false;
            $order = Order::where('domain', $domain)->first();
            //cloudflare verwijderen
            $check = cloudflareController::getOneDomain($domain);
            if (!empty($check)) {
                cloudflareController::deleteZone(($check[0]->id));

            }

            //delete qboxmail
            $checkQbox = QboxController::getDomainInfo($order->resource_code);
            if (!empty($checkQbox)) {
                QboxController::deleteDomain($order->resource_code);
            }
            //delete emailorders
            $emailOrders = EmailOrder::where('order_id', $order->id)->get();
            if(!empty($emailOrders)){
                foreach ($emailOrders as $email) {
                    $email->delete();
                }
            }
            $data['numberEmails'] = 0;
            $data['numberDNS'] = 0;
        }
        $servers = [
            "ns1" => $data['nameservers'][0],
            "ns2" => $data['nameservers'][1],
            "ns3" => ""
        ];
        $vimexx->updateNameServers($domain, $servers);
        $data['domain'] = $domain;
        return view('domeinen/domeindetail', $data);
    }

    public function emailDetail($domain){
        //order ophalen met dat domein
        $order = Order::where('domain', $domain)->where('user_id', Auth::id())->first();
        if(empty($order)){
            abort(403);
        }

        //order ophalen van de emailboxen met dat domein
        $emails = EmailOrder::where('order_id', $order->id)->get();
        //enkel de betaalde emailboxen
        
        foreach($emails as $email){
            if($email->payed === 1){
                $emailsPayed [] = $email;
            }
        }
        if(!empty($emailsPayed)){
            $data['emails'] = $emailsPayed;
        }else{
            $data['emails'] = "";
        }
        $data['domain'] = $order->domain;
        $data['placeholder'] = "info@".$domain;
        return view('domeinen/emaildetail', $data);
    }

    public function deleteEmail(Request $request){
        //domeincode ophalen
        $domain = $request->input('domain');
        $order = Order::where('domain', $domain)->first();
        
        //emailcode ophalen
        $email = $request->input('email');
        $emailOrder = EmailOrder::where('email', $email)->first();
        
        //delete functie aanspreken
        QboxController::deleteEmail($order->resource_code, $emailOrder->resource_code);
        $emailOrder->delete();
        //succes message en redirect
        $request->session()->flash('message', $email." is verwijderd.");
        return redirect('domein/'.$order->domain);
    }

    public function nameserversDetail($domain){
        $order = Order::where('domain', $domain)->where('user_id', Auth::id())->first();
        if(empty($order)){
            abort(403);
        }
        $vimexx = new Vimexx();
        $info = $vimexx->getDomainInformation($domain);
        $data['nameservers'] = $info['Information']['nameservers'];
        $data['domain'] = $domain;
        return view('domeinen/nameserversdetail', $data);
    }

    public function updateNameservers(Request $request){
        $domain = $request->input('domain');
        $nameserver1 = $request->input('nameserver1');
        $nameserver2 = $request->input('nameserver2');
        $nameserver3 = $request->input('nameserver3');

        $servers['ns1'] = $nameserver1;
        $servers['ns2'] = $nameserver2;
        $servers['ns3'] = $nameserver3;
        
        $vimexx = new Vimexx();
        $resp = $vimexx->updateNameServers($domain, $servers);
        sleep(2);
        if($resp){
            $request->session()->flash('message', 'De nameservers voor '.$domain.' zijn gewijzigd.');
        }else{
            $request->session()->flash('error', 'Er ging iets mis. De nameservers voor '.$domain.' zijn niet gewijzigd.');
        }
        return redirect('/domein/'.$domain);
    }

    public function dnsDetail($domain){
        $data['domain'] = $domain;
        $order = Order::where('domain', $domain)->where('user_id', Auth::id())->first();
        if(empty($order)){
            abort(403);
        }

        $check = cloudflareController::getOneDomain($domain);
        $data['dnsList'] = cloudflareController::getDNSRecords($check[0]->id);
        $data['zone'] = $check[0]->id;
        
        return view('domeinen/dnsdetail', $data);
    }

    public function dnsAdd(Request $request){
        $credentials = $request->validate([
            'type' => 'required',
            'content' => 'required'
        ]);
        $domain = $request->input('domain');
        $zone = $request->input('zone');
        $type = $request->input('type');
        $name = $request->input('name');
        $content = $request->input('content');

        $order = Order::where('domain', $domain)->where('user_id', Auth::id())->first();
        if(empty($order)){
            abort(403);
        }
        
        $res = cloudflareController::createNewDNSRecord($zone, $type, $name, $content);
        if($res->success){
            $request->session()->flash('message', 'De dnsrecord voor '.$domain.' is toegevoegd.');
        }else{
            $error = $res->errors[0]->message;
            $request->session()->flash('error', 'Er ging iets mis: '.$error);
        }

        return redirect('domein/'.$domain.'/dns');
    }

    public function dnsEdit(Request $request){
        
        $credentials = $request->validate([
            'name' => 'required',
            'content' => 'required'
        ]);

        $zone = $request->input('zone');
        $domain = $request->input('domain');
        $dns_id = $request->input('dns_id');
        $type = $request->input('type');
        $name = $request->input('name');
        $content = $request->input('content');
        
        $order = Order::where('domain', $domain)->where('user_id', Auth::id())->first();
        
        if(empty($order)){
            abort(403);
        }

        $res = cloudflareController::editDNS($zone, $dns_id, $type, $name, $content);
        if($res->success){
            $request->session()->flash('message', 'De dnsrecord voor '.$domain.' is gewijzigd.');
        }else{
            $error = $res->errors[0]->message;
            $request->session()->flash('error', 'Er ging iets mis: '.$error);
        }
        return redirect('domein/'.$domain.'/dns');

    }

    public function dnsDelete(Request $request){
        $zone = $request->input('zone');
        $id = $request->input('id');
        $domain = $request->input('domain');

        $order = Order::where('domain', $domain)->where('user_id', Auth::id())->first();
        if(empty($order)){
            abort(403);
        }

        $res = cloudflareController::deleteDNS($zone, $id);

        if($res->success){
            $request->session()->flash('message', 'De dnsrecord voor '.$domain.' is verwijderd.');
        }else{
            $error = $res->errors[0]->message;
            $request->session()->flash('error', 'Er ging iets mis: '.$error);
        }
        return redirect('domein/'.$domain.'/dns');
       
    }

    public function domaindelete(Request $request){
        $domain = $request->input('domain');
        $order = Order::where('domain', $domain)->where('user_id', Auth::id())->first();
        if(empty($order)){
            abort(403);
        };

        $check = cloudflareController::getOneDomain($domain);
        $zone = $check[0]->id;
        //verwijderen uit cloudflare
        cloudflareController::deleteZone($zone);
        //verwijderen uit qboxmail
        QboxController::deleteDomain($order->resource_code);
        //verwijderen uit vimexx
        $vimexx = new Vimexx();
        $vimexx->deleteDomain($domain);

        //emails verwijderen
        $emails = EmailOrder::where('order_id', $order->id)->get();
        foreach($emails as $email){
            $email->delete();
        }
        //order verwijderen 
        $order->delete(); 

        $request->session()->flash('message', $domain.' is verwijderd.');
        return redirect('/domein');
    }

    
}
