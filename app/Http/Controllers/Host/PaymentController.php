<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\DepositPaymentService;
use Illuminate\Http\Request;
use InvalidArgumentException;

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
        $expiredCount =
            $this->depositPaymentService
                ->expireOverduePayments();

        $payments = Payment::with([
                'booking.user',
                'booking.room',
            ])
            ->latest()
            ->get();

        return view(
            'host.payments.index',
            compact(
                'payments',
                'expiredCount'
            )
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
        ]);

        return view(
            'host.payments.show',
            compact('payment')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CONFIRM DEPOSIT
    |--------------------------------------------------------------------------
    */

    public function confirm(
        Request $request,
        Payment $payment
    ) {

        $validated = $request->validate([
            'transaction_code' => [
                'nullable',
                'string',
                'max:100',
            ],
        ]);

        try {

            $this->depositPaymentService
                ->confirmDeposit(
                    $payment,
                    $validated['transaction_code']
                        ?? null
                );

        } catch (
            InvalidArgumentException $exception
        ) {

            return back()->with(
                'error',
                $exception->getMessage()
            );
        }

        return back()->with(
            'success',
            'Deposit confirmed successfully.'
        );
    }
}