<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingCancellation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with([
                'room',
                'depositPayment',
                'finalPayment',
                'cancellation',
            ])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('guest.bookings.index', compact('bookings'));
    }

    public function create(Room $room)
    {
        return view('guest.bookings.create', compact('room'));
    }

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
            ->whereIn('status', ['pending', 'awaiting_deposit', 'confirmed', 'checked_in'])
            ->where(function ($query) use ($validated) {
                $query->where('check_in_date', '<', $validated['check_out_date'])
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

    public function showCancelForm(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if (in_array($booking->status, ['checked_in', 'checked_out', 'completed', 'cancelled'], true)) {
            return redirect()
                ->route('guest.bookings.index')
                ->with('error', 'Booking này không thể hủy.');
        }

        $booking->load(['room', 'depositPayment', 'finalPayment', 'cancellation']);

        return view('guest.bookings.cancel', compact('booking'));
    }

    public function cancel(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if (in_array($booking->status, ['checked_in', 'checked_out', 'completed', 'cancelled'], true)) {
            return redirect()
                ->route('guest.bookings.index')
                ->with('error', 'Booking này không thể hủy.');
        }

        /*
        |--------------------------------------------------------------------------
        | CHECK DEPOSIT STATUS
        |--------------------------------------------------------------------------
        | pending = guest đã chuyển khoản, đang chờ host xác nhận
        | paid = host đã xác nhận đã nhận tiền
        | unpaid = chưa chuyển khoản
        */
        $hasPaidDeposit =
            $booking->depositPayment &&
            in_array(
                $booking->depositPayment->status,
                ['pending', 'paid'],
                true
            );

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */
        $rules = [
            'reason' => ['required', 'string', 'max:1000'],
        ];

        if ($hasPaidDeposit) {
            $rules['bank_name'] = ['required', 'string', 'max:255'];
            $rules['bank_account_number'] = ['required', 'string', 'max:255'];
            $rules['bank_account_name'] = ['required', 'string', 'max:255'];
        }

        $validated = $request->validate($rules);

        DB::transaction(function () use (
            $booking,
            $validated,
            $hasPaidDeposit
        ) {
            BookingCancellation::create([
                'booking_id' => $booking->id,
                'cancelled_by_user_id' => Auth::id(),
                'reason' => $validated['reason'],

                'bank_name' => $hasPaidDeposit
                    ? $validated['bank_name']
                    : null,

                'bank_account_number' => $hasPaidDeposit
                    ? $validated['bank_account_number']
                    : null,

                'bank_account_name' => $hasPaidDeposit
                    ? $validated['bank_account_name']
                    : null,

                /*
                |--------------------------------------------------------------------------
                | Nếu chưa cọc thì xem như không cần hoàn tiền
                |--------------------------------------------------------------------------
                */
                'refund_completed' => $hasPaidDeposit ? false : true,

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

            /*
            |--------------------------------------------------------------------------
            | Chỉ expire unpaid, KHÔNG đụng pending
            |--------------------------------------------------------------------------
            */
            foreach ($booking->payments as $payment) {
                if ($payment->status === 'unpaid') {
                    $payment->update([
                        'status' => 'expired',
                    ]);
                }
            }
        });

        return redirect()
            ->route('guest.bookings.index')
            ->with('success', 'Đã hủy booking thành công.');
    }
}