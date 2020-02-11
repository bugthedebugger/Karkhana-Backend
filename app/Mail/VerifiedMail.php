<?php 

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifiedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var Order
     */
    protected $email;
    protected $password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $password)
    {
    	$this->email = $email;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.verified')->with(['email' => $this->email, 'password' => $this->password]);
    }
}
