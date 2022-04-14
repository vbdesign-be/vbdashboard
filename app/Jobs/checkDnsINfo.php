<?php

namespace App\Jobs;

use App\Http\Controllers\cloudflareController;
use App\Http\Controllers\QboxController;
use App\Models\Emailtest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class checkDnsINfo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $resource_code;
    protected $check;
    protected $front;
    protected $password;
    protected $user;
    protected $emailOrder;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($resource_code, $check, $front, $password, $user, $emailOrder)
    {
        $this->resource_code = $resource_code;
        $this->check = $check;
        $this->front = $front;
        $this->password = $password;
        $this->user = $user;
        $this->emailOrder = $emailOrder;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $test = new Emailtest();
        $test->test = "1";
        $test->save();
        sleep(20);
        QboxController::checkDns(strtolower($this->resource_code));
        $test->test = "2";
        $test->save();
        sleep(40);
        $record = QboxController::getDKIM(strtolower($this->resource_code));
        $test->test = "3";
        $test->save();
        cloudflareController::createMXRecord($this->check[0]->id, 1);
        $test->test = "4";
        $test->save();
        cloudflareController::createMXRecord($this->check[0]->id, 2);
        $test->test = "5";
        $test->save();
        cloudflareController::createSPFRecord($this->check[0]->id);
        $test->test = "6";
        $test->save();
        cloudflareController::createDKIMRecord($this->check[0]->id, $record);
        $test->test = "7";
        $test->save();
        cloudflareController::createDMARCRecord($this->check[0]->id);
        $test->test = "8";
        $test->save();
        $newEmail = QboxController::makeEmail($this->front, $this->resource_code, $this->password, $this->user->data->first_name);
        $test->test = "9";
        $test->save();
        QboxController::verifyMX(strtolower($this->resource_code));
        $test->test = "10";
        $test->save();
        $this->emailOrder->status = "active";
        $this->emailOrder->resource_code = $newEmail->resource_code;
        $this->emailOrder->save();          
                    
        
    }
}
