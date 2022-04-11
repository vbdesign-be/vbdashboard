<?php

namespace App\Http\Controllers;

use App\Models\Emailtest;
use App\Models\Faq;
use App\Models\Question;
use App\Models\Test;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function support()
    {
        return view('support/support');
    }

    public function faq()
    {
        $faqs = Faq::get();
        $data['faqs'] = $faqs;
        return view('support/faq', $data);
    }

    public function tickets()
    {
        //lijst met alle tickets filteren op een email van een persoon(oud naar nieuw)
        $test = Emailtest::get();
        $data['test'] = $test;
       
        return view('support/tickets', $data);
    }

    public function detailTicket($ticket_id)
    {
        //ticket id ophalen
       
        return view('support/ticketsDetail');
    }

    public function addTicket(Request $request)
    {
        //checking credentials
        $credentials = $request->validate([
            'onderwerp' => 'required|max:255',
            'type' => 'required',
            'beschrijving' => 'required',
            'attachment' => 'file|mimes:jpeg,jpg,png,pdf|max:20000',
        ]);

        $request->flash();
        

        $subject = $request->input('onderwerp');
        $type = $request->input('type');
        $summary = $request->input('beschrijving');
        $attachment = $request->file('attachment');
        
        //contactpersoon informatie verkrijgen
        
        //ticket maken en info invullen(infortie + request)


        
       


        //status message naar de gebruiker
        
        //redirecten
        return redirect('/support/tickets');
    }

    public function addReaction(Request $request){
        //checking credentials
        $credentials = $request->validate([
            'reactie' => 'required',
        ]);

        $body = $request->input('reactie');
        $ticket_id = $request->input('ticket_id');
        $requester_id = $request->input('requester_id');
        
        //reactie toevoegen op ticket freshdesk
        
        //message naar gebruiker

        //redirecten
    }

    public function statusUpdate(Request $request){
        $status = $request->input('status');
        $ticket_id = $request->input('ticket_id');
         //security
        
         //update status
        
        //redirecten
        return redirect('/support/ticket/'.$ticket_id);
    }

    public function recieveEmail(Request $request){
        $json = $request->body();
        $test = new Emailtest();
        $test->test = $json;
        $test->save();

        return "succes";

    }
}
