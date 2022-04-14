<?php

namespace App\Http\Controllers;

use App\Models\Reaction;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $data['status'] = ["Open", "In behandeling", "Gesloten"];
        return view('tickets/ticketDetail', $data);
    }

    public function getUser($user_id)
    {
        if (Auth::user()->isAgent !== 1) {
            abort(403);
        }

        $data['user'] = User::find($user_id);
        $data['tickets'] = Ticket::where('user_id', $user_id)->get();

        return view('tickets/userpage', $data);
    }
}
