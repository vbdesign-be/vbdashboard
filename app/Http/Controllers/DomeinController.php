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
use Illuminate\Support\Facades\Session;

class DomeinController extends Controller
{
    public function domeinen(){
        //allee domeinen voor de ingelogde gebruiker ophalen en meegeven naar de blade
        //enkel de betaalde orders mogen getoond worden
        $data['orders'] = Order::where('user_id', Auth::id())->where('payed', 1)->get();
        return view('domeinen/domeinen', $data);
    }

    //detailpagina van een domein
    public function detail($domain){
        //order ophalen met dat domein
        $order = Order::where('domain', $domain)->where('user_id', Auth::id())->first();
        if (empty($order)) {
            abort(403);
        }
        //informatie over een bepaald domein vimexx
        $vimexx = new Vimexx();
        $info = $vimexx->getDomainInformation($domain);
       
        //datum format aanpassen
        $datum= $info['Information']['expiration_date'];
        $jaar = substr($datum, 0, 4);
        $maand = substr($datum, 5, 2);
        $dag = substr($datum, 8, 2);
        $data['expiration_date'] = $dag . '-' . $maand . '-' . $jaar;
        
        //alle nameservers
        $data['nameservers'] = $info['Information']['nameservers'];

        //heeft de klant cloudflare in zijn nameservers staan?
        foreach ($data['nameservers'] as $server) {
            if (str_contains($server, "cloudflare")) {
                $nameserverCheck[] = true;
            } else {
                $nameserverCheck[] = false;
            }
        }

        if (in_array(true, $nameserverCheck)) {
            //cloudflare zit in de nameservers
            //klant moet cloudflare en postmark hebben

            $data['isCloudflare'] = true;

            //indien cloudflare niet bestaat, cloudflare en postmark maken
            $check = cloudflareController::getOneDomain($domain);
            dd($check);
            if (empty($check)) {
                cloudflareController::createZone($domain);
                
                //scannen naar dnsrecords
                $check = cloudflareController::getOneDomain($domain);
                $scan = cloudflareController::dnsScan($check[0]->id);

                //postmark maken en id opslaan in database
                $postmark = PostmarkController::createDomain($domain);
                $order->postmark = strval($postmark->ID);
                $order->save();
        
                //cloudflare dkim invullen en verifieren;
                $checkCloud = cloudflareController::getOneDomain($domain);
                $cloudDKIM = cloudflareController::createDKIMRecordPostmark($check[0]->id, $postmark->DKIMPendingHost, $postmark->DKIMPendingTextValue);
                sleep(5);
                PostmarkController::checkDKIM($postmark->ID);
        
                //postmark return path invullen en verifieren
                cloudflareController::createCNAMERecordPostmark($check[0]->id, $postmark->ReturnPathDomainCNAMEValue);
                sleep(5);
                PostmarkController::checkCNAME($postmark->ID);
            }

            //checken of postmark en cloudflare werken
            $check = cloudflareController::getOneDomain($domain)[0];
            $checkPost = PostmarkController::getOneDomain($order->postmark);

            //als cloudflare op active staat->postmark aanmaken
            if($check->status === "active"){
                //postmark maken en id opslaan in database
                $postmark = PostmarkController::createDomain($domain);
                $order->postmark = strval($postmark->ID);
                $order->save();

                cloudflareController::createDKIMRecordPostmark($check->id, $postmark->DKIMPendingHost, $postmark->DKIMPendingTextValue);
                sleep(5);
                PostmarkController::checkDKIM($postmark->ID);
        
                //postmark return path invullen en verifieren
                cloudflareController::createCNAMERecordPostmark($check->id, $postmark->ReturnPathDomainCNAMEValue);
                sleep(5);
                PostmarkController::checkCNAME($postmark->ID);
            }


            
            if($check->status !== "active" && $checkPost->DKIMVerified !== true && $checkPost->ReturnPathDomainVerified !== true){
                //postmark en cloudlfare zijn nog aan het wachten op een nameserver update
                $order->status = "pending";
                $order->save();
                $data['numberEmails'] = 0;
                $data['checkDns'] = true;
                $data['isCloudflare'] = false;
                $data['domain'] = $domain;
                $data['numberDNS'] = 0;
                $data['order'] = $order;
                //gebruiker laten weten dat de update nog bezig is
                //code stopt hier->redirecten
                Session::forget('message');
                Session::flash('error', 'De nameservers zijn momenteel nog aan het updaten. Dit kan 24u duren');
                return view('domeinen/domeindetail', $data);
            }

            //status op active
            $order->status = "active";
            $order->save();
            
            //aantal dns records
            $check = cloudflareController::getOneDomain($domain);
            $dns = cloudflareController::getDNSRecords($check[0]->id);
            
            //checken of de mx record qbox bevatten
            //zo weten we of de emailboxen bij ons zijn of niet
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

            //aantal emails van een domeon
            $emails = QboxController::getEmailsOfDomain($order->resource_code);

            //kijken of er emailboxen zijn
            if (!empty($emails->resources)) {
                //als er emails zijn, van deze emails een EmailOrder maken in de database
                foreach ($emails->resources as $email){
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
                //counten hoeveel emails er zijn op qboxmail
                $data['numberEmails'] = count($emails->resources);
            } else {
                $data['numberEmails'] = 0;
            }

        //hier stop de if
        } else {

            //nameservers zijn niet van cloudflare
            $data['isCloudflare'] = false;
            $order = Order::where('domain', $domain)->first();

            //cloudflare verwijderen
            $check = cloudflareController::getOneDomain($domain);
            if (!empty($check)) {
                cloudflareController::deleteZone(($check[0]->id));

            }

            //delete postmark
            PostmarkController::deleteDomain($order->postmark);

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

            //einde van de if else loop
        }

        //domain en order meegeven naar de blade. Deze zijn nodig
        $data['domain'] = $domain;
        $data['order'] = $order;
        return view('domeinen/domeindetail', $data);
    }

    //detailpagina van de emails van een domein
    public function emailDetail($domain){

        //order ophalen met dat domein voor de gebruiker
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

        //checken of er betaalde emails zijn
        //anders een lege string meegeven zodat code werkt
        if(!empty($emailsPayed)){
            $data['emails'] = $emailsPayed;
        }else{
            $data['emails'] = "";
        }

        $data['domain'] = $order->domain;
        $data['placeholder'] = "info@".$domain;
        return view('domeinen/emaildetail', $data);
    }

    //het deleten van een email
    public function deleteEmail(Request $request){
        
        $credentials = $request->validate([
            'domein' => 'required',
            'email' => 'required'
        ]);
        
        //domeincode ophalen
        $domain = $request->input('domein');
        $order = Order::where('domain', $domain)->first();
        
        //emailcode ophalen
        $email = $request->input('email');
        $emailOrder = EmailOrder::where('email', $email)->first();
        
        //delete functie aanspreken
        $emailOrder->delete();
        QboxController::deleteEmail($order->resource_code, $emailOrder->resource_code);

        //even wachten zodat de email echt weg is van qboxmail(duurt een paar seconden)
        sleep(10);

        //succes message en redirect
        $request->session()->flash('message', $email." is verwijderd.");
        return redirect('domein/'.$order->domain);
    }

    //detailpagina van de nameservers
    public function nameserversDetail($domain){
        //order ophalen met dat domein voor de gebruiker
        $order = Order::where('domain', $domain)->where('user_id', Auth::id())->first();
        if(empty($order)){
            abort(403);
        }

        //nieuwe instantie van de classe Vimexx
        //met functie die de informatie van een domeinnaam geeft
        $vimexx = new Vimexx();
        $info = $vimexx->getDomainInformation($domain);

        $data['nameservers'] = $info['Information']['nameservers'];
        $data['domain'] = $domain;
        return view('domeinen/nameserversdetail', $data);
    }

    //nameservers updaten voor een domein
    public function updateNameservers(Request $request){
        $credentials = $request->validate([
            'domein' => 'required',
        ]);

        $domain = $request->input('domein');
        $nameserver1 = $request->input('nameserver1');
        $nameserver2 = $request->input('nameserver2');
        $nameserver3 = $request->input('nameserver3');

        //array maken van de nameservers voor de functie van vimexx
        $servers = [
            'ns1' => $nameserver1,
            'ns2' => $nameserver2,
            'ns3' => $nameserver3
        ];
        
        //nieuwe instantie van de classe Vimexx met functie die de nameservers update
        $vimexx = new Vimexx();
        $resp = $vimexx->updateNameServers($domain, $servers);

        //even wachten zodat de nameservers daadwerkelijk zijn geupdate
        sleep(2);

        //kijken of $resp true is of niet
        if($resp){
            $request->session()->flash('message', 'De nameservers voor '.$domain.' zijn gewijzigd.');
        }else{
            $request->session()->flash('error', 'Er ging iets mis. De nameservers voor '.$domain.' zijn niet gewijzigd.');
        }
        return redirect('/domein/'.$domain);
    }

    //detailpagina van de dns
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

    //dns toevoegen aan een domeinnaam
    public function dnsAdd(Request $request){
        $credentials = $request->validate([
            'type' => 'required',
            'content' => 'required',
            'zone' => 'required',
            'naam' => "required",
            'domein' => 'required'
        ]);
        
        $domain = $request->input('domein');
        $zone = $request->input('zone');
        $type = $request->input('type');
        $name = $request->input('naam');
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

    //updaten van een specifiek dns record
    public function dnsEdit(Request $request){
        
        $credentials = $request->validate([
            'type' => 'required',
            'content' => 'required',
            'zone' => 'required',
            'naam' => "required",
            'domein' => 'required',
            'dns_id' => 'required'
        ]);

        $zone = $request->input('zone');
        $domain = $request->input('domein');
        $dns_id = $request->input('dns_id');
        $type = $request->input('type');
        $name = $request->input('naam');
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

    //deleten van een specifiek dsn record
    public function dnsDelete(Request $request){
        $credentials = $request->validate([
            'zone' => 'required',
            'id' => 'required',
            'domein' => 'required'
        ]);
        
        $zone = $request->input('zone');
        $id = $request->input('id');
        $domain = $request->input('domein');

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

    //deleten van een domein
    public function domaindelete(Request $request){
        $credentials = $request->validate([
            'domein' => 'required',
        ]);
        $domain = $request->input('domein');
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
