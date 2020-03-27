<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    private $token;
    private $redirect;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token='', $redirect=null)
    {
        $this->token = $token;
        $this->redirect = $redirect;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (!is_null($this->redirect))
            $resetRoute = $this->redirect . $this->token;
        else
            $resetRoute = env('APP_URL') . '/password-reset/' . $this->token;

        return $this
                ->subject('Password Reset')
                ->view('registration.password-reset')
                ->with([
                    'resetRoute' => $resetRoute,
                ]);
    }
}