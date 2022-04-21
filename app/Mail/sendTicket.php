<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendTicket extends Mailable
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
        
        $email = $this->view('emails.sendTicket')
                    ->from('laravel@vbdesign.be')
                    ->subject('Fwd: ' . $this->data['ticket']->subject)
                    ->with($this->data);
        
        if (!empty($this->data['ticket']->attachmentsTicket[0])) {
            foreach ($this->data['ticket']->attachmentsTicket as $att) {
                $email->attach(public_path() .'/attachments/'.$att->src);
            }
        }

        return $email;
                    
    }
}
