<?php

namespace App\Http\Controllers;

use App\Mail\madeTicket;
use App\Mail\sendTicket;
use App\Mail\TicketReactionMail;
use App\Models\AttachmentReaction;
use App\Models\AttachmentTicket;
use App\Models\Cc;
use App\Models\Note;
use App\Models\Notitie;
use App\Models\Priority;
use App\Models\Reaction;
use App\Models\Spam;
use App\Models\Status;
use App\Models\Tag;
use App\Models\Ticket;
use App\Models\Tickets_Tags;
use App\Models\Type;
use App\Models\User;
use Google\Service\DeploymentManager\Resource\Types;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    //pagina met een lijst van alle tickets voor een specifieke agent(momenteel is er maar 1 agent);
    public function getTickets(Request $request){
        //checken of de ingelogde gebruiker een agent is
        if (Auth::user()->isAgent !== 1) {
            abort(403);
        }

        //kijken wat de input van de filter is en deze toepassen
        $filterInput = $request->input('filter');
        switch($filterInput){
            case("priority"):
                $filter = "priority_id";
                $direction = "desc";
                break;
            case('status'):
                $filter = "status_id";
                $direction = "desc";
                break;
            case('type'):
                $filter = "type_id";
                $direction = "desc";
                break;
            default:
                $filter = "id";
                $direction = "desc";
                break;
        }

        $data['tickets'] = Ticket::where('agent_id', Auth::id())->orderBy($filter, $direction)->get();
        $data['filter'] = $filterInput;
        $data['types'] = Type::get();
        $data['priorities'] = Priority::get();
        return view('tickets/tickets', $data);
    }

    //detailpagina van een ticket
    public function detailTicket($ticket_id){
        //checken of de ingelogde gebruiker een agent is
        if (Auth::user()->isAgent !== 1) {
            abort(403);
        }

        //checken of het ticket bij de agent hoort
        $data['ticket'] = Ticket::find($ticket_id);
        if ($data['ticket']->agent_id !== Auth::id()) {
            abort(403);
        }

        $data['ticket']->isOpen = 1;
        $data['ticket']->save();
        $data['reactions'] = Reaction::where('ticket_id', $ticket_id)->orderBy('created_at')->get();
        $data['statuses'] = Status::get();
        $data['priorities'] = Priority::get();
        $data['types'] = Type::get();
        return view('tickets/ticketDetail', $data);
    }

    //detailpagina over de tickets van een bepaalde user
    public function getUser($user_id){
        //checken of de ingelogde gebruiker een agent is
        if (Auth::user()->isAgent !== 1) {
            abort(403);
        }

        $data['user'] = User::find($user_id);

        //alle tickets van een user verzamelen
        $data['tickets'] = Ticket::where('user_id', $user_id)->orderBy('id', 'desc')->get();

        //alle reacties van een gebruiker verzamelen
        foreach($data['tickets'] as $ticket){
            $allReactions[] = Reaction::where('ticket_id', $ticket->id)->get();
        }
        $data['reactions'] = $allReactions[0];

        //alle tickets + reactions verzamelen en filteren op datum voor de tijdlijn
        $tickets = $data['tickets']->toArray();
        $reactions = $data['reactions']->toArray();
        $everything = array_merge($tickets, $reactions);
        $timeLine = collect($everything)->sortByDesc('created_at')->all();
        $data['timeline'] = $timeLine;
        return view('tickets/userpage', $data);
    }

    //status van een ticket updaten
    public function statusUpdate(Request $request){
        //checken of de ingelogde gebruiker wel een agent is
        if (Auth::user()->isAgent !== 1) {
            abort(403);
        }

        //checken of alle informatie is meegegeven
        $credentials = $request->validate([
            'status' => 'required',
            'ticket_id' => 'required',
        ]);

        $status = $request->input('status');
        $ticket_id = $request->input('ticket_id');

         //security, checken of het ticket wel bij de agent hoort
         $ticket = Ticket::find($ticket_id);
         if($ticket->agent_id !== Auth::id()){
             abort(403);
         }

        //update status
        $ticket->status_id = $status;
        $ticket->save();

        //agent laten weten dat het ticket is geupdate
        $request->session()->flash('message', 'Status van het ticket is geupdate');
        
        //redirecten
        return redirect('/ticket/'.$ticket_id);
    }

    //prioriteit van een ticket wijzigen
    public function priorityUpdate(Request $request){
        //checken of de ingelogde gebruiker wel een agent is
        if (Auth::user()->isAgent !== 1) {
            abort(403);
        }

        //checken of alle informatie is meegegeven
        $credentials = $request->validate([
            'priority' => 'required',
            'ticket_id' => 'required',
        ]);

        $priority = $request->input('priority');
        $ticket_id = $request->input('ticket_id');
        
        //security, checken of het ticket wel bij de agent hoort
        $ticket = Ticket::find($ticket_id);
        if($ticket->agent_id !== Auth::id()){
            abort(403);
        }

        //update prioriteit
        $ticket->priority_id = $priority;
        $ticket->save();

        //agent laten weten dat het ticket is geupdate
        $request->session()->flash('message', 'Ticket is geupdate');
        
        //redirecten
        return redirect('/ticket/'.$ticket_id);
    }

    //statuc van een ticket updaten
    public function typeUpdate(Request $request){
        //checken of de ingelogde gebruiker wel een agent is
        if (Auth::user()->isAgent !== 1) {
            abort(403);
        }

        //checken of alle informatie is meegegeven
        $credentials = $request->validate([
            'type' => 'required',
            'ticket_id' => 'required',
        ]);

        $type = $request->input('type');
        $ticket_id = $request->input('ticket_id');

        //security, checken of het ticket wel bij de agent hoort
        $ticket = Ticket::find($ticket_id);
        if($ticket->agent_id !== Auth::id()){
            abort(403);
        }

        //update type
        $ticket->type_id = $type;
        $ticket->save();

        //agent laten weten dat het ticket is geupdate
        $request->session()->flash('message', 'Ticket is geupdate');
        
        //redirecten
        return redirect('/ticket/'.$ticket_id);
    }

    //reactie van de agent toevoegen
    public function addReactionAgent(Request $request){
        //checken of de ingelogde gebruiker wel een agent is
        if (Auth::user()->isAgent !== 1) {
            abort(403);
        }
        //checken of alle velden zijn ingevuld
        $credentials = $request->validate([
            'reactie' => 'required',
        ]);

        $body = $request->input('reactie');
        $ticket_id = $request->input('ticket_id');

        //security, checken of het ticket wel bij de agent hoort
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

        //kijken of er attachments zijn en deze oplaand
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
        $data['body'] = $body;
        $data['subject'] = $ticket->subject;
        $data['attachments'] = AttachmentReaction::where('reaction_id', $reaction->id)->get();
        $data['cc'] = Cc::where('ticket_id', $ticket_id)->get();
        
        if(!empty($ticket->user_id)){
            Mail::to($ticket->user->email)->send(new TicketReactionMail($data));
        }else{
            Mail::to($ticket->email)->send(new TicketReactionMail($data));
        }

        //redirecten
        $request->session()->flash('message', 'Je reactie is opgeslagen');
        return redirect('/ticket/'.$ticket_id);

    }

    //emailadress toevoegen aan spam
    public function spam(Request $request){
        //checken of de ingelogde gebruiker wel een agent is
        if(Auth::user()->isAgent !== 1){
            abort(403);
        }

        //checken of alle velden zijn ingevuld
        $credentials = $request->validate([
            'email' => 'required',
            'ticket_id' => 'required',
        ]);

        //emailadress in spam table opslaan
        $email = $request->input('email');
        $ticket_id = $request->input('ticket_id');
        $spam = new Spam();
        $spam->email = $email;
        $spam->save();

        $request->session()->flash('message', 'emailadres in spam gezet');
        return redirect('/ticket/'.$ticket_id);
    }

    //ticket samenvoegenpagina
    public function samenvoegPage($ticket_id){
        //checken of de ingelogde gebruiker wel een agent is
        if(Auth::user()->isAgent !== 1){
            abort(403);
        }

        $ticket = Ticket::find($ticket_id);
        if(empty($ticket->email)){
            $allTickets = Ticket::where('user_id', $ticket->user->id)->where('id', '!=', $ticket_id)->get();
        }else{
            $allTickets = Ticket::where('email', $ticket->email)->where('id', '!=', $ticket_id)->get();
        }
        
        $data['ticket'] = $ticket;
        $data['allTickets'] = $allTickets;
        return view('tickets/ticketsamenvoeg', $data);
    }

    //2 tickets samenvoegen
    public function ticketsMerge(Request $request){
        //checken of de ingelogde gebruiker wel een agent is
        if(Auth::user()->isAgent !== 1){
            abort(403);
        }

        //checken of er 2 tickets zijn meegestuurd
        $credentials = $request->validate([
            'ticket1' => 'required',
            'ticket2' => 'required',
        ]);

        if(empty($request->input('ticket2'))){
            $request->session()->flash('error', 'Kies hieronder een ticket om samen te voegen');
            return redirect('/ticket/samenvoegen/'.$request->input('ticket1'));
        }

        //de 2 tickets gaan zoeken in de database
        $ticket1 = Ticket::find($request->input('ticket1'));
        $ticket2 = Ticket::find($request->input('ticket2'));

        
        //kijken welke de oudste is
        if($ticket1->created_at < $ticket2->created_at){
            $merged = $this->mergeTickets($ticket1, $ticket2);
        }else{
            $merged = $this->mergeTickets($ticket2, $ticket1);
        }

        $request->session()->flash('message', 'Tickets zijn samengevoegd');
        return redirect('/ticket/'.$merged);
    }

    //fucntie die 2 ticketten samenvoegd
    private function mergeTickets($old, $new){
        //van het nieuw ticket een reactie maken
        $newReaction = new Reaction();
        $newReaction->ticket_id = $old->id;
        if(!empty($new->user_id)){
            $newReaction->user_id = $new->user->id;
        }else{
            $newReaction->email = $new->email;
        }
        $newReaction->text = $new->body;
        $newReaction->created_at = $new->created_at;
        $newReaction->save();

        //alle attachments van dat ticket tot attachment reactie maken
        $allAttachments = $new->attachmentsTicket;
        foreach($allAttachments as $att){
            $newAtt = new AttachmentReaction();
            $newAtt->name = $att->name;
            $newAtt->src = $att->src;
            $newAtt->reaction_id = $newReaction->id;
            $newAtt->save();
        }

        //cc bij het originele ticket zetten
        //checken op dubbel
        $allCC = $new->cc;
        foreach($allCC as $cc){
            $cc->ticket_id = $old->id;
            $checkCC = Cc::where('ticket_id', $old->id)->where('email', $cc->email)->first();
            if(empty($checkCC)){
                $cc->save();
            }
        }

        //tags bij het originele ticket zetten
        //checken op dubbel
        $tags = $new->tickets_tags;
        foreach($tags as $tag){
            $tag->ticket_id = $old->id;
            $checkTag = Tickets_Tags::where('ticket_id', $old->id)->where('tag_id', $tag->tag_id)->first();
            if(empty($checkTag)){
                $tag->save();
            }
            
        }

        //alle reacties een ander ticket id geven
        $allReactions = $new->reactions;
        foreach($allReactions as $reaction){
            $reaction->ticket_id = $old->id;
            $reaction->save();
        }

        //notitie samenvoegen
        $notitie = $new->notitie;
        $oldNotitie = $old->notitie;
        if(!empty($oldNotitie) && !empty($notitie)){
            $mergerNotitie = $oldNotitie->text . " ||| " . $notitie->text;
            $oldNotitie->text = $mergerNotitie;
            $oldNotitie->save();
            $notitie->delete();
        }elseif(!empty($notitie)){
            $newNotitie = new Notitie();
            $newNotitie->ticket_id = $old->id;
            $newNotitie->text = $notitie->text;
            $newNotitie->save();
            $notitie->delete();
        }
        
        //new ticket verwijderen
        $new->delete();
        return $old->id;
    }

    //het verwijderen van een ticket
    public function deleteTicket(Request $request){
        //checken of de ingelogde gebruiker wel een agent is
        if(Auth::user()->isAgent !== 1){
            abort(403);
        }

        //checken of alle velden zijn ingevuld
        $credentials = $request->validate([
            'ticket_id' => 'required',
        ]);

        //ticket zoeken en verwijderen
        $ticket = Ticket::find($request->input('ticket_id'));
        $ticket->delete();

        $request->session()->flash('message', 'Ticket nr: '.$request->input('ticket_id').' is verwijderd');
        return redirect('/tickets');
    }

    //ticket doorsturen naar iemand
    public function ticketSend(Request $request){
        //checken of de ingelogde gebruiker wel een agent is
        if(Auth::user()->isAgent !== 1){
            abort(403);
        }

        //checken of alle velden zijn ingevuld
        $credentials = $request->validate([
            'email' => 'required|email',
            'ticket_id' => 'required'
        ]);

        $email = $request->input('email');
        $ticket_id = $request->input('ticket_id');

        //ticket ophalen
        $ticket = Ticket::find($ticket_id);

        //kijken of email niet gelijk is aan de originele sender van het ticket
        if(!empty($ticket->user_id) && $ticket->user->email === $email){
            $request->session()->flash('error', 'Email kan niet het originele adress zijn');
            return redirect('/ticket/'.$ticket_id);
        }

        if(!empty($ticket->email) && $ticket->email === $email){
            $request->session()->flash('error', 'Email kan niet het originele adress zijn');
            return redirect('/ticket/'.$ticket_id);
        }

        $data['ticket'] = $ticket;

        //mail versturen met het originele ticket in
        if(!empty($ticket->user_id)){
            $data['email'] = $ticket->user->email;
            Mail::to($email)->send(new sendTicket($data));
        }else{
            $data['email'] = $ticket->email;
            Mail::to($email)->send(new sendTicket($data));
        }

        $request->session()->flash('message', 'Email succesvol doorgestuurd');
        return redirect('/ticket/'.$ticket_id);
    }

    //user van het ticket wijzigen
    public function changeUser(Request $request){
        //checken of de ingelogde gebruiker wel een agent is
        if(Auth::user()->isAgent !== 1){
            abort(403);
        }

        //checking credentials
        $credentials = $request->validate([
            'email' => 'required|email',
            'ticket_id' => 'required'
        ]);

        $email = $request->input('email');
        $ticket = Ticket::find($request->input('ticket_id'));
        $checkUser = User::where('email', $email)->first();
        
        //checken of het ticket al reacties heeft => anders moet wijzigen onmogelijk zijn
        if(!empty($ticket->reactions[0])){
            $request->session()->flash('error', 'Kan afzender niet wijzigen omdat ticket reacties heeft');
            return redirect('/ticket/'. $ticket->id);
        }

        if(!empty($checkUser)){
            $ticket->user_id = $checkUser->id;
            $ticket->email = null;
            $ticket->save();
        }else{
            $ticket->email = $email;
            $ticket->user_id = null;
            $ticket->save();
        }

        $request->session()->flash('message', 'Afzender is succesvol gewijzigd');
        return redirect('/ticket/'. $ticket->id);
    }

    //agent die een ticket toevoegt voor een klant
    public function ticketAdd(Request $request){
        //checken of de ingelogde gebruiker wel een agent is
        if(Auth::user()->isAgent !== 1){
            abort(403);
        }

        //checking credentials
        $credentials = $request->validate([
            'klant' => 'required|email',
            'type' => 'required',
            'onderwerp' => 'required|max:255',
            'prioriteit' => 'required',
            'beschrijving' => 'required'
        ]);

        $client = $request->input('klant');
        $type = $request->input('type');
        $subject = $request->input('onderwerp');
        $priority = $request->input('prioriteit');
        $tags = $request->input('tags');
        $summary = $request->input('beschrijving');

        //de juiste klant ophalen

        $customers = User::get();
        foreach($customers as $c){
            if($c->email === $client){
                $client = $c;
            }
        }
        
        //ticket maken en info invullen(infortie + request)
        $ticket = new Ticket();
        if(!empty($client->email)){
            $ticket->user_id = $client->id;
        }else{
            $ticket->email = $client;
        }
        $ticket->subject = $subject;
        $ticket->body = $summary;
        $ticket->status_id = 2;
        $ticket->priority_id = $priority;
        $ticket->type_id = $type;
        $ticket->agent_id = Auth::id();
        $ticket->isOpen = 0;
        // $ticket->save();

        //tags opslaan
        $tags = explode(', ', $tags);
        foreach ($tags as $tag) {
            $oldTag = Tag::where('name', $tag)->first();
            if (empty($oldTag)) {
                $newTag = new Tag();
                $newTag->name = $tag;
                // $newTag->save();
                $ticketsTags = new Tickets_Tags();
                $ticketsTags->ticket_id = $ticket->id;
                $ticketsTags->tag_id = $newTag->id;
                // $ticketsTags->save();
            } else {
                $checkTags = Tickets_Tags::where('tag_id', $oldTag->id)->where('ticket_id', $ticket->id)->first();
                if (empty($checkTags)) {
                    $ticketsTags = new Tickets_Tags();
                    $ticketsTags->ticket_id = $ticket->id;
                    $ticketsTags->tag_id = $oldTag->id;
                    // $ticketsTags->save();
                }
            }
        }

        //attachments opslaan
        if (!empty($request->file('attachments'))) {
            foreach ($request->file('attachments') as $attachment) {
                //attachment in de public folder plaatsen
                $imageSrc = time().'.'.$attachment->extension();
                $attachment->move(public_path('attachments'), $imageSrc);

                //attachment opslaan
                $newAttach = new AttachmentTicket();
                $newAttach->name = $attachment->getClientOriginalName();
                $newAttach->src = $imageSrc;
                $newAttach->ticket_id = $ticket->id;
                // $newAttach->save();
                sleep(1);
            }
        }
        
        //mail sturen naar de klant in kwestie
        $data['firstname'] = Auth::user()->firstname;
        if(!empty($client->email)){
            Mail::to($client->email)->send(new madeTicket($data));
        }else{
            Mail::to($client)->send(new madeTicket($data));
        }
       
        //status message naar de gebruiker
        $request->session()->flash('message', 'Het ticket is opgeslagen');

        //redirecten
        return redirect('/ticket/'.$ticket->id);
    }
}
