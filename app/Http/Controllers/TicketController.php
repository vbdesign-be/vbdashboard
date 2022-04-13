<?php

namespace App\Http\Controllers;

use App\Models\Reaction;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function getTickets(){
        if(Auth::user()->isAgent !== 1){
            abort(403);
        }

        $data['tickets'] = Ticket::where('agent_id', Auth::id())->orderBy('id', 'desc')->get();
        
        //dd($data['tickets']);
        return view('tickets/tickets', $data);
    }
}
