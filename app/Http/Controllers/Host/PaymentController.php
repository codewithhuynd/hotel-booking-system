<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Mail\PaymentConfirmedMail;
use App\Models\Payment;
use App\Services\DepositPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function __construct(
        protected DepositPaymentService $depositPaymentService
    ) {}

    /*
    |--------------------------------------------------------------------------
    | LIST PAYMENTS
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $expiredCount = $this->depositPaymentService->expireOverduePayments();

        $payments = Payment::with([
                'booking.user',
                'booking.room',
            ])
            ->latest()
            ->get();

        return view(
            'host.payments.index',
            compact('payments', 'expiredCount')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW PAYMENT DETAIL
    |--------------------------------------------------------------------------
    */

    public function show(Payment $payment)
    {
        $payment->load([
            'booking.user',
            'booking.room',
            'booking.payments',
        ]);

        return view(
            'host.payments.show',
            compact('payment')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CONFIRM PAYMENT
    |--------------------------------------------------------------------------
    */

    public function confirm(Request $request, Payment $payment)
    {
        $request->validate([
            'transaction_code' => ['nullable', 'string', 'max:100'],
        ]);

        if ($payment->isPaid()) {
            return back()->with('error', 'Payment đã được xác nhận rồi.');
        }

        if ($payment->isDeposit() && $payment->booking->status !== 'awaiting_deposit') {
            return back()->with('error', 'Booking chưa sẵn sàng cho deposit.');
        }

        if ($payment->isFinal() && $payment->booking->status !== 'checked_out') {
            return back()->with('error', 'Booking chưa checkout để xác nhận final payment.');
        }

        $payment->loadMissing(['booking.user', 'booking.room']);

        $payment->update([
            'status' => 'paid',
            'paid_at' => now(),
            'transaction_code' => $request->transaction_code ?? $payment->transaction_code,
        ]);

        if ($payment->isDeposit()) {
            $payment->booking->update([
                'status' => 'confirmed',
            ]);
        }

        if ($payment->isFinal()) {
            $payment->booking->update([
                'status' => 'completed',
            ]);
        }

        try {
            if (! empty($payment->booking->user?->email)) {
                Mail::to($payment->booking->user->email)->send(new PaymentConfirmedMail($payment));
            }
        } catch (\Throwable $e) {
            // Keep payment confirmation logic intact even if mail delivery fails.
        }

        notifyUser($payment->booking->user, 'Thanh toán đã được xác nhận', 'Payment #' . $payment->transaction_code . ' đã được xác nhận.', 'success', [
            'payment_id' => $payment->id,
            'booking_id' => $payment->booking_id,
            'url' => route('admin.payments.show', ['payment' => $payment->id]),
        ]);

        return back()->with('success', 'Payment confirmed successfully.');
    }
}