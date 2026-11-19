<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'user_id',
        'room_id',
        'check_in_date',
        'check_out_date',
        'guest_count',
        'contact_name',
        'contact_phone',
        'contact_email',
        'room_price',
        'total_price',
        'deposit_amount',
        'note',
        'status',
        'booked_at',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'booked_at' => 'datetime',
    ];

    public function scopeOverlapping(Builder $query, string $checkIn, string $checkOut): Builder
    {
        return $query->where('status', '!=', 'cancelled')
            ->where('check_in_date', '<', $checkOut)
            ->where('check_out_date', '>', $checkIn);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function depositPayment()
    {
        return $this->hasOne(Payment::class)->where('type', 'deposit');
    }

    public function finalPayment()
    {
        return $this->hasOne(Payment::class)->where('type', 'final');
    }

    /** Khách đã chuyển cọc (đang chờ xác nhận hoặc đã xác nhận). */
    public function hasTransferredDeposit(): bool
    {
        return $this->depositPayment
            && in_array($this->depositPayment->status, ['pending', 'paid'], true);
    }

    /** Số ngày còn lại tới ngày nhận phòng (âm nếu đã qua). */
    public function daysUntilCheckIn(): int
    {
        return (int) today()->diffInDays($this->check_in_date, false);
    }

    /**
     * Chính sách huỷ: khách tự huỷ trước ngày nhận phòng ít nhất
     * `hotel.free_cancellation_days` ngày thì được hoàn cọc, muộn hơn thì mất cọc.
     */
    public function isDepositRefundableOnGuestCancel(): bool
    {
        return $this->hasTransferredDeposit()
            && $this->daysUntilCheckIn() >= (int) config('hotel.free_cancellation_days', 3);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function canBeReviewed(): bool
    {
        return in_array($this->status, Review::REVIEWABLE_BOOKING_STATUSES, true);
    }

    public function cancellation()
    {
        return $this->hasOne(BookingCancellation::class);
    }

    public function displayStatusLabel(): string
    {
        return match ($this->status) {
            'pending' => 'Chờ xác nhận',
            'awaiting_deposit' => 'Chờ đặt cọc',
            'confirmed' => 'Đã xác nhận',
            'checked_in' => 'Đã check-in',
            'checked_out' => 'Đã check-out',
            'completed' => 'Hoàn tất',
            'cancelled' => 'Đã hủy',
            default => 'Không xác định',
        };
    }
}
