<?php

namespace App\Mail;

use App\Models\PasswordChangeRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordChangeConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public PasswordChangeRequest $request,
        public string $token,
    ) {
    }

    public function build(): self
    {
        $confirmUrl = route('profile.change-password.confirm', ['token' => $this->token]);

        return $this->subject('Xác nhận đổi mật khẩu - Dolphins Hotel')
            ->view('emails.password-change-confirmation')
            ->with([
                'user' => $this->user,
                'confirmUrl' => $confirmUrl,
                'expiresAt' => $this->request->expires_at->format('H:i d/m/Y'),
            ]);
    }
}
