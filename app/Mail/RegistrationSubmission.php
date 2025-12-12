<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationSubmission extends Mailable
{
    use Queueable, SerializesModels;

    public $email, $submissionType;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $submissionType)
    {
        $this->email = $email;
        $this->submissionType = $submissionType;
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
            ->view('emails.registrationNotif')
            ->bcc(explode(',', env('EMAIL_G_ALL_BCC')));
    }
}
