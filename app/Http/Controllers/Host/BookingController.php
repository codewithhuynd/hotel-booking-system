<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingCancellation;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with([
            'user',
            'room',
            'cancellation',
            'depositPayment',
            'finalPayment',
        ])
            ->latest()
            ->get();

        return view('host.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load([
            'user',
            'room',
            'depositPayment',
            'finalPayment',
            'payments',
            'cancellation.cancelledBy',
        ]);

        return view('host.bookings.show', compact('booking'));
    }

    public function confirm(Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Booking không hợp lệ.');
        }

        DB::transaction(function () use ($booking) {
            $booking->update([
                'status' => 'awaiting_deposit',
            ]);

            Payment::firstOrCreate(
                [
                    'booking_id' => $booking->id,
                    'type' => 'deposit',
                ],
                [
                    'transaction_code' => 'DEP-' . strtoupper(Str::random(10)),
                    'deposit_amount' => $booking->deposit_amount,
                    'payment_method' => 'banking',
                    'status' => 'unpaid',
                    'deposit_deadline' => now()->addHours(config('hotel.deposit_deadline_hours', 24)),
                ]
            );
        });

        return back()->with('success', 'Đã xác nhận booking. Chờ khách đặt cọc.');
    }

    public function checkIn(Booking $booking)
    {
        if ($booking->status !== 'confirmed') {
            return back()->with('error', 'Booking chưa được xác nhận.');
        }

        $depositPaid = $booking->depositPayment?->status === 'paid';

        if (! $depositPaid) {
            return back()->with('error', 'Khách chưa thanh toán cọc.');
        }

        $booking->update([
            'status' => 'checked_in',
        ]);

        $booking->room->update([
            'status' => 'occupied',
        ]);

        return back()->with('success', 'Guest checked in successfully.');
    }

    public function checkOut(Booking $booking)
    {
        if ($booking->status !== 'checked_in') {
            return back()->with('error', 'Booking chưa check-in.');
        }

        $booking->update([
            'status' => 'checked_out',
        ]);

        $booking->room->update([
            'status' => 'available',
        ]);

        $depositPaid = (float) $booking->payments()
            ->where('type', 'deposit')
            ->where('status', 'paid')
            ->sum('deposit_amount');

        $remaining = max((float) $booking->total_price - $depositPaid, 0);

        if ($remaining > 0) {
            Payment::firstOrCreate(
                [
                    'booking_id' => $booking->id,
                    'type' => 'final',
                ],
                [
                    'transaction_code' => 'FIN-' . strtoupper(Str::random(10)),
                    'deposit_amount' => $remaining,
                    'payment_method' => 'cash',
                    'status' => 'unpaid',
                    'deposit_deadline' => now()->addHours(config('hotel.final_deadline_hours', 24)),
                ]
            );
        }

        return back()->with('success', 'Check-out thành công. Đã tạo payment cuối nếu còn dư.');
    }

    public function cancel(Request $request, Booking $booking)
    {
        if (in_array($booking->status, [
            'checked_in',
            'checked_out',
            'completed',
            'cancelled',
        ], true)) {
            return back()->with('error', 'Không thể hủy booking ở trạng thái hiện tại.');
        }

        $validated = $request->validate([
            'reason' => ['required', 'string', 'max:1000'],
        ]);

        $hasTransferredDeposit =
            $booking->depositPayment &&
            in_array($booking->depositPayment->status, ['pending', 'paid'], true);

        DB::transaction(function () use ($booking, $validated, $hasTransferredDeposit) {
            BookingCancellation::create([
                'booking_id' => $booking->id,
                'cancelled_by_user_id' => Auth::id(),
                'cancelled_by_type' => 'host',
                'reason' => $validated['reason'],
                'refund_completed' => $hasTransferredDeposit ? false : true,
                'cancelled_at' => now(),
            ]);

            $booking->update([
                'status' => 'cancelled',
            ]);

            if ($booking->room) {
                $booking->room->update([
                    'status' => 'available',
                ]);
            }

            foreach ($booking->payments as $payment) {
                if ($payment->status === 'unpaid') {
                    $payment->update([
                        'status' => 'expired',
                    ]);
                }
            }
        });

        return back()->with('success', 'Đã hủy booking.');
    }

    public function refund(Request $request, BookingCancellation $cancellation)
    {
        if ($cancellation->refund_completed) {
            return back()->with('error', 'Refund đã được xử lý rồi.');
        }

        if (
            blank($cancellation->bank_name) ||
            blank($cancellation->bank_account_number) ||
            blank($cancellation->bank_account_name)
        ) {
            return back()->with('error', 'Khách chưa cung cấp thông tin ngân hàng.');
        }

        $validated = $request->validate([
            'refund_transaction_code' => ['required', 'string', 'max:100'],
            'refund_proof_image' => ['required', 'image', 'max:2048'],
        ]);

        $proofPath = $request->file('refund_proof_image')
            ->store('refund_proofs', 'public');

        DB::transaction(function () use ($cancellation, $validated, $proofPath) {
            $cancellation->update([
                'refund_transaction_code' => $validated['refund_transaction_code'],
                'refund_proof_image' => $proofPath,
                'refund_completed' => true,
                'refund_completed_at' => now(),
            ]);

            $booking = $cancellation->booking;

            foreach ($booking->payments as $payment) {
                if (in_array($payment->status, ['pending', 'paid'], true)) {
                    $payment->update([
                        'status' => 'refunded',
                    ]);
                }
            }
        });

        return back()->with('success', 'Đã hoàn tiền thành công.');
    }
}