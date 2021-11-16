<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user, $redirectUrl, $token;

    public function __construct($user, $redirectUrl, $token)
    {
        $this->user = $user;
        $this->redirectUrl = $redirectUrl;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('EmailView.Reset')->with(['user'=>$this->user,'token'=>$this->token,'redirectUrl'=>$this->redirectUrl]);
    }
}
