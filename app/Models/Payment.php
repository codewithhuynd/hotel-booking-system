<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'transaction_code',
        'deposit_amount',
        'payment_method',
        'status',
        'paid_at',
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
    | HELPERS
    |--------------------------------------------------------------------------
    */

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

    public function canConfirmDeposit(): bool
    {
        return in_array($this->status, [
            'unpaid',
            'pending',
        ], true)
        && ! $this->isOverdue();
    }

    public function displayStatusLabel(): string
    {
        return match ($this->status) {

            'unpaid' => 'Waiting Deposit',

            'pending' => 'Pending',

            'paid' => 'Paid',

            'expired' => 'Expired',

            'refunded' => 'Refunded',

            default => 'Unknown',
        };
    }
}