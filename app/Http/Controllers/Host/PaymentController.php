<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\DepositPaymentService;
use Illuminate\Http\Request;

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

        return back()->with('success', 'Payment confirmed successfully.');
    }
}