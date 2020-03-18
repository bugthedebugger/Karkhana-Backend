<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DropALineMail extends Mailable
{
    private $name = '';
    private $email = '';
    private $topic = '';
    private $msg = '';
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $topic, $msg)
    {
        $this->name = $name;
        $this->email = $email;
        $this->topic = $topic;
        $this->msg = $msg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                ->subject('Someone dropped a message in our website.')
                ->view('web-message.index')
                ->with([
                    'name' => $this->name,
                    'email' => $this->email,
                    'topic' => $this->topic,
                    'msg' => $this->msg,
                ]);
    }
}