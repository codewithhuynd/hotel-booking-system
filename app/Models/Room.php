<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'room_code',
        'room_name',
        'description',
        'price',
        'capacity',
        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function images()
    {
        return $this->hasMany(RoomImage::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /** Phòng khách có thể đặt (loại phòng đang bảo trì). */
    public function scopeBookable($query)
    {
        return $query->where('status', '!=', 'maintenance');
    }

    public function isBookable(): bool
    {
        return $this->status !== 'maintenance';
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function mainImage()
    {
        return $this->hasOne(RoomImage::class)
            ->where('is_main', true);
    }
}
