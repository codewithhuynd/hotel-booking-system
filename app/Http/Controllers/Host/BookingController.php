<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST BOOKINGS
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $bookings = Booking::with([
                'user',
                'room',
            ])
            ->latest()
            ->get();

        return view('host.bookings.index', compact('bookings'));
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW BOOKING DETAIL
    |--------------------------------------------------------------------------
    */

    public function show(Booking $booking)
    {
        $booking->load([
            'user',
            'room',
            'payment',
            'cancellation',
        ]);

        return view('host.bookings.show', compact('booking'));
    }

    /*
    |--------------------------------------------------------------------------
    | CONFIRM BOOKING
    |--------------------------------------------------------------------------
    */

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

    /*
    |--------------------------------------------------------------------------
    | CHECK IN
    |--------------------------------------------------------------------------
    */

    public function checkIn(Booking $booking)
    {
        if ($booking->status !== 'confirmed') {
            return back()->with('error', 'Booking chưa được xác nhận hoặc chưa thanh toán cọc.');
        }

        $booking->update([
            'status' => 'checked_in',
        ]);

        $booking->room->update([
            'status' => 'occupied',
        ]);

        return back()->with('success', 'Guest checked in successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | CHECK OUT
    |--------------------------------------------------------------------------
    */

    public function checkOut(Booking $booking)
    {
        if ($booking->status !== 'checked_in') {
            return back()->with('error', 'Booking chưa check-in.');
        }

        $depositPaid = (float) $booking->payments()
            ->deposit()
            ->where('status', 'paid')
            ->sum('deposit_amount');

        if ($depositPaid <= 0) {
            return back()->with('error', 'Khách chưa thanh toán cọc, không thể checkout.');
        }

        DB::transaction(function () use ($booking, $depositPaid) {
            $booking->update([
                'status' => 'checked_out',
            ]);

            $booking->room->update([
                'status' => 'available',
            ]);

            $remainingAmount = max((float) $booking->total_price - $depositPaid, 0);

            if ($remainingAmount > 0) {
                Payment::firstOrCreate(
                    [
                        'booking_id' => $booking->id,
                        'type' => 'final',
                    ],
                    [
                        'transaction_code' => 'FIN-' . strtoupper(Str::random(10)),
                        'deposit_amount' => $remainingAmount,
                        'payment_method' => 'banking',
                        'status' => 'unpaid',
                        'deposit_deadline' => now()->addHours(config('hotel.final_deadline_hours', 24)),
                    ]
                );
            }
        });

        return back()->with('success', 'Check-out thành công. Đã tạo payment final nếu còn dư.');
    }

    /*
    |--------------------------------------------------------------------------
    | CANCEL BOOKING
    |--------------------------------------------------------------------------
    */

    public function cancel(Booking $booking)
    {
        if (in_array($booking->status, ['checked_in', 'checked_out', 'completed'], true)) {
            return back()->with('error', 'Không thể hủy booking ở trạng thái hiện tại.');
        }

        $booking->update([
            'status' => 'cancelled',
        ]);

        return back()->with('success', 'Booking cancelled successfully.');
    }
}