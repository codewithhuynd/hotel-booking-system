<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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

        if (! in_array($payment->status, ['unpaid', 'pending', 'pending_cash'], true)
            || $payment->booking->status === 'cancelled') {
            return back()->with(
                'error',
                'Payment này không còn nhận minh chứng thanh toán.'
            );
        }

        $request->validate([
            'payment_method_id' => [
                'required',
                Rule::exists('payment_methods', 'id')->where('is_active', true),
            ],
        ], [
            'payment_method_id.required' => 'Vui lòng chọn phương thức thanh toán.',
            'payment_method_id.exists' => 'Phương thức thanh toán không hợp lệ hoặc đã ngừng sử dụng.',
        ]);

        $paymentMethod = PaymentMethod::findOrFail(
            $request->payment_method_id
        );

        $request->validate([
            'proof_image' => [
                $paymentMethod->type !== 'cash' ? 'required' : 'nullable',
                'image',
                'max:2048',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPLOAD ẢNH MINH CHỨNG (chỉ khi có file)
        |--------------------------------------------------------------------------
        */

        // Xoá ảnh minh chứng cũ (nếu có) vì sẽ bị thay bằng ảnh mới hoặc bỏ trống.
        if ($payment->proof_image) {
            Storage::disk('public')->delete($payment->proof_image);
        }

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

            'status' => $status,
        ]);

        notifyRole('host', 'Minh chứng thanh toán mới', 'Khách ' . Auth::user()->full_name . ' đã gửi minh chứng cho ' . $payment->displayTypeLabel() . ' payment #' . $payment->transaction_code . '.', 'info', [
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