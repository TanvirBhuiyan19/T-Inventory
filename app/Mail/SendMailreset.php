<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailreset extends Mailable
{
    use Queueable, SerializesModels;
    public $token;
    public $email;
    public $userName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $email, $userName)
    {
        $this->token = $token;
        $this->email = $email;
        $this->userName = $userName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $appName = config('app.name');

        return $this->from(config('mail.from.address'), $appName)
                ->markdown('mail.passwordReset')
                ->with(['token' => $this->token, 'email' => $this->email, 'userName' => $this->userName ])
                ->subject('Password Reset Email' );

    }
}