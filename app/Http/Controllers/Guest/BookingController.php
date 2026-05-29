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

    public function show(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $booking->load([
            'room',
            'depositPayment',
            'finalPayment',
            'payments',
            'cancellation',
        ]);

        return view('guest.bookings.show', compact('booking'));
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
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:20'],
            'contact_email' => ['nullable', 'email'],
            'note' => ['nullable', 'string', 'max:1000'],
        ], [
            'check_in_date.required' => 'Vui lòng chọn ngày nhận phòng.',
            'check_in_date.date' => 'Ngày nhận phòng không đúng định dạng.',
            'check_in_date.after_or_equal' => 'Ngày nhận phòng không được trước ngày hôm nay.',

            'check_out_date.required' => 'Vui lòng chọn ngày trả phòng.',
            'check_out_date.date' => 'Ngày trả phòng không đúng định dạng.',
            'check_out_date.after' => 'Ngày trả phòng phải sau ngày nhận phòng.',

            'guest_count.required' => 'Vui lòng nhập số lượng khách.',
            'guest_count.integer' => 'Số lượng khách phải là số nguyên.',
            'guest_count.min' => 'Số lượng khách tối thiểu là 1.',
            'guest_count.max' => 'Số lượng khách không được vượt quá sức chứa phòng (' . $room->capacity . ' khách).',

            'contact_name.required' => 'Vui lòng nhập tên người liên hệ.',
            'contact_name.string' => 'Tên người liên hệ không hợp lệ.',
            'contact_name.max' => 'Tên người liên hệ không được vượt quá 255 ký tự.',

            'contact_phone.required' => 'Vui lòng nhập số điện thoại liên hệ.',
            'contact_phone.string' => 'Số điện thoại không hợp lệ.',
            'contact_phone.max' => 'Số điện thoại không được vượt quá 20 ký tự.',

            'contact_email.email' => 'Email liên hệ không đúng định dạng.',

            'note.string' => 'Ghi chú không hợp lệ.',
            'note.max' => 'Ghi chú không được vượt quá 1000 ký tự.',
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
        $depositPercent = (float) getSetting('deposit_percent', 30);
        $depositAmount = $totalPrice * $depositPercent / 100;

        $booking = Booking::create([
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

        notifyRole('host', 'Yêu cầu đặt phòng mới', 'Khách ' . Auth::user()->full_name . ' vừa tạo booking #' . $booking->booking_code . '.', 'info', [
            'booking_id' => $booking->id,
            'booking_code' => $booking->booking_code,
            'url' => route('host.bookings.index'),
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

        $hasTransferredDeposit =
            $booking->depositPayment &&
            in_array($booking->depositPayment->status, ['pending', 'paid'], true);

        $rules = [
            'reason' => ['required', 'string', 'min:10', 'max:1000', 'regex:/^[\pL\pN\s.,;:!?()\-\/]+$/u'],
        ];

        if ($hasTransferredDeposit) {
            $rules['bank_name'] = ['required', 'string', 'min:3', 'max:255', 'regex:/^[\pL\pN\s\-\.\/()]+$/u'];
            $rules['bank_account_number'] = ['required', 'string', 'min:6', 'max:30', 'regex:/^[0-9A-Za-z\-\/]+$/u'];
            $rules['bank_account_name'] = ['required', 'string', 'min:5', 'max:255', 'regex:/^[\pL\s\.\'-]+$/u'];
        }

        $validated = $request->validate($rules, [
            'reason.required' => 'Vui lòng nhập lý do hủy phòng.',
            'reason.string' => 'Lý do hủy phải là văn bản hợp lệ.',
            'reason.min' => 'Lý do hủy phải có ít nhất 10 ký tự.',
            'reason.max' => 'Lý do hủy không được vượt quá 1000 ký tự.',
            'reason.regex' => 'Lý do hủy chỉ được chứa chữ, số và các ký tự cơ bản như dấu câu, dấu chấm, dấu gạch.',
            'bank_name.required' => 'Vui lòng nhập tên ngân hàng nhận hoàn tiền.',
            'bank_name.string' => 'Tên ngân hàng phải là chuỗi văn bản hợp lệ.',
            'bank_name.min' => 'Tên ngân hàng phải có ít nhất 3 ký tự.',
            'bank_name.max' => 'Tên ngân hàng không được vượt quá 255 ký tự.',
            'bank_name.regex' => 'Tên ngân hàng chỉ được chứa chữ, số, khoảng trắng và các ký tự - . / ().',
            'bank_account_number.required' => 'Vui lòng nhập số tài khoản ngân hàng.',
            'bank_account_number.string' => 'Số tài khoản phải là chuỗi văn bản hợp lệ.',
            'bank_account_number.min' => 'Số tài khoản phải có ít nhất 6 ký tự.',
            'bank_account_number.max' => 'Số tài khoản không được vượt quá 30 ký tự.',
            'bank_account_number.regex' => 'Số tài khoản chỉ được chứa chữ số, chữ cái và các ký tự - /.',
            'bank_account_name.required' => 'Vui lòng nhập tên chủ tài khoản.',
            'bank_account_name.string' => 'Tên chủ tài khoản phải là chuỗi văn bản hợp lệ.',
            'bank_account_name.min' => 'Tên chủ tài khoản phải có ít nhất 5 ký tự.',
            'bank_account_name.max' => 'Tên chủ tài khoản không được vượt quá 255 ký tự.',
            'bank_account_name.regex' => 'Tên chủ tài khoản chỉ được chứa chữ cái, khoảng trắng, dấu chấm, dấu gạch và dấu nháy đơn.',
        ]);

        DB::transaction(function () use ($booking, $validated, $hasTransferredDeposit) {
            BookingCancellation::create([
                'booking_id' => $booking->id,
                'cancelled_by_user_id' => Auth::id(),
                'cancelled_by_type' => 'guest',
                'reason' => $validated['reason'],
                'bank_name' => $hasTransferredDeposit ? $validated['bank_name'] : null,
                'bank_account_number' => $hasTransferredDeposit ? $validated['bank_account_number'] : null,
                'bank_account_name' => $hasTransferredDeposit ? $validated['bank_account_name'] : null,
                'refund_info_submitted_at' => $hasTransferredDeposit ? now() : null,
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

        notifyRole('host', 'Booking bị hủy', 'Khách ' . Auth::user()->full_name . ' đã hủy booking #' . $booking->booking_code . '.', 'warning', [
            'booking_id' => $booking->id,
            'booking_code' => $booking->booking_code,
            'url' => route('host.bookings.index'),
        ]);

        return redirect()
            ->route('guest.bookings.index')
            ->with('success', 'Đã hủy booking thành công.');
    }

    public function submitRefundBank(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$booking->cancellation) {
            return back()->with('error', 'Booking chưa có thông tin hủy.');
        }

        if ($booking->cancellation->refund_completed) {
            return back()->with('error', 'Refund đã hoàn tất.');
        }

        if ($booking->cancellation->cancelled_by_type !== 'host') {
            return back()->with('error', 'Chỉ booking bị host hủy mới cần bổ sung thông tin refund.');
        }

        $hasTransferredDeposit =
            $booking->depositPayment &&
            in_array($booking->depositPayment->status, ['pending', 'paid'], true);

        if (! $hasTransferredDeposit) {
            return back()->with('error', 'Booking này không cần hoàn tiền cọc.');
        }

        $validated = $request->validate([
            'bank_name' => ['required', 'string', 'max:255'],
            'bank_account_number' => ['required', 'string', 'max:255'],
            'bank_account_name' => ['required', 'string', 'max:255'],
        ]);

        $booking->cancellation->update([
            'bank_name' => $validated['bank_name'],
            'bank_account_number' => $validated['bank_account_number'],
            'bank_account_name' => $validated['bank_account_name'],
            'refund_info_submitted_at' => now(),
        ]);

        return back()->with('success', 'Đã cập nhật thông tin nhận refund.');
    }
}