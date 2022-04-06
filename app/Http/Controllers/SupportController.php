<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Question;
use DateInterval;
use DateTime;
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
        foreach($tickets as $key => $ticket){
            $status = FreshdeskController::getTicketStatus($ticket->status);
            $body = [
                    $ticket,
                    $status,
                ];
            $data['tickets'][] = $body;
        }
        $data['types'] = FreshdeskController::getTicketType();
        return view('support/tickets', $data);
    }

    public function detailTicket($ticket_id){
        //ticket id ophalen
        $ticket = FreshdeskController::getTicketById($ticket_id);
        if(empty($ticket)){
            abort(403);
        }

        //security
        $requester_id = $ticket->requester_id;
        $contact = FreshdeskController::getUserByEmail(Auth::user()->email);
        if($contact->id !== $requester_id){
            abort(403);
        }
        //dd($ticket);
        //ticket en conversatie ophalen
        $data['ticket'] = $ticket;
        $data['conversation'] = FreshdeskController::getConversationOfTicket($ticket->id);
        $data['status'] = FreshdeskController::getTicketStatus($ticket->status);
        $date = date_create($ticket->created_at);
        $data['date'] = date_format($date,"d/m/Y H:i");
        
        return view('support/ticketsDetail', $data);
    }

    public function addTicket(Request $request){
        //checking credentials
        $credentials = $request->validate([
            'onderwerp' => 'required|max:255',
            'type' => 'required',
            'beschrijving' => 'required',
            'attachment' => 'file|mimes:jpeg,jpg,png,pdf|max:50',
        ]);
        $request->flash();

        $subject = $request->input('onderwerp');
        $type = $request->input('type');
        $summary = $request->input('beschrijving');
        //contactpersoon informatie verkrijgen
        $user = FreshdeskController::getUserByEmail(Auth::user()->email);
        //ticket maken en info invullen(infortie + request)
        //$test = FreshdeskController::makeTicket($summary, $subject, $type, $user->id);
        //dd($test);
        //status message naar de gebruiker

        //redirecten
        return redirect('/support/tickets');
    }

    

    

    
}
