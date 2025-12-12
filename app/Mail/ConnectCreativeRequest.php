<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConnectCreativeRequest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $senderEmail = env('EMAIL_G_SENDER_EMAIL');
        $senderName = env('EMAIL_G_SENDER_NAME');

        return $this->from($senderEmail, $senderName)
            ->subject('CREATEPhilippines Connect with Creatives Request')
            ->view('email.ccRequest', [
                'email' => $this->email,
            ])
            ->bcc(explode(',', env('EMAIL_ALL_BCC')));
    }
}
