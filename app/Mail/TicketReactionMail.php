<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketReactionMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        $email = $this->view('emails.ticketReaction')
                    ->from('laravel@vbdesign.be')
                    ->subject($this->data['subject'])
                    ->with($this->data);

        if(!empty($this->data['attachments'][0])) {
            foreach ($this->data['attachments'] as $att) {
                $email->attach(public_path() .'/attachments/'.$att->src);
            }
        }

        if(!empty($this->data['cc'][0])){
            foreach($this->data['cc'] as $cc){
                $email->cc($cc->email);
            }
        }

        
        
        return $email;
    }
}
