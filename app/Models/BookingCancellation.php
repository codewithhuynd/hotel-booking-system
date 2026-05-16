<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingCancellation extends Model
{
    protected $fillable = [
        'booking_id',
        'cancelled_by_user_id',
        'reason',

        'bank_name',
        'bank_account_number',
        'bank_account_name',

        'refund_completed',
        'refund_completed_at',

        'cancelled_at',
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

    public function cancelledBy()
    {
        return $this->belongsTo(User::class, 'cancelled_by_user_id');
    }
}
