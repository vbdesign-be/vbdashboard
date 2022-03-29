<?php

namespace App\Jobs;

use App\Http\Controllers\CloudflareController;
use App\Http\Controllers\QboxController;
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
        sleep(20);
        QboxController::checkDns(strtolower($this->resource_code));
        sleep(40);
        $record = QboxController::getDKIM(strtolower($this->resource_code));
        CloudflareController::createMXRecord($this->check[0]->id, 1);
        CloudflareController::createMXRecord($this->check[0]->id, 2);
        CloudflareController::createSPFRecord($this->check[0]->id);
        CloudflareController::createDKIMRecord($this->check[0]->id, $record);
        CloudflareController::createDMARCRecord($this->check[0]->id);
        $newEmail = QboxController::makeEmail($this->front, $this->resource_code, $this->password, $this->user->data->first_name);
        QboxController::verifyMX(strtolower($this->resource_code));
        $this->emailOrder->status = "active";
        $this->emailOrder->resource_code = $newEmail->resource_code;
        $this->emailOrder->save();          
                    
        
    }
}
