<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Clickup;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class ProjectController extends Controller
{
    public function projects(Request $request)
    {
        $user = Auth::user();
        if (!$user->didLogin) {
            $request->session()->flash('notification', 'Welkom op je dashboard, hieronder kan je je gegevens controleren en veranderen.');
            return redirect('/profiel');
            
        }

        $data['user'] = $user;

        $clickup = Clickup::find(1);
        $token = $clickup->token;
        
        $url = 'https://app.clickup.com/api/v2/list/40397755/task';

        $response = Http::withToken($token)->get($url);

        $data['projects'] = json_decode($response->body())->tasks;

        //projecten filteren op company_id of teamleader_id
        
        return view('projects/projects', $data);
    }
}
