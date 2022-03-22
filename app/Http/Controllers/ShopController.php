<?php

namespace App\Http\Controllers;

use App\Models\EmailOrder;
use App\Models\Order;
use App\Models\Vimexx;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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

        $order = Order::where('domain', $domain)->first();

        if(!empty($order)){
            $data["domain"] = "";
            $request->session()->flash('error', $domain.' is al in benadeling');
            return view('shop/shop', $data);
        }

        if(str_ends_with($domain, ".be")){
            $data["domain"] = $domain;
            $vimexx = new Vimexx();
            $check = $vimexx->checkDomain($domain);
            $data["check"] = $check;
        
            if($check === "Beschikbaar"){
                $data['checkColor'] = "green";
            }else{
                $data['checkColor'] = "red";
            }
        }else{
            $data["domain"] = "";
            $request->session()->flash('error', $domain.' is geen domeinnaam');
        }
        return view('shop/shop', $data);

    }

    public function cart(Request $request){
        $domain = $request->input('domain');
        $data["domain"] = $domain;
        $data["mailbox"] = "info@".$domain;
        return view('shop/cart', $data);
    }

    public function buyDomain(Request $request){
        
        $domain = $request->input("domain");
        if(!empty($domain)){

            $order = new Order();
            $order->domain = $domain;
            $order->user_id = Auth::id();
            $order->payed = false;
            $order->save();

            //molliepayment starten
            MollieController::createPayment('4.99', $domain);
            
            return redirect('domeinen');


        }
        
    }

    public function payed(Request $request){
        //order aanpassen
        $id = $request->input('order_id');
        $order = Order::where('id', $id)->first();
        $order->payed = 1;
        $order->status = "pending";
        $order->save();

        //domeinnaam registeren via vimexx
        $vimexx = new Vimexx();
        // $res = $vimexx->registerDomain($order->domain);
        // dd($res);

        //domeinnaam reistreren via cloudflare
        $cloudflare = CloudflareController::createZone($order->domain);

        //message en redirect
        $request->session()->flash('message', 'We hebben je aankoop goed ontvangen. We zijn nu bezig met '.$order->domain.' te registeren. Dit kan 24u duren.');
        return redirect('domeinen');
    }

    public function payedEmail(Request $request){
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
            $test = QboxController::makeEmail($front, $resource_code, $password, $user->data->first_name);
            
        }else{
            
            //domain toevoegen aan qboxmail
            $resource_code = QboxController::makeDomain($order->domain);

            //emailorder opslaan
            $order->resource_code = $resource_code; 
            $order->save();
            //emailbox toevoegen
            

             //toevoegen aan de cloudflare domein
                //create a cloudflare domein als dat er nog niet is
                $check = CloudflareController::getOneDomain($order->domain);
                
                if(empty($check)){
                    //informatie tonen zodat mensne die kunnen invullen
                    $info = "name: ".strtolower($resource_code).".".$order->domain.", ip: 185.97.217.16";
                    $request->session()->flash('notification', 'We hebben je aankoop goed ontvangen. Vul deze gegevens in bij je domeinaamhost: '.$info);
                    return redirect('domein/'.$order->domain);
                }else{
                    $name = strtolower($resource_code).'.'.$order->domain;
                    $ip = '185.97.217.16';
                    
                    //invullen op cloudflare
                    CloudflareController::createDnsRecord($check[0]->id, $name, $ip);
                    //qboxmail check doen
                    $test = QboxController::checkDns($resource_code);
                    sleep(40);
                    
                    $resp = QboxController::makeEmail($front, $resource_code, $password, $user->data->first_name);
                    
                }
                
        }

        $request->session()->flash('message', 'We hebben je aankoop goed ontvangen. We zijn nu bezig met je emailbox te registeren. Dit kan 24u duren.');
        return redirect('domein/'.$order->domain);
    }



    public function buyEmail(Request $request){
        $credentials = $request->validate([
            'emailbox' => 'required|email|max:255',
            'password' => 'required|confirmed|min:8',

        ]);
        $email = $request->input('emailbox');
        $password = $request->input('password');
        $domain = $request->input('domain');
        $front = strtok($email, '@');
        
        

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
        MollieController::createPaymentEmail('4.99', $front."@".$domain, $front, $password);
    }
}
