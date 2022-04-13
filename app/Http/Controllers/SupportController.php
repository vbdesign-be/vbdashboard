<?php

namespace App\Http\Controllers;

use App\Models\AttachmentReaction;
use App\Models\AttachmentTicket;
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
        if($ticket->user_id !== Auth::id()){
            abort(403);
        }

        $data['ticket'] = $ticket;
        $data['reactions'] = Reaction::where('ticket_id', $ticket_id)->get();
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
        $ticket->save();

        //attachments
        if(!empty($request->file('attachments'))){
        foreach($request->file('attachments') as $attachment){
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
        return redirect('/support/tickets');
    }

    public function addReactionUser(Request $request){
        //checking credentials
        $credentials = $request->validate([
            'reactie' => 'required',
        ]);

        $body = $request->input('reactie');
        $ticket_id = $request->input('ticket_id');

        
        //security
        $ticket = Ticket::find($ticket_id);
        if($ticket->user_id !== Auth::id()){
            abort(403);
        }

        //reactie opslaan
        $reaction = new Reaction();
        $reaction->ticket_id = $ticket_id;
        $reaction->user_id = Auth::id();
        $reaction->text = $body;
        $reaction->save();

        //attachments 
        foreach($request->file('attachments') as $attachment){
            $imageSrc = time().'.'.$attachment->extension();
            $attachment->move(public_path('attachments'), $imageSrc);

            $newAttach = new AttachmentReaction();
            $newAttach->name = $attachment->getClientOriginalName();
            $newAttach->src = $imageSrc;
            $newAttach->reaction_id = $reaction->id;
            $newAttach->save();
            sleep(1);
        }


        //redirecten
        $request->session()->flash('message', 'Je reactie is opgeslagen');
        return redirect('/support/ticket/'.$ticket_id);

    }

    public function statusUpdate(Request $request){
        $status = $request->input('status');
        $ticket_id = $request->input('ticket_id');
         //security
         $ticket = Ticket::find($ticket_id);
         if($ticket->user_id !== Auth::id()){
             abort(403);
         }
        //update status
        $ticket->status = $status;
        $ticket->save();
        
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
        $attachment = $email->Attachment;

        $word = "<script>";

        if(strpos($body, $word) !== false || strpos($subject, $word) !== false){
            exit;
        }else{
            //kijken of emailadress een klant is van ons
            $user = User::where('email', $sender)->first();
            if(!empty($user)){
                $ticket = new Ticket();
                $ticket->user_id = $user->id;
                $ticket->subject = $subject;
                $ticket->body = $attachment->Content;
                $ticket->status = 'Open';
                $ticket->priority = 'Laag';
                $ticket->type = "Vraag";
                $ticket->agent_id = 1;
                $ticket->save();


                // if(!empty($attachments)){
                //     foreach($attachments as $attachment){

                //         $imageName = rand(11111, 99999) . '_' . time() . '.png';
                //         $base64_str = substr($attachment->content, strpos($attachment->content, ",")+1); // get the image code
                //         $image = base64_decode($base64_str); // decode the image
                //         file_put_contents('/attachments/'.$imageName,$image); // move the image to the desired path with desired name and extension


                //         $newAttach = new AttachmentTicket();
                //         $newAttach->name = $imageName;
                //         $newAttach->src = $imageName;
                //         $newAttach->ticket_id = $ticket->id;
                //         $newAttach->save();
                //         sleep(1);

                //     }
                // }

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

    public function recieveFile(Request $request){
        $code = $request->input('code');
        $encode = base64_decode($code);
        return $encode;
    }
}
