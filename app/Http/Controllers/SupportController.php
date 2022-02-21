<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function support(){

        $faqs = Faq::get();
        $data['faqs'] = $faqs;
        return view('support/support', $data);
    }

    public function askQuestion(){

        $data["user"] = Auth::user();
        return view('support/ask', $data);
    }

    public function status(){
        $data['user'] = Auth::user();
        $data["questions"] = Question::where('userid', Auth::id())->get();
        return view('support/status', $data);
    }

    public function store(Request $request){

        //checking
        $credentials = $request->validate([
            'voornaam' => 'required|max:255',
            'familienaam' => 'required|max:255',
            'onderwerp' => 'required|max:255',
            'vraag' => 'required'

        ]);

        $question = new Question();
        $question->userid = $request->input('userid');
        $question->subject = $request->input('onderwerp');
        $question->question = $request->input('vraag');
        $question->save();

        return redirect('/status');


        
    }

    
}
