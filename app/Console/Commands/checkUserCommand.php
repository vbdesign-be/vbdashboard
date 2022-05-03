<?php

namespace App\Console\Commands;

use App\Http\Controllers\teamleaderController;
use App\Models\User;
use Illuminate\Console\Command;
use Vbdesign\Teamleader\Facade\Teamleader;

class checkUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'functie die alle contactpersonen checkt in teamleader of ze de tag klant hebben
                                zijn ze klant->opslaan in database
                                waren ze klant en nu niet meer->verwijderen uit database';

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
        teamleaderController::reAuthTL();

        for ($x = 1; $x <= 10; $x++) {
            $resp[] = Teamleader::crm()->contact()->list([ 'page' => ['number' => $x, 'size' => 100]]);
        }

        foreach($resp as $r){
            foreach($r->data as $t){
                $users [] = $t;
            }
        }
        
        foreach ($users as $u) {
            $emails = $u->emails;
            foreach ($emails as $e) {
                $email = $e->email;
            }
                
            $checkUser = User::where('teamleader_id', $u->id)->first();

            if (!empty($u->tags[0])) {
                if ($u->tags[0] === 'klant') {
                    if (empty($checkUser)) {
                        $newUser = new User();
                        $newUser->email = $email;
                        $newUser->firstname = $u->first_name;
                        $newUser->lastname = $u->last_name;
                        $newUser->teamleader_id = $u->id;
                        $newUser->tag = $u->tags[0];
                        $newUser->save();
                    } else {
                        $user = User::where('teamleader_id', $u->id)->first();
                        $user->email = $email;
                        $user->firstname = $u->first_name;
                        $user->lastname = $u->last_name;
                        $user->teamleader_id = $u->id;
                        $user->tag = $u->tags[0];
                        $user->save();
                    }
                } else {
                    if (!empty($checkUser)) {
                        $checkUser->delete();
                    }
                }

            } elseif (empty($u->tags[0])) {
                if (!empty($checkUser)) {
                    $checkUser->delete();
                }
            }

        }
    }
}
