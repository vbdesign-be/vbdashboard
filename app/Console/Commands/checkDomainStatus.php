<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Vimexx;
use Illuminate\Console\Command;

class checkDomainStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:domainstatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checken of de domeinnaam online is of niet';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
         //domeinnamen uit de database halen
         $orderDomains = Order::get();
         $vimexx = new Vimexx();
         $domains = $vimexx->getDomainList();
 
         //elke domeinaamn chekken op beschikbaarheid
         foreach($domains as $d){
             $checkDomain[] = $d['domain'];
         }
         
         foreach($orderDomains as $o){
             if(in_array($o->domain, $checkDomain)){
                 $order = Order::find($o->id);
                 $order->status = "active";
                 $order->save();
             }else{
                 $order = Order::find($o->id);
                 $order->status = "failed";
                 $order->save();
             }
         }
    }
}
