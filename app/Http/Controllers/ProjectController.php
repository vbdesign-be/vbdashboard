<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Clickup;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use MadeITBelgium\TeamLeader\Facade\TeamLeader;
use App\Models\User;

class ProjectController extends Controller
{
    public function projects(Request $request)
    {
        $user = Auth::user();
        if (!$user->didLogin) {
            $request->session()->flash('notification', 'Welkom op je dashboard, hieronder kan je je gegevens controleren en veranderen.');
            return redirect('/profiel');
        }

        //projecten uit teamleader halen voor een bepaald bedrijf
        teamleaderController::reAuthTL();

        $resp = TeamLeader::crm()->contact()->info($user->teamleader_id);

        $companies = $resp->data->companies;
        
        foreach($companies as $c){
            $company_id = $c->company->id;
            $comps[] = TeamLeader::crm()->company()->info($company_id);
        }

        //voor elk bedrijf de projecten eruit filteren
        

        foreach($comps as $c){
            $data['projects'] = TeamLeader::crm()->company()->getProjects($c->data->id)->data;
        }
        
        return view('projects/projects', $data);
    }


    public function detail($id){

        teamleaderController::reAuthTL();
        //project ophalen
        $data['project'] = TeamLeader::crm()->company()->getProjectDetail($id)->data;

        //bugfixes ophalen
        $clickup = Clickup::find(1);
        $token = $clickup->token;
        
        $url = 'https://app.clickup.com/api/v2/list/180519993/task';

        $response = Http::withToken($token)->get($url);

        $tasks = json_decode($response->body())->tasks;

        $data['bugfixes'] = $tasks;

        return view('projects/projectDetail', $data);
    }

    public function addBugfix(Request $request){
        

        //create task
        $clickup = Clickup::find(1);
        $token = $clickup->token;
        
        $url = 'https://app.clickup.com/api/v2/list/180519993/task';
        $body = [
            "name" => $request->input('titel'),
            "description" => $request->input('beschrijving'),
        ];
       
        Http::withBody(json_encode($body), 'application/json')->withToken($token)->post($url);
        

        

    }


    public function getCompanyId()
    {
        $clickup = Clickup::find(1);
        $token = $clickup->token;
        
        $url = 'https://app.clickup.com/api/v2/list/40397755/task';

        $response = Http::withToken($token)->get($url);

        $tasks = json_decode($response->body())->tasks;
        $data['projects'] = $tasks;
    }
}
