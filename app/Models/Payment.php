<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'type',
        'transaction_code',
        'deposit_amount',
        'payment_method',
        'status',
        'paid_at',
        'proof_image',
        'deposit_deadline',
    ];

    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'paid_at' => 'datetime',
        'deposit_deadline' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeDeposit($query)
    {
        return $query->where('type', 'deposit');
    }

    public function scopeFinal($query)
    {
        return $query->where('type', 'final');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    public function isDeposit(): bool
    {
        return $this->type === 'deposit';
    }

    public function isFinal(): bool
    {
        return $this->type === 'final';
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function isExpired(): bool
    {
        return $this->status === 'expired';
    }

    public function isOverdue(): bool
    {
        return $this->status !== 'paid'
            && $this->deposit_deadline
            && now()->greaterThan($this->deposit_deadline);
    }

    public function displayTypeLabel(): string
    {
        return match ($this->type) {
            'deposit' => 'Đặt cọc',
            'final' => 'Thanh toán cuối',
            default => 'Không xác định',
        };
    }

    public function displayStatusLabel(): string
    {
        return match ($this->status) {
            'unpaid' => 'Chờ đặt cọc',
            'pending' => 'Đang chờ',
            'pending_cash' => 'Chờ thanh toán tiền mặt',
            'cash_on_arrival' => 'Thanh toán khi nhận phòng',
            'paid' => 'Đã thanh toán',
            'expired' => 'Hết hạn',
            'refunded' => 'Đã hoàn tiền',
            default => 'Không xác định',
        };
    }
}