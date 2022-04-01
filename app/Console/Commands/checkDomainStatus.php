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
    protected $description = 'Command description';

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
        $domains = Order::get();

        //elke domeinaamn chekken op beschikbaarheid
        foreach($domains as $d){
            $vimexx = new Vimexx();
            $check = $vimexx->checkDomain($d->domain);
        
            if($check === "Niet beschikbaar"){
                //niet beschikbaar->active zetten
                $order = Order::find($d->id);
                $order->status = "active";
                $order->save();
            }else{
                //beschikbaar->op failed zetten
                $order = Order::find($d->id);
                $order->status = "failed";
                $order->save();
            }
        }
    }
}
