<?php

namespace App\Http\Controllers;

use App\Mail\TicketReactionMail;
use App\Models\AttachmentReaction;
use App\Models\Reaction;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    public function getTickets()
    {
        if (Auth::user()->isAgent !== 1) {
            abort(403);
        }

        $data['tickets'] = Ticket::where('agent_id', Auth::id())->orderBy('id', 'desc')->get();
        
        //dd($data['tickets']);
        return view('tickets/tickets', $data);
    }

    public function detailTicket($ticket_id)
    {
        $data['ticket'] = Ticket::find($ticket_id);
        if ($data['ticket']->agent_id !== Auth::id()) {
            abort(403);
        }
        $data['ticket']->isOpen = 1;
        $data['ticket']->save();
        $data['status'] = ["Open", "In behandeling", "Gesloten"];
        return view('tickets/ticketDetail', $data);
    }

    public function getUser($user_id)
    {
        if (Auth::user()->isAgent !== 1) {
            abort(403);
        }

        $data['user'] = User::find($user_id);
        $data['tickets'] = Ticket::where('user_id', $user_id)->orderBy('id', 'desc')->get();
        $data['reactions'] = Reaction::where('user_id', $user_id)->orderBy('id', 'desc')->get();

        $tickets = $data['tickets']->toArray();
        $reactions = $data['reactions']->toArray();
    
        $everything = array_merge($tickets, $reactions);

        $timeLine = collect($everything)->sortBy('created_at')->all();
        return view('tickets/userpage', $data);
    }

    public function statusUpdate(Request $request){
        $status = $request->input('status');
        $ticket_id = $request->input('ticket_id');
         //security
         $ticket = Ticket::find($ticket_id);
         if($ticket->agent_id !== Auth::id()){
             abort(403);
         }
        //update status
        $ticket->status = $status;
        $ticket->save();

        //commentaar
        $request->session()->flash('message', 'Ticket is geupdate');
        
        //redirecten
        return redirect('/ticket/'.$ticket_id);
    }

    public function addReactionAgent(Request $request){
        //checking credentials
        $credentials = $request->validate([
            'reactie' => 'required',
        ]);

        $body = $request->input('reactie');
        $ticket_id = $request->input('ticket_id');

        
        //security
        $ticket = Ticket::find($ticket_id);
        if($ticket->agent_id !== Auth::id()){
            abort(403);
        }

        
        //reactie opslaan
        $reaction = new Reaction();
        $reaction->ticket_id = $ticket_id;
        $reaction->user_id = Auth::id();
        $reaction->text = $body;
        $reaction->save();

        //attachments 
        if (!empty($request->file('attachments'))) {
            foreach ($request->file('attachments') as $attachment) {
                $imageSrc = time().'.'.$attachment->extension();
                $attachment->move(public_path('attachments'), $imageSrc);

                $newAttach = new AttachmentReaction();
                $newAttach->name = $attachment->getClientOriginalName();
                $newAttach->src = $imageSrc;
                $newAttach->reaction_id = $reaction->id;
                $newAttach->save();
                sleep(1);
            }
        }

        //mailtje sturen naar klant dat er een antwoord is gekomen met link
        $data['url'] = env('APP_URL')."/ticket/".$ticket_id;
        $data['user'] = User::find($ticket->user_id);
        Mail::to($ticket->user->email)->send(new TicketReactionMail($data));

        //redirecten
        $request->session()->flash('message', 'Je reactie is opgeslagen');
        return redirect('/ticket/'.$ticket_id);

    }

    
}
