<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class mailContact extends Mailable
{
    use Queueable, SerializesModels;

    public $receiver;
    public $name;
    
    public $contact;

    public $phone;

    public $subject;

    public $description;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($to, $input)
    {   
        $this->receiver = $to;
        $this->name = $input['name'];
        $this->city = $input['city'];
        $this->phone = $input['phone'];
        $this->mail = $input['mail'];
        $this->subjetc = $input['subject'];
        $this->company = $input['company'];
        $this->description = $input['description'];
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this
        ->to($this->receiver, $this->name)
        ->subject("Nova Mensagem de Contato - " . $this->subject)
        ->view('Emails.contact')
        ->with(['name' => $this->name, 'city' => $this->city, 'phone' => $this->phone, 'mail' => $this->mail, 'company' => $this->company, 'subject' => $this->subject, 'description' => $this->description]);
    }
}
