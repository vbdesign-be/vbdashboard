<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Clickup;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use MadeITBelgium\TeamLeader\Facade\TeamLeader;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

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
        
        return view('projects/projectDetail', $data);
    }

    public function bugfix($id){


        teamleaderController::reAuthTL();
        //project ophalen
        $data['project'] = TeamLeader::crm()->company()->getProjectDetail($id)->data;
    

        //bugfixes ophalen
        $clickup = Clickup::find(1);
        $token = $clickup->token;
        
        $url = 'https://app.clickup.com/api/v2/list/180519993/task';

        $response = Http::withToken($token)->get($url);

        $tasks = json_decode($response->body())->tasks;

        foreach($tasks as $t){
            if($t->custom_fields[0]->value === $data['project']->id){
                $bugfixes[] = $t;
            }
        }
        
        $data['bugfixes'] = $bugfixes;

        return view('projects/bugfix', $data); 
    }

    public function addBugfix(Request $request){
        
        $credentials = $request->validate([
            'titel' => 'required|max:255',
            'beschrijving' => 'required',
        ]);

        //create task
        $clickup = Clickup::find(1);
        $token = $clickup->token;
        
        $url = 'https://app.clickup.com/api/v2/list/180519993/task';
        $body = [
            "name" => $request->input('titel'),
            "description" => $request->input('beschrijving'),
            "check_required_custom_fields" => true,
            "custom_fields" => [[
                "id" => "54d6704f-7ce2-4980-b171-a599fb99ffc3",
                "value" => $request->input('project_id'),
            ]
        ]];

        Http::withBody(json_encode($body), 'application/json')->withToken($token)->post($url);
        return redirect('/project/bugfix/'.$request->input('id'));

    }

    public function addPhoto(Request $request){
        $id = $request->input('project_id');

        teamleaderController::reAuthTL();
        //project ophalen
        $project = TeamLeader::crm()->company()->getProjectDetail($id)->data;
        
        // juiste map van de drive halen
        $folder = $project->title;
        $contents = collect(Storage::disk("google")->listContents('/', false));
        $dir = $contents->where('type', '=', 'dir')->where('filename', '=', $folder)->first(); 

        // fotos opslagen in google
        
            //naam van project plus nummer
        // for($x = 0; $x < count($request->fotos); $x++){
        //     Storage::disk("google")->putFileAs($dir['path'], $request->fotos[$x], $project->title." ".$x.".jpg");
        // }
        
            //naam van de file op de pc van de klant
        foreach($request->file('fotos') as $foto){
            // dd($foto->getClientOriginalName());
            Storage::disk("google")->putFileAs($dir['path'], $foto, $foto->getClientOriginalName());
        }

        
          
        //user laten weten dat het gelukt is
        $request->session()->flash('message', 'De afbeeldingen zijn geüpload');

        return redirect('project/'.$project->id);
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
