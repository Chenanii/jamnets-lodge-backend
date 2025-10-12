<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $invitationLink;

    public function __construct($user, $invitationLink)
    {
        $this->user = $user;
        $this->invitationLink = $invitationLink;
    }

    public function build()
    {
        return $this->subject('Account Invitation')
            ->markdown('emails.user.invitation');
    }
}
