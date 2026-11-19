<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProofFileController;
use App\Mail\RefundCompletedMail;
use App\Models\Booking;
use App\Models\BookingCancellation;
use App\Models\Payment;
use App\Services\BookingExpiryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public const STATUS_OPTIONS = [
        'pending' => 'Chờ xác nhận',
        'awaiting_deposit' => 'Chờ đặt cọc',
        'confirmed' => 'Đã xác nhận',
        'checked_in' => 'Đã check-in',
        'checked_out' => 'Đã check-out',
        'completed' => 'Hoàn tất',
        'cancelled' => 'Đã hủy',
    ];

    public function index(Request $request, BookingExpiryService $expiryService)
    {
        // Áp dụng quy tắc tự huỷ ngay khi host mở danh sách (phòng khi scheduler chưa chạy).
        $expiryService->run();

        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in(array_keys(self::STATUS_OPTIONS))],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
        ], [
            'to.after_or_equal' => 'Ngày kết thúc phải bằng hoặc sau ngày bắt đầu.',
        ]);

        $bookings = Booking::with([
            'user',
            'room',
            'cancellation',
            'depositPayment',
            'finalPayment',
        ])
            ->when($filters['q'] ?? null, function ($query, string $keyword) {
                $like = '%' . $keyword . '%';

                $query->where(function ($query) use ($like) {
                    $query->where('booking_code', 'like', $like)
                        ->orWhere('contact_name', 'like', $like)
                        ->orWhere('contact_phone', 'like', $like)
                        ->orWhereHas('user', fn ($user) => $user->where('full_name', 'like', $like)->orWhere('email', 'like', $like))
                        ->orWhereHas('room', fn ($room) => $room->where('room_name', 'like', $like)->orWhere('room_code', 'like', $like));
                });
            })
            ->when($filters['status'] ?? null, fn ($query, string $status) => $query->where('status', $status))
            ->when($filters['from'] ?? null, fn ($query, string $from) => $query->whereDate('check_in_date', '>=', $from))
            ->when($filters['to'] ?? null, fn ($query, string $to) => $query->whereDate('check_in_date', '<=', $to))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('host.bookings.index', [
            'bookings' => $bookings,
            'statusOptions' => self::STATUS_OPTIONS,
        ]);
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

        notifyUser($booking->user, 'Booking đã được xác nhận', 'Host đã xác nhận booking #' . $booking->booking_code . '. Vui lòng thanh toán cọc.', 'success', [
            'booking_id' => $booking->id,
            'booking_code' => $booking->booking_code,
            'url' => route('guest.bookings.show', ['booking' => $booking->id]),
        ]);

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

        if ($booking->check_in_date->isFuture()) {
            return back()->with('error', 'Chưa đến ngày nhận phòng (' . $booking->check_in_date->format('d/m/Y') . ').');
        }

        if ($booking->room?->status === 'occupied') {
            return back()->with('error', 'Phòng đang có khách khác lưu trú, chưa thể check-in.');
        }

        $booking->update([
            'status' => 'checked_in',
        ]);

        $booking->room->update([
            'status' => 'occupied',
        ]);

        notifyUser($booking->user, 'Đã check-in thành công', 'Host đã xác nhận bạn đã check-in cho booking #' . $booking->booking_code . '.', 'success', [
            'booking_id' => $booking->id,
            'booking_code' => $booking->booking_code,
            'url' => route('guest.bookings.show', ['booking' => $booking->id]),
        ]);

        return back()->with('success', 'Khách đã nhận phòng thành công.');
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
            'status' => 'cleaning',
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

        notifyUser($booking->user, 'Đã checkout thành công', 'Host đã xác nhận bạn đã checkout cho booking #' . $booking->booking_code . '.', 'info', [
            'booking_id' => $booking->id,
            'booking_code' => $booking->booking_code,
            'url' => route('guest.bookings.show', ['booking' => $booking->id]),
        ]);

        return back()->with('success', 'Check-out thành công. Phòng đã được chuyển sang trạng thái dọn phòng.');
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

            foreach ($booking->payments as $payment) {
                if ($payment->status === 'unpaid') {
                    $payment->update([
                        'status' => 'expired',
                    ]);
                }
            }
        });

        notifyUser($booking->user, 'Booking đã bị hủy', 'Host đã hủy booking #' . $booking->booking_code . '. Vui lòng kiểm tra lý do.', 'warning', [
            'booking_id' => $booking->id,
            'booking_code' => $booking->booking_code,
            'url' => route('guest.bookings.show', ['booking' => $booking->id]),
        ]);

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
            ->store('refund_proofs', ProofFileController::DISK);

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

        try {
            if (! empty($cancellation->booking?->user?->email)) {
                Mail::to($cancellation->booking->user->email)
                    ->send(new RefundCompletedMail($cancellation->fresh()));
            }
        } catch (\Throwable $e) {
            // Keep refund completion logic intact even if email delivery fails.
        }

        return back()->with('success', 'Đã hoàn tiền thành công.');
    }
}
