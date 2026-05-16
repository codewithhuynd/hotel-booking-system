<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Models\Booking;

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
            'room'
        ])
            ->latest()
            ->get();

        return view(
            'host.bookings.index',
            compact('bookings')
        );
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

        return view(
            'host.bookings.show',
            compact('booking')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CONFIRM BOOKING
    |--------------------------------------------------------------------------
    */

    public function confirm(Booking $booking)
    {
        if ($booking->status !== 'pending') {

            return back()->with(
                'error',
                'Booking không hợp lệ.'
            );
        }

        $booking->update([
            'status' => 'awaiting_deposit'
        ]);

        return back()->with(
            'success',
            'Đã xác nhận booking. Chờ khách đặt cọc.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CHECK IN
    |--------------------------------------------------------------------------
    */

    public function checkIn(Booking $booking)
    {
        if ($booking->status !== 'confirmed') {

            return back()->with(
                'error',
                'Booking chưa được xác nhận.'
            );
        }

        $booking->update([
            'status' => 'checked_in'
        ]);

        $booking->room->update([
            'status' => 'occupied'
        ]);

        return back()->with(
            'success',
            'Guest checked in successfully.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CHECK OUT
    |--------------------------------------------------------------------------
    */

    public function checkOut(Booking $booking)
    {
        /*
    |------------------------------------------------------------------
    | CHECK VALID STATUS
    |------------------------------------------------------------------
    */

        if ($booking->status !== 'checked_in') {

            return back()->with(
                'error',
                'Booking chưa check-in.'
            );
        }

        /*
    |------------------------------------------------------------------
    | UPDATE BOOKING
    |------------------------------------------------------------------
    */

        $booking->update([
            'status' => 'checked_out'
        ]);

        /*
    |------------------------------------------------------------------
    | UPDATE ROOM
    |------------------------------------------------------------------
    */

        $booking->room->update([
            'status' => 'available'
        ]);

        return back()->with(
            'success',
            'Check-out thành công.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CANCEL BOOKING
    |--------------------------------------------------------------------------
    */

    public function cancel(Booking $booking)
    {
        $booking->update([
            'status' => 'cancelled'
        ]);

        return back()->with(
            'success',
            'Booking cancelled successfully.'
        );
    }
}
