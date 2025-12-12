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
        // $this->email = $email;
        // $this->submission_type = $submission_type;

        $this->email = 'test@mail.com';
        $this->submissionType = 'Value Test';
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
                    ->subject('Create Philippines Registration Notification')
                    ->view('email.registrationNotif')
                    // ->cc('cc@example.com')
                    // ->bcc(env('EMAIL_ALL_BCC'));
                    ->bcc(explode(',', env('EMAIL_G_ALL_BCC')));
    }
}
