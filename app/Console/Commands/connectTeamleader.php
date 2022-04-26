<?php

namespace App\Console\Commands;

use App\Models\Emailtest;
use Illuminate\Console\Command;

class connectTeamleader extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'connect:teamleader';

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
        $test = new Emailtest();
        $test->test = "jiplaaa";
        $test->save();
    }
}
