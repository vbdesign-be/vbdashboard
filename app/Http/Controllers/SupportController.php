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
        $email = Auth::user()->email;
        $userFreshdeskId = FreshdeskController::getUserByEmail($email)->id;
        $tickets = FreshdeskController::getTicketsByUser($userFreshdeskId);
        foreach ($tickets as $key => $ticket) {
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

    public function detailTicket($ticket_id)
    {
        //ticket id ophalen
        $ticket = FreshdeskController::getTicketById($ticket_id);
        if (empty($ticket)) {
            abort(403);
        }

        //security
        $requester_id = $ticket->requester_id;
        $contact = FreshdeskController::getUserByEmail(Auth::user()->email);
        if ($contact->id !== $requester_id) {
            abort(403);
        }
        

        //alle verschillende statusen
        $status = FreshdeskController::getTicketStatusField();
        $data['statusTypes'] = $status;
        //ticket en conversatie ophalen
        $data['ticket'] = $ticket;
        $data['conversation'] = FreshdeskController::getConversationOfTicket($ticket->id);
        $data['status'] = FreshdeskController::getTicketStatus($ticket->status);
        $date = date_create($ticket->created_at);
        $data['date'] = date_format($date, "d/m/Y H:i");
        $data['requester_id'] = $requester_id;
        return view('support/ticketsDetail', $data);
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
        $user = FreshdeskController::getUserByEmail(Auth::user()->email);
        //ticket maken en info invullen(infortie + request)


        
        if(empty($attachment)){
            $check = FreshdeskController::makeTicket($summary, $subject, $type, $user->id);
        }else{
            $check = FreshdeskController::makeTicketWithAttachment($summary, $subject, $type, $user->id, $attachment);
        }


        //status message naar de gebruiker
        if($check) {
            $request->session()->flash('message', 'Het ticket: '.$subject.' wordt nu verwerkt');
        } else {
            $request->session()->flash('message', 'Er ging iets mis');
            
        }
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
        $check = FreshdeskController::createReply($ticket_id, $body, $requester_id);
        dd($check);
        //message naar gebruiker

        //redirecten
    }

    public function statusUpdate(Request $request){
        $status = $request->input('status');
        $ticket_id = $request->input('ticket_id');
         //security
        
         //update status
         $check = FreshdeskController::updateTicketStatus($ticket_id, $status);

         if($check) {
             
            $request->session()->flash('message', 'Het ticket is geupdate');
        } else {
            
            $request->session()->flash('error', 'Er ging iets mis');
        }
        //redirecten
        return redirect('/support/ticket/'.$ticket_id);
    }
}
