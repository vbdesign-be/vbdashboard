<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function support(){
        return view('support/support');
    }

    public function faq(){
        $faqs = Faq::get();
        $data['faqs'] = $faqs;
        return view('support/faq', $data);
    }

    public function tickets(){
        //lijst met alle tickets filteren op een email van een persoon(oud naar nieuw)
        $email = Auth::user()->email;
        $userFreshdeskId = FreshdeskController::getUserByEmail($email)->id;
        $tickets = FreshdeskController::getTicketsByUser($userFreshdeskId);
        dd($tickets);
        return view('support/tickets');
    }

    public function detailTicket($ticket_id){
        //ticket id ophalen

        //ticket ophalen
        return view('support/ticketsDetail');
    }

    public function addTicket(Request $request){
        //checking credentials
        $credentials = $request->validate([
            'onderwerp' => 'required|max:255',
            'tags' => 'required',
            'beschrijving' => 'required'
        ]);

        $request->flash();

        //connectie maken met freshdesk api

        //contactpersoon informatie verkrijgen

        //ticket maken en info invullen(infortie + request)

        //status message naar de gebruiker

        //redirecten
        return redirect('/support/tickets');
    }

    

    

    
}
