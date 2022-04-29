<?php

namespace App\Http\Controllers;

use App\Jobs\checkDnsINfo;
use App\Models\EmailOrder;
use App\Models\Order;
use App\Models\Vimexx;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\cloudflareController;
use App\Http\Controllers\QboxController;
use App\Models\Product;

class ShopController extends Controller
{
    public function shop(){
        return view('shop/shop');
    }

    public function searchDomain(Request $request){

        $credentials = $request->validate([
            'domeinnaam' => 'required|max:255',
        ]);

    
        $input = $request->input('domeinnaam');
        if(strtok($input, '.') === "www"){
            $domain = substr($input, strpos($input, ".") + 1); 
        }else{
            $domain = $input;
        }
        
        $checkDomain = explode(".", $domain);
        if(!isset($checkDomain[1]) && !isset($checkDomain[2])){
            $request->session()->flash('error', $input.' is geen domeinnaam');
            return view('shop/shop');
        }
        

        $order = Order::where('domain', $domain)->first();

        if(!empty($order)){
            $data["domain"] = "";
            $request->session()->flash('error', $domain.' is al in benadeling');
            return view('shop/shop', $data);
        }

        
        $data["domain"] = $domain;
        $vimexx = new Vimexx();
        $check = $vimexx->checkDomain($domain);
        $data["check"] = $check;
        
        if($check === "Beschikbaar"){
            $data['checkColor'] = "green";
        }else{
            $data['checkColor'] = "red";
        }
        
        return view('shop/shop', $data);

    }

    public function cart(Request $request){
        $credentials = $request->validate([
            'domein' => 'required',
        ]);

        $domain = $request->input('domein');
        $end = ".".explode('.', $domain,)[1];
        $data["domain"] = $domain;
        $data["mailbox"] = "info@".$domain;
        $product = Product::where('name', $end)->first();
        if(empty($product)){
            $request->session()->flash('notification', 'Momenteel kunt u "'.$domain.'" niet aankopen via het dashboard. Gelieve een supportticket te maken of ons een mailtje te sturen');
            return redirect('/shop');
        }else{
            $data['price'] = $product->price;
        }
        return view('shop/cart', $data);
    }

    public function cartTransfer(Request $request){

        $credentials = $request->validate([
            'domein' => 'required'
        ]);
        
        $domain = $request->input('domein');
        $data["domain"] = $domain;
        $data["mailbox"] = "info@".$domain;
        $data['price'] = Product::where('name', 'transfer')->first()->price;
        return view('shop/cartTransfer', $data);
    }

    public function buyDomain(Request $request){
        //checking
        $credentials = $request->validate([
            'domein' => 'required|max:255',
            'prijs' => 'required'
        ]);
        
        $domain = $request->input("domein");
        $price = $request->input("prijs");

        if(!empty($domain)){
            $order = new Order();
            $order->domain = $domain;
            $order->user_id = Auth::id();
            $order->status = "ordered";
            $order->payed = false;
            $order->save();

            //molliepayment starten
            MollieController::createPayment($price, $domain);
        }
        
    }

    public function payed(Request $request){
        $credentials = $request->validate([
            'order_id' => 'required', 
        ]);
        
        //order aanpassen
        $id = $request->input('order_id');
        $order = Order::where('id', $id)->first();
        $order->payed = 1;
        $order->status = "pending";
        $order->save();

        //domeinnaam registeren via vimexx
        $vimexx = new Vimexx();
        //$res = $vimexx->registerDomain($order->domain);
        

        //domeinnaam reistreren via cloudflare
        $cloudflare = cloudflareController::createZone($order->domain);

        //postmark maken en dkim return
        $postmark = PostmarkController::createDomain($order->domain);
        
        //cloudflare dkim invullen en verifieren;
        $checkCloud = cloudflareController::getOneDomain($order->domain);
        $cloudDKIM = cloudflareController::createDKIMRecordPostmark($checkCloud[0]->id, $postmark->DKIMPendingHost, $postmark->DKIMPendingTextValue);
        sleep(5);
        PostmarkController::checkDKIM($postmark->ID);
        
        //postmark return path invullen en verifieren
        cloudflareController::createCNAMERecordPostmark($checkCloud[0]->id, $postmark->ReturnPathDomainCNAMEValue);
        sleep(5);
        PostmarkController::checkCNAME($postmark->ID);

        
        //vimexx checken of domein actief is
        $check = $vimexx->checkDomain($order->domain);
        if($check === 'Niet beschikbaar'){
            $order->status = "active";
            $order->save();
        }

        //message en redirect
        $request->session()->flash('message', 'We hebben je aankoop goed ontvangen. We zijn nu bezig met '.$order->domain.' te registeren. Dit kan 24u duren.');
        return redirect('/domein');
    }

    public function payedEmail(Request $request){
        $credentials = $request->validate([
            'emailorder_id' => 'required',
            'front' => 'required',
            'password' => 'required'
        ]);

        //emailOrder aanpassen
        $emailOrderId = $request->input('emailorder_id');
        $front = $request->input('front');
        $password = $request->input('password');
        $emailOrder = EmailOrder::find($emailOrderId);
        $emailOrder->payed = 1;
        $emailOrder->status = "pending";
        $emailOrder->save();

        $user = UserController::getUser();

        $order = Order::find($emailOrder->order_id);
        //pas hier de logica toepassen van na de aankoop

        //checken of email nog beschikbaar is in qbox
        //api call
        $emailDomains = QboxController::getAllDomains();
        
        foreach($emailDomains as $edomain){
            if($edomain->name === $order->domain){
                $check [] = "bestaat al";
            }else{
                $check [] = "bestaat niet"; 
            }
        };

        if(in_array('bestaat al' , $check)){
            //email gewoon toevoegen via qboxmail
            $order = Order::where('domain', $order->domain)->first();
            $resource_code = $order->resource_code;
            $newEmail = QboxController::makeEmail($front, $resource_code, $password, $user->data->first_name);
            $emailOrder->status = "active";
            $emailOrder->resource_code = $newEmail->resource_code;
            $emailOrder->save();
            $request->session()->flash('message', 'We hebben je aankoop goed ontvangen. '.$emailOrder->email.' is geregistreerd.');
            return redirect('domein/'.$order->domain);
        }else{
            
            //domain toevoegen aan qboxmail
            $resource_code = QboxController::makeDomain($order->domain);

            //emailorder opslaan
            $order->resource_code = $resource_code; 
            $order->save();
            //emailbox toevoegen
            
             //toevoegen aan de cloudflare domein
                //create a cloudflare domein als dat er nog niet is
                $check = cloudflareController::getOneDomain($order->domain);
                
                if(empty($check)){
                    //informatie tonen zodat mensne die kunnen invullen
                    $dns = "type: A   name: ".$resource_code.".".$order->domain."   content: 185.97.217.16   TTL: auto/1";

                    //de juiste informatie weergeven
                    $request->session()->flash('notification', "We hebben je aankoop goed ontvangen. Vul deze gegevens in bij je domeinaamhost:\n".$dns."\nStuur ons een support ticket wanneer je deze info hebt ingevuld.");
                    return redirect('domein/'.$order->domain);
                }else{
                    $name = strtolower($resource_code).'.'.$order->domain;
                    $ip = '185.97.217.16';

                    //invullen op cloudflare
                    cloudflareController::createDnsRecord($check[0]->id, $name, $ip);
                    //qboxmail check doen liefts async
                    $this->dispatch(new checkDnsINfo($resource_code, $check, $front, $password, $user, $emailOrder));
                }
        }

        $request->session()->flash('message', 'We hebben je aankoop goed ontvangen. We zijn nu bezig met je emailbox te registeren. Dit kan 24u duren.');
        return redirect('domein/'.$order->domain);
    }



    public function buyEmail(Request $request){
        $credentials = $request->validate([
            'emailadres' => 'required|email|max:255',
            'wachtwoord' => 'required|confirmed|min:8',
            'domein' => 'required'
        ]);
        $email = $request->input('emailadres');
        $password = $request->input('wachtwoord');
        $domain = $request->input('domein');
        $front = strtok($email, '@');
        $price = Product::where('name', 'mailbox')->first()->price;
        
        //checken of de emailbox al bestaat
        $emailOrder = EmailOrder::where('email', $front."@".$domain)->first();

        //checken of email nog beschikbaar is
        if(!empty($emailOrder)){
            $request->session()->flash('error', $emailOrder->email.' is al in benadeling');
            return redirect('domein/'.$domain);
        }
        
        //order maken in de emailorders
            //order id van domein weten
        $res = Order::where('domain', $domain)->first();
        $order = new EmailOrder();
        $order->order_id = $res->id;
        $order->email = $front."@".$domain;
        $order->status = "pending";
        $order->save();
        
        //payment creeren
        MollieController::createPaymentEmail($price, $front."@".$domain, $front, $password);
    }

    public function transferDomain(Request $request){
        //checking
        $credentials = $request->validate([
            'domein' => 'required|max:255',
            'code' => 'required',
            'prijs' => 'required'
        ]);
        
        
        $domain = $request->input("domein");
        $code = $request->input('code');
        $price = $request->input('prijs');
        if(!empty($domain) && !empty($code)){
            $order = new Order();
            $order->domain = $domain;
            $order->user_id = Auth::id();
            $order->payed = false;
            $order->save();

            //molliepayment starten
            MollieController::createPaymentTransfer($price, $domain, $code);
        }
    }

    public function payedTransfer(Request $request){
        $id = $request->input('order_id');
        $code = $request->input('code');
        $order = Order::where('id', $id)->first();
        $order->payed = 1;
        $order->status = "pending";
        $order->save();

        //domeinnaam verhuizen
        $vimexx = new Vimexx();
        //$vimexx->transferDomain($order->domain,'', '', $code);

        //toevoegen aan cloudflare
        $zone = cloudflareController::createZone($order->domain);
        $check = cloudflareController::getOneDomain($order->domain);
        $scan = cloudflareController::dnsScan($check[0]->id);

        //postmark maken en dkim return
        $postmark = PostmarkController::createDomain($order->domain);
        
        //cloudflare dkim invullen en verifieren;
        $checkCloud = cloudflareController::getOneDomain($order->domain);
        $cloudDKIM = cloudflareController::createDKIMRecordPostmark($checkCloud[0]->id, $postmark->DKIMPendingHost, $postmark->DKIMPendingTextValue);
        sleep(5);
        PostmarkController::checkDKIM($postmark->ID);
        
        //postmark return path invullen en verifieren
        cloudflareController::createCNAMERecordPostmark($checkCloud[0]->id, $postmark->ReturnPathDomainCNAMEValue);
        sleep(5);
        PostmarkController::checkCNAME($postmark->ID);

        $check = $vimexx->checkDomain($order->domain);
        if($check === 'Niet beschikbaar'){
            $order->status = "active";
            $order->save();
            $request->session()->flash('message', 'We hebben je aankoop goed ontvangen. We zijn nu bezig met je domeinaam te verhuizen. Dit kan 24u duren.');
        }else{
            $request->session()->flash('error', 'Er is iets fout gegaan. Je kan ons bereiken via een support ticket');
        }
        
        return redirect('domein/'.$order->domain);
    }

   

    

    
}
