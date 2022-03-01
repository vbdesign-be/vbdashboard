<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;
use GuzzleHttp\Client;
use MadeITBelgium\TeamLeader\Facade\TeamLeader;
use App\Http\Controllers\teamleaderController;





class DashboardController extends teamleaderController
{
    


    public function test(){


        $test = TeamLeader::crm()->contact()->list();
        dd($test);


    }

    

}
