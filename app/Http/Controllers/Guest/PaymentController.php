<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Payment;
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

        abort_if($payment->booking->user_id !== Auth::id(), 403);

        return view('guest.payments.show', compact('payment'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPLOAD PAYMENT PROOF
    |--------------------------------------------------------------------------
    */

    public function uploadProof(Request $request, Payment $payment)
    {
        abort_if($payment->booking->user_id !== Auth::id(), 403);

        if ($payment->isPaid()) {
            return back()->with('error', 'Payment đã được xác nhận.');
        }

        $request->validate([
            'proof_image' => ['required', 'image', 'max:2048'],
            'payment_method' => ['required', 'in:cash,banking,momo,vnpay'],
        ]);

        $path = $request->file('proof_image')->store('payment_proofs', 'public');

        $payment->update([
            'proof_image' => $path,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('guest.bookings.index')
            ->with('success', 'Đã gửi minh chứng thanh toán. Vui lòng chờ xác nhận.');
    }
}