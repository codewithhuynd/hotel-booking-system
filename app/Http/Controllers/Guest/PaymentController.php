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
                'Thanh toán đã được xác nhận.'
            );
        }

        $paymentMethod = PaymentMethod::findOrFail(
            $request->payment_method_id
        );

        $rules = [
            'payment_method_id' => [
                'required',
                'exists:payment_methods,id',
            ],
        ];

        if ($paymentMethod->type !== 'cash') {
            $rules['proof_image'] = [
                'required',
                'image',
                'max:2048',
            ];
        } else {
            $rules['proof_image'] = [
                'nullable',
                'image',
                'max:2048',
            ];
        }

        $request->validate($rules);

        /*
        |--------------------------------------------------------------------------
        | UPLOAD ẢNH MINH CHỨNG (chỉ khi có file)
        |--------------------------------------------------------------------------
        */

        $path = null;

        if ($request->hasFile('proof_image')) {
            $path = $request
                ->file('proof_image')
                ->store('payment_proofs', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE PAYMENT
        |--------------------------------------------------------------------------
        */

        $status = $paymentMethod->type === 'cash'
            ? 'pending_cash'
            : 'pending';

        $payment->update([
            'proof_image' => $path,

            'payment_method' => $paymentMethod->type,

            'payment_method_id' => $paymentMethod->id,

            'status' => $status,
        ]);

        notifyRole('host', 'Minh chứng thanh toán mới', 'Khách ' . Auth::user()->full_name . ' đã gửi minh chứng cho ' . $payment->displayTypeLabel() . ' #' . $payment->transaction_code . '.', 'info', [
            'payment_id' => $payment->id,
            'booking_id' => $payment->booking_id,
            'url' => route('host.payments.index'),
        ]);

        return redirect()
            ->route('guest.bookings.index')
            ->with(
                'success',
                'Đã gửi minh chứng thanh toán.'
            );
    }
}