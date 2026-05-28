<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ContactMessage $contactMessage,
        public string $replyMessage,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Phản hồi từ khách sạn - ' . config('app.name', 'Dolphins Hotel'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-reply',
            with: [
                'guestName' => $this->contactMessage->name ?? 'Khách hàng',
                'replyMessage' => $this->replyMessage,
                'originalMessage' => $this->contactMessage->message ?? '',
                'hotelName' => config('app.name', 'Dolphins Hotel'),
            ],
        );
    }
}
