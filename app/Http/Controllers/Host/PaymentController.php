<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Mail\PaymentConfirmedMail;
use App\Models\Payment;
use App\Services\DepositPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

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

    public const STATUS_OPTIONS = [
        'unpaid' => 'Chờ thanh toán',
        'pending' => 'Chờ xác nhận',
        'pending_cash' => 'Chờ thanh toán tiền mặt',
        'cash_on_arrival' => 'Thanh toán khi nhận phòng',
        'paid' => 'Đã thanh toán',
        'expired' => 'Hết hạn',
        'refunded' => 'Đã hoàn tiền',
    ];

    public const TYPE_OPTIONS = [
        'deposit' => 'Đặt cọc',
        'final' => 'Thanh toán cuối',
    ];

    public function index(Request $request)
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in(array_keys(self::STATUS_OPTIONS))],
            'type' => ['nullable', Rule::in(array_keys(self::TYPE_OPTIONS))],
        ]);

        $expiredCount = $this->depositPaymentService->expireOverduePayments();

        $payments = Payment::with([
                'booking.user',
                'booking.room',
            ])
            ->when($filters['q'] ?? null, function ($query, string $keyword) {
                $like = '%' . $keyword . '%';

                $query->where(function ($query) use ($like) {
                    $query->where('transaction_code', 'like', $like)
                        ->orWhereHas('booking', function ($booking) use ($like) {
                            $booking->where('booking_code', 'like', $like)
                                ->orWhere('contact_name', 'like', $like)
                                ->orWhereHas('user', fn ($user) => $user->where('full_name', 'like', $like)->orWhere('email', 'like', $like));
                        });
                });
            })
            ->when($filters['status'] ?? null, fn ($query, string $status) => $query->where('status', $status))
            ->when($filters['type'] ?? null, fn ($query, string $type) => $query->where('type', $type))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('host.payments.index', [
            'payments' => $payments,
            'expiredCount' => $expiredCount,
            'statusOptions' => self::STATUS_OPTIONS,
            'typeOptions' => self::TYPE_OPTIONS,
        ]);
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
            'url' => route('guest.payments.show', ['payment' => $payment->id]),
        ]);

        return back()->with('success', 'Payment confirmed successfully.');
    }
}