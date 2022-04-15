<?php

namespace App\Http\Controllers;

use App\Models\AttachmentReaction;
use App\Models\AttachmentTicket;
use App\Models\Cc;
use App\Models\Emailtest;
use App\Models\Faq;
use App\Models\Question;
use App\Models\Reaction;
use App\Models\Test;
use App\Models\Ticket;
use App\Models\User;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Mime\Email;

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
        $tickets = Ticket::where('user_id', Auth::id())->orderBy('id', 'DESC')->get();
        $data['tickets'] = $tickets;
        return view('support/tickets', $data);
    }

    public function detailTicket($ticket_id)
    {
        //security
        $ticket = Ticket::find($ticket_id);
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        $data['ticket'] = $ticket;
        $data['status'] = ["Open", "In behandeling", "Gesloten"];
        //dd($data['ticket']);
        return view('support/ticketsDetail', $data);
    }

    public function addTicket(Request $request)
    {
        //checking credentials
        $credentials = $request->validate([
            'onderwerp' => 'required|max:255',
            'type' => 'required',
            'beschrijving' => 'required',
        ]);

        $request->flash();

        $subject = $request->input('onderwerp');
        $type = $request->input('type');
        $summary = $request->input('beschrijving');
        

        //ticket maken en info invullen(infortie + request)
        $ticket = new Ticket();
        $ticket->user_id = Auth::id();
        $ticket->subject = $subject;
        $ticket->body = $summary;
        $ticket->status = 'Open';
        $ticket->priority = 'Laag';
        $ticket->type = $type;
        $ticket->agent_id = 1;
        $ticket->isOpen = 0;
        $ticket->save();

        //attachments
        if (!empty($request->file('attachments'))) {
            foreach ($request->file('attachments') as $attachment) {
                $imageSrc = time().'.'.$attachment->extension();
                $attachment->move(public_path('attachments'), $imageSrc);

                $newAttach = new AttachmentTicket();
                $newAttach->name = $attachment->getClientOriginalName();
                $newAttach->src = $imageSrc;
                $newAttach->ticket_id = $ticket->id;
                $newAttach->save();
                sleep(1);
            }
        }


        //status message naar de gebruiker
        $request->session()->flash('message', 'Je support ticket is opgeslagen');
        
        //redirecten
        return redirect('/support/ticket/'.$ticket->id);
    }

    public function addReactionUser(Request $request)
    {
        //checking credentials
        $credentials = $request->validate([
            'reactie' => 'required',
        ]);

        $body = $request->input('reactie');
        $ticket_id = $request->input('ticket_id');

        
        //security
        $ticket = Ticket::find($ticket_id);
        if ($ticket->user_id !== Auth::id()) {
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


        //redirecten
        $request->session()->flash('message', 'Je reactie is opgeslagen');
        return redirect('/support/ticket/'.$ticket_id);
    }

    public function statusUpdate(Request $request)
    {
        $status = $request->input('status');
        $ticket_id = $request->input('ticket_id');
        //security
        $ticket = Ticket::find($ticket_id);
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }
        //update status
        $ticket->status = $status;
        $ticket->save();
        
        $request->session()->flash('message', 'Ticket is geupdate');
        //redirecten
        return redirect('/support/ticket/'.$ticket_id);
    }

    public function recieveEmail(Request $request)
    {
        $test = new Emailtest();
        //mail binnenkrijgen
        $json = file_get_contents('php://input');
        $email = Json_decode($json);
        
        
        $sender = $email->FromFull->Email;
        $subject = $email->Subject;
        $body = $email->HtmlBody;
        $attachments = $email->Attachments;
        $ccs = $email->CcFull;
        

        $word = "<script>";

        if (strpos($body, $word) !== false || strpos($subject, $word) !== false) {
            
            exit;
        } else {
            //kijken of emailadress een klant is van ons
            $user = User::where('email', $sender)->first();
            if (!empty($user)) {
                

                $ticket = new Ticket();
                $ticket->user_id = $user->id;
                $ticket->subject = $subject;
                $ticket->body = $body;
                $ticket->status = 'Open';
                $ticket->priority = 'Laag';
                $ticket->type = "Vraag";
                $ticket->agent_id = 1;
                $ticket->isOpen = 0;
                $ticket->tag = "";
                $ticket->save();

                
                if(!empty($ccs[0])){
                    foreach($ccs as $c){
                        $cc = new Cc();
                        $cc->ticket_id = $ticket->id;
                        $cc->email = $c->Email;
                        $cc->name = $c->Name;
                        $cc->save();
                    }
                }

                if(!empty($attachments[0])){
                    foreach($attachments as $att){

                        $fileName = $att->Name;
                        $fileExtension = substr($fileName, -4);
                        $newFileName = time().$fileExtension;

                        $content = $att->Content;
                        $file = base64_decode($content);
                        $path = public_path("attachments/".$newFileName);
                        file_put_contents($path, $file);

                        $attachment = new AttachmentTicket();
                        $attachment->name = $fileName;
                        $attachment->src = $newFileName;
                        $attachment->ticket_id = $ticket->id;
                        $attachment->save();
                        sleep(1);
                    }
                }

            } else {
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

    
