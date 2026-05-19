<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SHOW PAYMENT PAGE
    |--------------------------------------------------------------------------
    */

    public function show(Payment $payment)
    {
        $payment->load([
            'booking.user',
            'booking.room',
        ]);

        abort_if(
            $payment->booking->user_id !== Auth::id(),
            403
        );

        /*
        |--------------------------------------------------------------------------
        | LẤY DANH SÁCH PHƯƠNG THỨC THANH TOÁN HOST ĐÃ TẠO
        |--------------------------------------------------------------------------
        */

        $paymentMethods = PaymentMethod::where('is_active', true)
            ->orderBy('type')
            ->get();

        return view(
            'guest.payments.show',
            compact('payment', 'paymentMethods')
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
        abort_if(
            $payment->booking->user_id !== Auth::id(),
            403
        );

        if ($payment->isPaid()) {
            return back()->with(
                'error',
                'Payment đã được xác nhận.'
            );
        }

        $request->validate([
            'proof_image' => [
                'required',
                'image',
                'max:2048',
            ],

            'payment_method_id' => [
                'required',
                'exists:payment_methods,id',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPLOAD ẢNH MINH CHỨNG
        |--------------------------------------------------------------------------
        */

        $path = $request
            ->file('proof_image')
            ->store('payment_proofs', 'public');

        /*
        |--------------------------------------------------------------------------
        | LẤY PAYMENT METHOD
        |--------------------------------------------------------------------------
        */

        $paymentMethod = PaymentMethod::findOrFail(
            $request->payment_method_id
        );

        /*
        |--------------------------------------------------------------------------
        | UPDATE PAYMENT
        |--------------------------------------------------------------------------
        */

        $payment->update([
            'proof_image' => $path,

            'payment_method' => $paymentMethod->type,

            'payment_method_id' => $paymentMethod->id,

            'status' => 'pending',
        ]);

        return redirect()
            ->route('guest.bookings.index')
            ->with(
                'success',
                'Đã gửi minh chứng thanh toán.'
            );
    }
}