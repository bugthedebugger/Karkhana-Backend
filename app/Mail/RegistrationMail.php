<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationMail extends Mailable
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
            $registrationRoute = $this->redirect . $this->token;
        else
            $registrationRoute = env('APP_URL') . '/register/check/' . $this->token;

        return $this
                ->subject('Karkhana Blog Registration')
                ->view('registration.registration')
                ->with([
                    'registrationRoute' => $registrationRoute,
                ]);
    }
}