<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserUnVerified extends Mailable
{
    use Queueable, SerializesModels;

    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->markdown('emails.memberUnverified');

        $senderEmail = env('EMAIL_SENDER_EMAIL');
        $senderName = env('EMAIL_SENDER_NAME');
        return $this->from($senderEmail, $senderName)
                    ->subject('CREATEPhilippines Account Update')
                    ->view('emails.memberUnverified')
                    // ->cc('cc@example.com')
                    // ->bcc(env('EMAIL_ALL_BCC'));
                    ->bcc(explode(',', env('EMAIL_ALL_BCC')));
    }
}
