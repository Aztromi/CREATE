<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $name, $email, $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $token)
    {
        $this->name = $name;
        $this->email = $email;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $senderEmail = env('EMAIL_SENDER_EMAIL');
        $senderName = env('EMAIL_SENDER_NAME');
        return $this->from($senderEmail, $senderName)
                    ->subject('CREATEPhilippines E-mail Verification')
                    ->view('email.verify')
                    // ->cc('cc@example.com')
                    // ->bcc(env('EMAIL_ALL_BCC'));
                    ->bcc(explode(',', env('EMAIL_ALL_BCC')));
    }
}
