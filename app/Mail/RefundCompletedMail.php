<?php

namespace App\Mail;

use App\Models\BookingCancellation;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class RefundCompletedMail extends Mailable
{
    public function __construct(public BookingCancellation $cancellation)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Xác nhận hoàn tiền - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        $booking = $this->cancellation->booking()->with(['user', 'room'])->first();
        $refundAmount = 0;

        foreach ($booking?->payments ?? [] as $payment) {
            if (in_array($payment->status, ['paid', 'pending', 'refunded'], true)) {
                $refundAmount += (float) $payment->deposit_amount;
            }
        }

        return new Content(
            view: 'emails.refund-completed',
            with: [
                'guestName' => $booking?->user?->full_name ?? 'Khách hàng',
                'bookingCode' => $booking?->booking_code ?? '—',
                'roomName' => $booking?->room?->room_name ?? 'Phòng',
                'refundAmount' => number_format($refundAmount, 0, ',', '.') . ' VND',
                'bankName' => $this->cancellation->bank_name ?? '—',
                'bankAccountNumber' => $this->cancellation->bank_account_number ?? '—',
                'bankAccountName' => $this->cancellation->bank_account_name ?? '—',
                'transactionCode' => $this->cancellation->refund_transaction_code ?? '—',
                'completedAt' => $this->cancellation->refund_completed_at?->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i'),
                'hotelName' => config('app.name', 'Dolphins Hotel'),
            ],
        );
    }
}
