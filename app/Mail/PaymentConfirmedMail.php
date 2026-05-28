<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class PaymentConfirmedMail extends Mailable
{

    public function __construct(public Payment $payment)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Xác nhận thanh toán thành công - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        $booking = $this->payment->booking()->with(['user', 'room'])->first();
        $depositPercent = (float) getSetting('deposit_percent', 30);
        $depositPercentLabel = number_format($depositPercent, 0) . '%';
        $remainingPercentLabel = number_format(max(100 - $depositPercent, 0), 0) . '%';

        $paymentTypeLabel = $this->payment->isDeposit()
            ? 'Thanh toán cọc (' . $depositPercentLabel . ')'
            : 'Thanh toán phần còn lại (' . $remainingPercentLabel . ')';

        return new Content(
            view: 'emails.payment-confirmed',
            with: [
                'guestName' => $booking?->user?->full_name ?? 'Khách hàng',
                'bookingCode' => $booking?->booking_code ?? $this->payment->booking_id,
                'roomName' => $booking?->room?->room_name ?? 'Phòng',
                'paymentTypeLabel' => $paymentTypeLabel,
                'amount' => number_format((float) $this->payment->deposit_amount, 0, ',', '.') . ' VND',
                'status' => 'Thanh toán thành công',
                'confirmedAt' => $this->payment->paid_at?->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i'),
                'hotelName' => config('app.name', 'Dolphins Hotel'),
            ],
        );
    }
}
