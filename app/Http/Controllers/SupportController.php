<?php

namespace App\Http\Controllers;

use App\Mail\recievedSupport;
use App\Models\AttachmentReaction;
use App\Models\AttachmentTicket;
use App\Models\Cc;
use App\Models\Emailtest;
use App\Models\Faq;
use App\Models\Notitie;
use App\Models\Question;
use App\Models\Reaction;
use App\Models\Spam;
use App\Models\Status;
use App\Models\Test;
use App\Models\Ticket;
use App\Models\Type;
use App\Models\User;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Mime\Email;

class SupportController extends Controller
{
    //support view laden
    public function support(){
        return view('support/support');
    }

    //faq view laden
    public function faq(){
        $faqs = Faq::get();
        $data['faqs'] = $faqs;
        return view('support/faq', $data);
    }

    //pagina met een lijst van alle tickets voor een bepaalde gebruiker
    public function tickets(){
        //lijst met alle tickets filteren op een email van een persoon(oud naar nieuw)
        $tickets = Ticket::where('user_id', Auth::id())->orderBy('id', 'DESC')->get();
        $data['tickets'] = $tickets;
        $data['types'] = Type::get();
        return view('support/tickets', $data);
    }

    //detail pagina van een support ticket
    public function detailTicket($ticket_id){
        //security, checken of het ticket van de ingelogde persoon is
        $ticket = Ticket::find($ticket_id);
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        $data['ticket'] = $ticket;
        $data['statuses'] = Status::get();
        return view('support/ticketsDetail', $data);
    }

    //support ticket toevoegen
    public function addTicket(Request $request){
        //checken of alle velden zijn ingevuld
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
        $ticket->status_id = 1;
        $ticket->priority_id = 1;
        $ticket->type_id = $type;
        $ticket->agent_id = env('AGENT_ID');
        $ticket->isOpen = 0;
        $ticket->save();

        //attachments
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
                $newAttach->save();
                sleep(1);
            }
        }

        //status message naar de gebruiker
        $request->session()->flash('message', 'Je support ticket is opgeslagen');
        
        //redirecten
        return redirect('/support/ticket/'.$ticket->id);
    }

    //wanneer een gebruiker een reactie plaats op een ticket
    public function addReactionUser(Request $request){
        //checken of alle velden zijn ingevuld
        $credentials = $request->validate([
            'reactie' => 'required',
        ]);

        $body = $request->input('reactie');
        $ticket_id = $request->input('ticket_id');

        //security, checken of het ticket wel van de gebruiker is
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

        //attachments opslaan
        if (!empty($request->file('attachments'))) {
            foreach ($request->file('attachments') as $attachment) {
                $imageSrc = time().'.'.$attachment->extension();
                $attachment->move(public_path('attachments'), $imageSrc);

                //attachment opslaan in database
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

    //wanneer een gebruiker de status van een ticket update
    public function statusUpdate(Request $request){
        $status = $request->input('status');
        $ticket_id = $request->input('ticket_id');

        //security, checken of het ticket wel van de gebruiker is
        $ticket = Ticket::find($ticket_id);
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        //update status
        $ticket->status_id = $status;
        $ticket->save();
        
        //redirecten
        $request->session()->flash('message', 'Ticket is geupdate');
        return redirect('/support/ticket/'.$ticket_id);
    }

    //er komt een emailbinnen via de API(routes/api)
    public function recieveEmail(Request $request){
        //mail binnenkrijgen
        $json = file_get_contents('php://input');
        $email = Json_decode($json);
        
        //de infomatie uit het json object halen
        $sender = $email->FromFull->Email;
        $subject = $email->Subject;
        $body = $email->HtmlBody;
        $attachments = $email->Attachments;
        $ccs = $email->CcFull;
        $text = $email->TextBody;
        
        //checken of er geen <script> in de titel of body van de mail zit.
        $script = "<script>";
        if (strpos($body, $script) !== false || strpos($subject, $script) !== false || strpos($text, $script) !== false) {
            exit;
        } else {
            //kijken naar spam
            $this->checkSpam($sender);

            //kijken of emailadress een klant is van ons
            $user = User::where('email', $sender)->first();
            if (!empty($user)) {
                //checken of de mail geen antwoord of forward is
                $re = "re:";
                $fw = "fw:";
                $fwd = "fwd:";

                //de inkomende email is een reactie op een ticket
                if(strpos(strtolower($subject), $re) !== false){
                    $this->makeEmailReaction($user, $sender, $subject, $body, $attachments, $ccs);
                }

                //de binnenkomende email is een doorgestuurde email
                if(strpos(strtolower($subject), $fwd) !== false || strpos(strtolower($subject), $fw) !== false){
                    $this->handleForward($user ,$sender, $subject, $body, $attachments, $ccs, $text);
                }

                //de binnenkomede email is een gewone email
                if (strpos(strtolower($subject), $re) === false && strpos(strtolower($subject), $fwd) === false && strpos(strtolower($subject), $fw) === false) {
                    $this->makeEmailTicket($user, $sender, $subject, $body, $attachments, $ccs);
                }

            } else {
                //de binnenkomnde mail is een mail van iemand die geen gebruiker is
                //checken of de mail geen antwoord of forward is
                $re = "re:";
                $fw = "fw:";
                $fwd = "fwd:";

                //de inkomende email is een reactie op een ticket
                if(strpos(strtolower($subject), $re) !== false){
                    $this->makeEmailReactionStrange($sender, $subject, $body, $attachments, $ccs);
                }

                //de binnenkomende email is een doorgestuurde email
                if(strpos(strtolower($subject), $fwd) !== false || strpos(strtolower($subject), $fw) !== false){
                    $this->handleForward($user ,$sender, $subject, $body, $attachments, $ccs, $text);
                }

                //de binnenkomede email is een gewone email
                if (strpos(strtolower($subject), $re) === false && strpos(strtolower($subject), $fwd) === false && strpos(strtolower($subject), $fw) === false) {
                    $this->makeEmailTicketStrange($sender, $subject, $body, $attachments, $ccs);
                }
                 
            }

            //de verstuurder van de mail laten weten dat de mail goed ontvangen is.
            Mail::to($sender)->send(new recievedSupport());
        }
    }

    //logica als de mail een doorgestuurd bericht is
    private function handleForward($user ,$sender, $subject, $body, $attachments, $ccs, $text){
        //text opslitsen zodat we de juiste informatie hebben
        $explode = explode("\r\nVan:", $text);
        $explode2 = explode("<", $explode[1]);
        $explode3 = explode(">", $explode2[1]);
        $ogSender = $explode3[0];

        //realsubject
        $split = explode(": ", strtolower($subject));
        $realSubject = $split[1];

        //realticket
        $splitBody = explode("&gt;<br></div><br><br>", $body);
        $realBody = substr($splitBody[1], 0, -24);

        //checken of de verzender een klant is of niet en een ticket maken
        $checkUser = User::where('email', $ogSender)->first();
        if(!empty($checkUser)){
            $ticket_id = $this->makeEmailTicket($checkUser ,$ogSender, $realSubject, $realBody, $attachments, $ccs);
        }else{
            $ticket_id = $this->makeEmailTicketStrange($ogSender, $realSubject, $realBody, $attachments, $ccs);
        }

        //de tekst van de inkomende mail omzetten naar een notitie
        $splitText = explode("\r\n\r\n---------- Forwarded message ---------\r\n", $text);
        $notitie = new Notitie();
        $notitie->text = $splitText[0];
        $notitie->ticket_id = $ticket_id;
        $notitie->save();
        
    }

    //van de mail een ticket maken
    private function makeEmailTicket($user, $sender, $subject, $body, $attachments, $ccs){
        //ticket aanmaken in database
        $ticket = new Ticket();
        $ticket->user_id = $user->id;
        $ticket->subject = $subject;
        $ticket->body = $body;
        $ticket->status_id = 1;
        $ticket->priority_id = 1;
        $ticket->type_id = 1;
        $ticket->agent_id = env('AGENT_ID');
        $ticket->isOpen = 0;
        $ticket->save();

        //checken of de email personen had staan in CC en deze opslaan
        if(!empty($ccs[0])){
            foreach($ccs as $c){
                $cc = new Cc();
                $cc->ticket_id = $ticket->id;
                $cc->email = $c->Email;
                $cc->name = $c->Name;
                $cc->save();
                }
            }
        
        //checken of de email attachments had en deze opslaan
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

        return $ticket->id;
    }

    //binnenkomde email is een reactie
    private function makeEmailReaction($user, $sender, $subject, $body, $attachments, $ccs){
        //user ophalen die de mail heeft gestuurd
        $user = User::where('email', $sender)->first();
        $realSub = substr($subject,  4);  

        //reactie opslaan in database
        if(!empty($user)){
            $ticket = Ticket::where('subject', $realSub)->first();
            $reaction = new Reaction();
            $reaction->ticket_id = $ticket->id;
            $reaction->user_id = $user->id;
            $reaction->text = $body;
            $reaction->save();
        }

        //checken of er attachments waren en deze opslaan
        if(!empty($attachments[0])){
            foreach($attachments as $att){
                $fileName = $att->Name;
                $fileExtension = substr($fileName, -4);
                $newFileName = time().$fileExtension;

                $content = $att->Content;
                $file = base64_decode($content);
                $path = public_path("attachments/".$newFileName);
                file_put_contents($path, $file);

                $attachment = new AttachmentReaction();
                $attachment->name = $fileName;
                $attachment->src = $newFileName;
                $attachment->reaction_id = $reaction->id;
                $attachment->save();
                sleep(1);
            }
        }
    }

    //binnenkomede email is van iemand die geen klant is
    private function makeEmailTicketStrange($sender, $subject, $body, $attachments, $ccs){
        //ticket opslaan in de database
        $ticket = new Ticket();
        $ticket->email = $sender;
        $ticket->subject = $subject;
        $ticket->body = $body;
        $ticket->status_id = 1;
        $ticket->priority_id = 1;
        $ticket->type_id = 1;
        $ticket->agent_id = env('AGENT_ID');
        $ticket->isOpen = 0;
        $ticket->save();

        //checken of er personen in cc stonden en deze opslaan
        if(!empty($ccs[0])){
            foreach($ccs as $c){
                $cc = new Cc();
                $cc->ticket_id = $ticket->id;
                $cc->email = $c->Email;
                $cc->name = $c->Name;
                $cc->save();
            }
        }

        //checken of de mail attachments had en deze opslaan
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

        return $ticket->id;
    }

    //binnenkomende email is een reactie en de verstuurder is geen klant
    private function makeEmailReactionStrange($sender, $subject, $body, $attachments, $ccs){

        $realSub = substr($subject,  4);  
        $ticket = Ticket::where('subject', $realSub)->first();
        $checkCC = Cc::where('email', $sender)->where('ticket_id', $ticket->id)->first();
       
        //checken dat de verstuurder de originele verstuurder is of in cc stond bij de originele mail
        if($sender === $ticket->email || !empty($checkCC)){
            $reaction = new Reaction();
            $reaction->ticket_id = $ticket->id;
            $reaction->email = $sender;
            $reaction->text = $body;
            $reaction->save();

            //kijken of de amail attachments had en deze opslaan
            if(!empty($attachments[0])){
                foreach($attachments as $att){
                    $fileName = $att->Name;
                    $fileExtension = substr($fileName, -4);
                    $newFileName = time().$fileExtension;

                    $content = $att->Content;
                    $file = base64_decode($content);
                    $path = public_path("attachments/".$newFileName);
                    file_put_contents($path, $file);

                    $attachment = new AttachmentReaction();
                    $attachment->name = $fileName;
                    $attachment->src = $newFileName;
                    $attachment->reaction_id = $reaction->id;
                    $attachment->save();
                    sleep(1);
                }
            }

        }else{
            exit;
        }
    }

    //fucntie die checkt of het amiladres van de email niet is opgegeven als spam
    private function checkSpam($sender){
        $spam = Spam::where('email', $sender)->first();
        if(!empty($spam)){
            exit;
        }
    }
}

    
