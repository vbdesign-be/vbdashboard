<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Clickup;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Vbdesign\Teamleader\Facade\Teamleader;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    //pagina met lijst met alle projecten 
    public function projects(Request $request)
    {
        $user = Auth::user();

        //als het de eerste keer is dat de gebruiker inlogd, naar het profielpagina sturen
        if (!$user->didLogin) {
            $request->session()->flash('notification', 'Welkom op je dashboard, hieronder kan je je gegevens controleren en veranderen.');
            return redirect('/profiel');
        }

        //projecten uit teamleader halen voor een bepaald bedrijf
        teamleaderController::reAuthTL();
        $resp = Teamleader::crm()->contact()->info($user->teamleader_id);
        $companies = $resp->data->companies;
        
        foreach($companies as $c){
            $company_id = $c->company->id;
            $comps[] = Teamleader::crm()->company()->info($company_id);
        }

        //voor elk bedrijf de projecten eruit filteren
        foreach($comps as $c){
            $data['projects'] = Teamleader::crm()->company()->getProjects($c->data->id)->data;
        }

        //gebruiker redirecten naar de pagina
        return view('projects/projects', $data);
    }

    //detail pagina van een project
    public function detail($id){

        teamleaderController::reAuthTL();
        //project ophalen
        $data['project'] = Teamleader::crm()->company()->getProjectDetail($id)->data;

        //security
        $company_id = $data['project']->customer->id;
        $company = Teamleader::crm()->company()->info($company_id)->data;
        $company_users = Teamleader::crm()->contact()->list(['filter' => ['company_id' => $company_id, 'tags' => [0 => "klant"] ]]);
        foreach($company_users as $u){
            $cUsers = $u;
        }
        foreach($cUsers as $u){
            $user_ids[] = $u->id;
        }
        
        //$check is true als het project bij een bedrijf van de gebruiker hoort
        $check = in_array(Auth::user()->teamleader_id, $user_ids, TRUE);
        if($check){
            return view('projects/projectDetail', $data);
        }else{
            abort(403);
        }
    }

    //pagina met alle bugfixes voor een bepaald project
    public function bugfix($id){
        teamleaderController::reAuthTL();
        //project ophalen
        $data['project'] = Teamleader::crm()->company()->getProjectDetail($id)->data;

        //security
        $company_id = $data['project']->customer->id;
        $company = Teamleader::crm()->company()->info($company_id)->data;
        $company_users = Teamleader::crm()->contact()->list(['filter' => ['company_id' => $company_id, 'tags' => [0 => "klant"] ]]);
        foreach($company_users as $u){
            $users = $u;
        }

        foreach($users as $u){
            $user_ids[] = $u->id;
        }
        
        $check = in_array(Auth::user()->teamleader_id, $user_ids, TRUE);
        //als check false is is het project niet van de gebruiker dus abort
        if(!$check){
            abort(403);
        }

        //alle projecten ophalen
        $clickup = Clickup::find(1);
        $token = $clickup->token;
        $url = 'https://app.clickup.com/api/v2/space/6748104/folder';
        $response = Http::withToken($token)->get($url);
        $folders = json_decode($response->body())->folders;

        //de juiste porjectfolder in clickup gaan halen
        foreach($folders as $folder){
            if($folder->name === $data['project']->title){
                $projectFolder = $folder;
            }
        }
        //als er geen projectfolder is gevonden abort
        if(empty($projectFolder)){
            abort(404);
        }

        //bugfixes uit de clickupfolder halen en toonen
        $url2 = 'https://app.clickup.com/api/v2/list/'.$projectFolder->lists[1]->id.'/task';
        $response2 = Http::withToken($token)->get($url2);
        $bugfixes = json_decode($response2->body())->tasks;
        
        if(!empty($bugfixes)){
            $data['bugfixes'] = $bugfixes;
        }else{
            $data['bugfixes'] = "";
        }

        return view('projects/bugfix', $data); 
    }

    //gebruiker kan bugfix toevoegen
    public function addBugfix(Request $request){
        //checken of alle velden zijn ingevuld
        $credentials = $request->validate([
            'titel' => 'required|max:255',
            'beschrijving' => 'required',
        ]);

        //juiste map zoeken om de bugfix in toe te voegen
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

        //taak creeren van de bugfix in clickup
        $url2 = 'https://app.clickup.com/api/v2/list/'.$projectFolder->lists[1]->id.'/task';
        $body = [
            "name" => $request->input('titel'),
            "description" => $request->input('beschrijving'),
            ];
        
        //clickup toevoegen
        Http::withBody(json_encode($body), 'application/json')->withToken($token)->post($url2);
        return redirect('/project/bugfix/'.$request->input('id'));
    }

    //assets in de drive zetten van een project
    public function addAsset(Request $request){
        //checken of de bestanden wel zijn ingeveuld
        $credentials = $request->validate([
            'bestanden' => 'required',
            
        ]);

        $id = $request->input('project_id');
        teamleaderController::reAuthTL();
        //project ophalen
        $project = Teamleader::crm()->company()->getProjectDetail($id)->data;
        $company = Teamleader::crm()->company()->info($project->customer->id)->data;

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
        foreach($request->file('bestanden') as $bestand){
            Storage::disk("google")->putFileAs($dirAssets['path'], $bestand, $bestand->getClientOriginalName());
        }

        //user laten weten dat het gelukt is
        $request->session()->flash('message', 'De bestanden zijn geüpload');
        return redirect('project/'.$project->id);

        //bron van de drive code
        //https://www.youtube.com/watch?v=ygtawz36Lq0&t=17s
        //https://www.youtube.com/watch?v=dVUGVmJdJ1A&list=PLC-R40l2hJfevz23n59ZGjAXT01OSRa6y
    }

    
}
