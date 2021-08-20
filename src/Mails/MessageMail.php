<?php

namespace Ajifatur\FaturCMS\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class MessageMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * int id pelamar
     * @return void
     */
    public function __construct($sender, $receiver, $subject, $message)
    {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->subject = $subject;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Add headers
        $this->withSwiftMessage(function ($message) {
            $message->getHeaders()->addTextHeader('List-Unsubscribe', '<mailto:'.$this->sender.'>');
            $message->getHeaders()->addTextHeader('X-Priority', '2');
            $message->getHeaders()->addTextHeader('X-MSmail-Priority', 'high');
        });
        
        // Set mail
        $this->from($this->sender, setting('site.name'))->markdown('faturcms::email.message')->subject($this->subject)->with([
            'sender' => $this->sender,
            'receiver' => $this->receiver,
            'subject' => $this->subject,
            'message' => $this->message,
        ]);
        
        return $this;
    }
}
