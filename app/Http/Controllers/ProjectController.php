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

        //security
        $company_id = $data['project']->customer->id;
        
        $company = TeamLeader::crm()->company()->info($company_id)->data;
        
        
        $company_users = TeamLeader::crm()->contact()->list(['filter' => ['company_id' => $company_id, 'tags' => [0 => "klant"] ]]);
        foreach($company_users as $u){
            $users = $u;
        }

        foreach($users as $u){
            $user_ids[] = $u->id;
        }
        
        $check = in_array(Auth::user()->teamleader_id, $user_ids, TRUE);
        if($check){
            return view('projects/projectDetail', $data);
        }else{
            abort(403);
        }
        

              
        
    }

    public function bugfix($id){


        teamleaderController::reAuthTL();
        //project ophalen
        $data['project'] = TeamLeader::crm()->company()->getProjectDetail($id)->data;

        //allee projecten ophalen

        $clickup = Clickup::find(1);
        $token = $clickup->token;

        $url = 'https://app.clickup.com/api/v2/space/6748104/folder';

        $response = Http::withToken($token)->get($url);
        $folders = json_decode($response->body())->folders;
        
        
        foreach($folders as $folder){
            if($folder->name === $data['project']->title){
                $projectFolder = $folder;
            }
        }

        if(empty($projectFolder)){
            abort(404);
        }

        $url2 = 'https://app.clickup.com/api/v2/list/'.$projectFolder->lists[1]->id.'/task';
        $response2 = Http::withToken($token)->get($url2);
        $bugfixes = json_decode($response2->body())->tasks;
        
        if(!empty($bugfixes)){
            $data['bugfixes'] = $bugfixes;
        }else{
            $data['bugfixes'] = "";
        }

        //security
        $company_id = $data['project']->customer->id;
        
        $company = TeamLeader::crm()->company()->info($company_id)->data;
        
        
        $company_users = TeamLeader::crm()->contact()->list(['filter' => ['company_id' => $company_id, 'tags' => [0 => "klant"] ]]);
        foreach($company_users as $u){
            $users = $u;
        }

        foreach($users as $u){
            $user_ids[] = $u->id;
        }
        
        $check = in_array(Auth::user()->teamleader_id, $user_ids, TRUE);
        if($check){
            return view('projects/bugfix', $data); 
        }else{
            abort(403);
        }

        
    }

    public function addBugfix(Request $request){
        
        $credentials = $request->validate([
            'titel' => 'required|max:255',
            'beschrijving' => 'required',
        ]);

        //juiste map zoeken
        $clickup = Clickup::find(1);
        $token = $clickup->token;

        $url = 'https://app.clickup.com/api/v2/space/6748104/folder';

        $response = Http::withToken($token)->get($url);
        $folders = json_decode($response->body())->folders;
        
        
        foreach($folders as $folder){
            if($folder->name === $request->input('projectName')){
                $projectFolder = $folder;
            }
        }

        //create task
    
        $url2 = 'https://app.clickup.com/api/v2/list/'.$projectFolder->lists[1]->id.'/task';
        $body = [
            "name" => $request->input('titel'),
            "description" => $request->input('beschrijving'),
            ];

        Http::withBody(json_encode($body), 'application/json')->withToken($token)->post($url2);
        return redirect('/project/bugfix/'.$request->input('id'));

    }

    public function addPhoto(Request $request){
        $id = $request->input('project_id');

        teamleaderController::reAuthTL();
        //project ophalen
        $project = TeamLeader::crm()->company()->getProjectDetail($id)->data;

        $company = TeamLeader::crm()->company()->info($project->customer->id)->data;

        // juiste map van de drive halen
        $folderCompany = $company->name;
        $contentsCompany = collect(Storage::disk("google")->listContents('/', false));
        $dirCompany = $contentsCompany->where('type', '=', 'dir')->where('filename', '=', $folderCompany)->first();

        $folderProject = $project->title;
        $contentsProject = collect(Storage::disk("google")->listContents('/'.$dirCompany['path'], false));
        $dirProject = $contentsProject->where('type', '=', 'dir')->where('filename', '=', $folderProject)->first();

        $folderAssets = "assets";
        $contentsAssets = collect(Storage::disk("google")->listContents('/'.$dirProject['path'], false));
        $dirAssets = $contentsAssets->where('type', '=', 'dir')->where('filename', '=', $folderAssets)->first();

        // fotos opslagen in google
        foreach($request->file('fotos') as $foto){
            // dd($foto->getClientOriginalName());
            Storage::disk("google")->putFileAs($dirAssets['path'], $foto, $foto->getClientOriginalName());
        }

        //user laten weten dat het gelukt is
        $request->session()->flash('message', 'De bestanden zijn geüpload');

        return redirect('project/'.$project->id);

        //https://www.youtube.com/watch?v=ygtawz36Lq0&t=17s
        //https://www.youtube.com/watch?v=dVUGVmJdJ1A&list=PLC-R40l2hJfevz23n59ZGjAXT01OSRa6y
    }

    
}
