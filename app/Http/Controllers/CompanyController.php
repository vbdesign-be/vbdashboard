<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;
use MadeITBelgium\TeamLeader\Facade\TeamLeader;

class CompanyController extends Controller
{
    public function company($id){

        teamleaderController::reAuthTL();

        
        $companyres = TeamLeader::crm()->company()->info($id);

        $company = $companyres->data;

        dd($company);

        return view('company');
    }
}
