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
        return view('support/tickets');
    }

    public function ticketDetail($ticket_id){
        return view('support/ticketsDetail');
    }

    public function addTicket(Request $request){
        //checking credentials

        //connectie maken met freshdesk api

        //contactpersoon informatie verkrijgen

        //ticket maken en info invullen(infortie + request)

        //status message naar de gebruiker

        //redirecten
    }

    

    

    
}
