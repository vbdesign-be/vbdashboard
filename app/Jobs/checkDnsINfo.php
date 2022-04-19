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
        $test->test = "voor check";
        $test->save();
        sleep(20);
        QboxController::checkDns(strtolower($this->resource_code));
        $test->test = "na check";
        $test->save();
        sleep(40);
        $test->test = "na sleep 40";
        $test->save();
        $record = QboxController::getDKIM(strtolower($this->resource_code));
        $test->test = "na dkim";
        $test->save();
        cloudflareController::createMXRecord($this->check[0]->id, 1);
        $test->test = "na mx";
        $test->save();
        cloudflareController::createMXRecord($this->check[0]->id, 2);
        $test->test = "na mx2";
        $test->save();
        cloudflareController::createSPFRecord($this->check[0]->id);
        $test->test = "na spfr";
        $test->save();
        cloudflareController::createDKIMRecord($this->check[0]->id, $record);
        $test->test = "na cdkim";
        $test->save();
        cloudflareController::createDMARCRecord($this->check[0]->id);
        $test->test = "na mark";
        $test->save();
        $newEmail = QboxController::makeEmail($this->front, $this->resource_code, $this->password, $this->user->data->first_name);
        $test->test = "na email";
        $test->save();
        QboxController::verifyMX(strtolower($this->resource_code));
        $test->test = "na verify";
        $test->save();
        $this->emailOrder->status = "active";
        $this->emailOrder->resource_code = $newEmail->resource_code;
        $this->emailOrder->save();          
                    
    }

    
}
