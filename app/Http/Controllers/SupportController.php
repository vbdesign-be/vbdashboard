<?php

namespace App\Http\Controllers;

use App\Models\Emailtest;
use App\Models\Faq;
use App\Models\Question;
use App\Models\Test;
use App\Models\Ticket;
use App\Models\User;
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
        $tickets = Ticket::where('user_id', Auth::id())->get();
        $data['tickets'] = $tickets;
        return view('support/tickets', $data);
    }

    public function detailTicket($ticket_id)
    {
        //security
        $ticket = Ticket::find($ticket_id);
        
        if($ticket->user_id !== Auth::id()){
            abort(403);
        }

        $data['ticket'] = $ticket;
        $data['status'] = ["Open", "In behandeling", "Gesloten"];
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
        
        
        //ticket maken en info invullen(infortie + request)
        $ticket = new Ticket();
        $ticket->user_id = Auth::id();
        $ticket->subject = $subject;
        $ticket->body = $summary;
        $ticket->status = 'Open';
        $ticket->priority = 'Laag';
        $ticket->type = $type;
        $ticket->agent_id = 1;
        $ticket->save();

        //status message naar de gebruiker
        $request->session()->flash('message', 'Je support ticket is opgeslagen');
        
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
        //mail binnenkrijgen
        $json = file_get_contents('php://input');
        $email = Json_decode($json);
        
        $sender = $email->FromFull->Email;
        $subject = $email->Subject;
        $body = $email->HtmlBody;

        $word = "<script>";

        if(strpos($body, $word) !== false){
            exit;
        }else{
            //kijken of emailadress een klant is van ons
            $user = User::where('email', $sender)->first();
            if(!empty($user)){
                $ticket = new Ticket();
                $ticket->user_id = $user->id;
                $ticket->subject = $subject;
                $ticket->body = $body;
                $ticket->status = 'Open';
                $ticket->priority = 'Laag';
                $ticket->type = "Vraag";
                $ticket->agent_id = 1;
                $ticket->save();
            }else{
                $ticket = new Ticket();
                $ticket->email = $sender;
                $ticket->subject = $subject;
                $ticket->body = $body;
                $ticket->status = 'Open';
                $ticket->priority = 'Laag';
                $ticket->type = "Vraag";
                $ticket->agent_id = 1;
                $ticket->save();
            }
        }


        
    }
}
