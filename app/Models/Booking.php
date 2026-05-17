<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

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

    public function cancellation()
    {
        return $this->hasOne(BookingCancellation::class);
    }
}