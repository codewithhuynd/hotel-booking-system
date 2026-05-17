<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingCancellation extends Model
{
    protected $fillable = [
        'booking_id',
        'cancelled_by_user_id',
        'cancelled_by_type',
        'reason',
        'cancelled_at',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
        'refund_info_submitted_at',
        'refund_completed',
        'refund_completed_at',
        'refund_transaction_code',
        'refund_proof_image',
    ];

    protected $casts = [
        'refund_completed' => 'boolean',
        'cancelled_at' => 'datetime',
        'refund_info_submitted_at' => 'datetime',
        'refund_completed_at' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function cancelledBy()
    {
        return $this->belongsTo(User::class, 'cancelled_by_user_id');
    }
}