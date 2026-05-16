<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\BookingCancellation;

class BookingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | MY BOOKINGS
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $bookings = Booking::with([
                'room',
                'depositPayment',
                'finalPayment',
            ])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('guest.bookings.index', compact('bookings'));
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW BOOKING FORM
    |--------------------------------------------------------------------------
    */

    public function create(Room $room)
    {
        return view('guest.bookings.create', compact('room'));
    }

    

    /*
    |--------------------------------------------------------------------------
    | STORE BOOKING
    |--------------------------------------------------------------------------
    */


    public function store(Request $request, Room $room)
    {
        $validated = $request->validate([
            'check_in_date' => ['required', 'date', 'after_or_equal:today'],
            'check_out_date' => ['required', 'date', 'after:check_in_date'],
            'guest_count' => ['required', 'integer', 'min:1', 'max:' . $room->capacity],
            'contact_name' => ['required', 'max:255'],
            'contact_phone' => ['required', 'max:20'],
            'contact_email' => ['nullable', 'email'],
            'note' => ['nullable'],
        ]);

        $hasConflict = Booking::where('room_id', $room->id)
            ->whereIn('status', [
                'pending',
                'awaiting_deposit',
                'confirmed',
                'checked_in',
            ])
            ->where(function ($query) use ($validated) {
                $query
                    ->where('check_in_date', '<', $validated['check_out_date'])
                    ->where('check_out_date', '>', $validated['check_in_date']);
            })
            ->exists();

        if ($hasConflict) {
            return back()
                ->withInput()
                ->withErrors([
                    'room' => 'Phòng đã được đặt trong khoảng thời gian này.',
                ]);
        }

        $checkIn = Carbon::parse($validated['check_in_date']);
        $checkOut = Carbon::parse($validated['check_out_date']);
        $days = $checkIn->diffInDays($checkOut);

        $roomPrice = $room->price;
        $totalPrice = $roomPrice * $days;
        $depositAmount = $totalPrice * 0.3;

        Booking::create([
            'booking_code' => 'BK-' . strtoupper(Str::random(8)),
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'guest_count' => $validated['guest_count'],
            'contact_name' => $validated['contact_name'],
            'contact_phone' => $validated['contact_phone'],
            'contact_email' => $validated['contact_email'],
            'room_price' => $roomPrice,
            'total_price' => $totalPrice,
            'deposit_amount' => $depositAmount,
            'note' => $validated['note'],
            'status' => 'pending',
            'booked_at' => now(),
        ]);

        return redirect()
            ->route('guest.bookings.index')
            ->with('success', 'Đặt phòng thành công. Vui lòng chờ host xác nhận.');
    }
}