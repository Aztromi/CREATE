<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

// use Illuminate\Support\Facades\Log;

class EmailUserMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $fname;
    public $lname;
    public $email;
    public $msg;

    /**
     * MESSAGE FROM USER TO Website Admin
     * 
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fname, $lname, $email, $msg)
    {
        $this->fname = $fname;
        $this->lname = $lname;
        $this->email = $email;
        $this->msg = $msg;
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
        $mail = $this->from($senderEmail, $senderName)
                    ->subject('CREATEPhilippines User Message')
                    ->view('email.usermailtoadmin')
                    // ->cc('cc@example.com')
                    // ->bcc(env('EMAIL_G_ALL_BCC'));
                    ->bcc(explode(',', env('EMAIL_G_ALL_BCC')));

        // Log::debug('Additional debugging information: ' . json_encode($mail));

        return $mail;
    }
}
