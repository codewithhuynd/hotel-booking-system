<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SHOW PAYMENT PAGE
    |--------------------------------------------------------------------------
    */

    public function show(Payment $payment)
    {
        return view(
            'guest.payments.show',
            compact('payment')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPLOAD PAYMENT PROOF
    |--------------------------------------------------------------------------
    */

    public function uploadProof(
        Request $request,
        Payment $payment
    ) {

        $request->validate([

            'proof_image' => [
                'required',
                'image',
                'max:2048',
            ],
        ]);

        $path = $request
            ->file('proof_image')
            ->store(
                'payment_proofs',
                'public'
            );

        $payment->update([

            'proof_image' => $path,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
        ]);

        $payment->booking->update([

            'status' => 'awaiting_deposit',
        ]);

        return redirect()
            ->route('guest.bookings.index')
            ->with(
                'success',
                'Đã gửi minh chứng thanh toán. Vui lòng chờ xác nhận.'
            );
    }
}
