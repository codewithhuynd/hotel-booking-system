<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class DepositPaymentService
{
    public function expireOverduePayments(): int
    {
        $payments = Payment::query()
            ->deposit()
            ->whereIn('status', ['unpaid', 'pending'])
            ->whereNotNull('deposit_deadline')
            ->where('deposit_deadline', '<=', now())
            ->with('booking')
            ->get();

        $count = 0;

        foreach ($payments as $payment) {
            DB::transaction(function () use ($payment) {
                $payment->update([
                    'status' => 'expired',
                ]);

                if (
                    $payment->booking
                    && in_array($payment->booking->status, [
                        'pending',
                        'awaiting_deposit',
                    ], true)
                ) {
                    $payment->booking->update([
                        'status' => 'cancelled',
                    ]);
                }
            });

            $count++;
        }

        return $count;
    }
}