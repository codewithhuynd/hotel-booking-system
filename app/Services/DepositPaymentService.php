<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class DepositPaymentService
{
    /*
    |--------------------------------------------------------------------------
    | CONFIRM DEPOSIT
    |--------------------------------------------------------------------------
    */

    public function confirmDeposit(
        Payment $payment,
        ?string $transactionCode = null
    ): void {

        if ($payment->isPaid()) {
            throw new InvalidArgumentException(
                'Payment already confirmed.'
            );
        }

        if ($payment->isOverdue()) {
            throw new InvalidArgumentException(
                'Deposit payment expired.'
            );
        }

        DB::transaction(function () use (
            $payment,
            $transactionCode
        ) {

            $payment->update([
                'status' => 'paid',
                'paid_at' => now(),
                'transaction_code' => $transactionCode,
            ]);

            $payment->booking->update([
                'status' => 'confirmed',
            ]);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | EXPIRE OVERDUE PAYMENTS
    |--------------------------------------------------------------------------
    */

    public function expireOverduePayments(): int
    {
        $payments = Payment::whereIn('status', [
                'unpaid',
                'pending',
            ])
            ->where('deposit_deadline', '<=', now())
            ->get();

        $count = 0;

        foreach ($payments as $payment) {

            DB::transaction(function () use ($payment) {

                $payment->update([
                    'status' => 'expired',
                ]);

                $payment->booking->update([
                    'status' => 'cancelled',
                ]);

                if ($payment->booking->room) {

                    $payment->booking->room->update([
                        'status' => 'available',
                    ]);
                }
            });

            $count++;
        }

        return $count;
    }
}