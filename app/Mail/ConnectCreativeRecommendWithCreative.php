<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConnectCreativeRecommendWithCreative extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $looking_for, $professional_types, $project_goals, $creatives)
    {
        $this->name = $name;
        $this->looking_for = $looking_for;
        $this->professional_types = $professional_types;
        $this->project_goals = $project_goals;
        $this->creatives = $creatives;
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
            ->subject('CREATEPhilippines Connect with Creatives Recommendations')
            ->view('email.ccRespondWithCreative', [
                'name' => $this->name,
                'looking_for' => $this->looking_for,
                'professional_types' => $this->professional_types,
                'project_goals' => $this->project_goals,
                'creatives' => $this->creatives

                ])
            ->bcc(explode(',', env('EMAIL_ALL_BCC')));
    }
}
