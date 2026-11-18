<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /** Trạng thái booking được phép đánh giá (khách đã ở xong). */
    public const REVIEWABLE_BOOKING_STATUSES = ['checked_out', 'completed'];

    protected $fillable = [
        'booking_id',
        'user_id',
        'room_id',
        'rating',
        'comment',
        'is_hidden',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_hidden' => 'boolean',
    ];

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_hidden', false);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class)->withTrashed();
    }
}
