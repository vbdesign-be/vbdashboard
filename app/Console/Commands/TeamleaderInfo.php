<?php

namespace App\Console\Commands;

use App\Models\Infoteamleader;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Justijndepover\Teamleader\Teamleader;


class TeamleaderInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:teamleaderInfo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Getting the info for a teamleader connection';

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
        

        $info = Infoteamleader::find(1);
        $info->accestoken = "jonathan";
        $info->save();
        
    }
}
