<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailPasswordReset extends Mailable
{
    use Queueable, SerializesModels;


    public $token;

    public $receiver;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($to, $input)
    {   
        $this->receiver = $to;
        $this->token = route('password.reset', ['token' => $input]);
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this
        ->to($this->receiver['email'], $this->receiver['name'])
        ->subject("Solicitação troca de senha")
        ->view('Emails.passwordReset');
    }
}
