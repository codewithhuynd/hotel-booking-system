<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class BookingExpiryService
{
    /**
     * Huỷ các booking 'pending' mà host không xác nhận kịp:
     * quá `hotel.pending_expire_hours` kể từ lúc đặt, hoặc đã qua ngày nhận phòng.
     * Booking 'pending' chưa có khoản thanh toán nào nên không cần hoàn tiền.
     */
    public function expireStalePending(): int
    {
        $hours = (int) config('hotel.pending_expire_hours', 48);

        $bookings = Booking::query()
            ->where('status', 'pending')
            ->where(function ($query) use ($hours) {
                $query->where('booked_at', '<=', now()->subHours($hours))
                    ->orWhereDate('check_in_date', '<', today());
            })
            ->with('user')
            ->get();

        foreach ($bookings as $booking) {
            $booking->update(['status' => 'cancelled']);

            notifyUser($booking->user, 'Booking đã tự động huỷ', 'Booking #' . $booking->booking_code . ' chưa được khách sạn xác nhận kịp thời nên đã tự động huỷ. Bạn có thể đặt lại phòng khác.', 'warning', [
                'booking_id' => $booking->id,
                'booking_code' => $booking->booking_code,
            ]);
        }

        return $bookings->count();
    }

    /**
     * Đánh dấu khách không đến (no-show): booking đã xác nhận (đã cọc) nhưng tới
     * hết ngày trả phòng vẫn chưa check-in. Booking bị huỷ và khách sạn giữ tiền cọc.
     */
    public function markNoShows(): int
    {
        $bookings = Booking::query()
            ->where('status', 'confirmed')
            ->whereDate('check_out_date', '<', today())
            ->with(['user', 'payments'])
            ->get();

        foreach ($bookings as $booking) {
            DB::transaction(function () use ($booking) {
                $booking->update(['status' => 'cancelled']);

                foreach ($booking->payments as $payment) {
                    if ($payment->status === 'unpaid') {
                        $payment->update(['status' => 'expired']);
                    }
                }
            });

            notifyUser($booking->user, 'Booking bị huỷ do không nhận phòng', 'Bạn không nhận phòng cho booking #' . $booking->booking_code . ' trong thời gian lưu trú nên booking đã bị huỷ. Tiền cọc không được hoàn lại theo chính sách khách sạn.', 'warning', [
                'booking_id' => $booking->id,
                'booking_code' => $booking->booking_code,
            ]);

            notifyRole('host', 'Khách không đến (no-show)', 'Booking #' . $booking->booking_code . ' đã quá ngày trả phòng mà khách chưa check-in, hệ thống đã tự huỷ.', 'warning', [
                'booking_id' => $booking->id,
                'booking_code' => $booking->booking_code,
            ]);
        }

        return $bookings->count();
    }

    /** Chạy toàn bộ quy tắc tự động huỷ. */
    public function run(): array
    {
        return [
            'pending' => $this->expireStalePending(),
            'no_show' => $this->markNoShows(),
        ];
    }
}
