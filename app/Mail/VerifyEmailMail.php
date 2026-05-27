<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $url;

    public function __construct($user, $url)
    {
        $this->user = $user;
        $this->url = $url;
    }

    public function build()
    {
        return $this->subject('Xác thực email - DolPHPhins Hotel')
                    ->view('emails.verify-email')
                    ->with([
                        'user' => $this->user,
                        'url' => $this->url,
                    ]);
    }
}