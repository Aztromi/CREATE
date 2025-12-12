<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserDisapproved extends Mailable
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
        $senderEmail = env('EMAIL_SENDER_EMAIL');
        $senderName = env('EMAIL_SENDER_NAME');
        return $this->from($senderEmail, $senderName)
                    ->subject('Create Philippines Account Registration')
                    ->view('email.disapproved')
                    // ->cc('cc@example.com')
                    // ->bcc(env('EMAIL_ALL_BCC'));
                    ->bcc(explode(',', env('EMAIL_ALL_BCC')));
    }
}
