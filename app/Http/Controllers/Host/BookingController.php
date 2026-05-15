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
        $booking->load('payment');

        if ($booking->payment && in_array($booking->payment->status, ['unpaid', 'pending'], true)) {
            $booking->update(['status' => 'awaiting_deposit']);

            if (! $booking->payment->deposit_deadline) {
                $booking->payment->update([
                    'deposit_deadline' => now()->addHours(config('hotel.deposit_deadline_hours', 24)),
                    'status' => 'pending',
                ]);
            }
        } else {
            $booking->update(['status' => 'confirmed']);
        }

        return back()->with(
            'success',
            'Booking confirmed successfully.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CHECK IN
    |--------------------------------------------------------------------------
    */

    public function checkIn(Booking $booking)
    {
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
        $booking->update([
            'status' => 'checked_out'
        ]);

        $booking->room->update([
            'status' => 'available'
        ]);

        return back()->with(
            'success',
            'Guest checked out successfully.'
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

        $booking->room->update([
            'status' => 'available'
        ]);

        return back()->with(
            'success',
            'Booking cancelled successfully.'
        );
    }
}