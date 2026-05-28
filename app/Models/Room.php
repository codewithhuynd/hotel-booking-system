<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;

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

    public function mainImage()
    {
        return $this->hasOne(RoomImage::class)
            ->where('is_main', true);
    }

    public function displayStatusLabel(): string
    {
        return match ($this->status) {
            'available' => 'Còn trống',
            'occupied' => 'Đang sử dụng',
            'cleaning' => 'Đang dọn dẹp',
            'maintenance' => 'Bảo trì',
            default => 'Không xác định',
        };
    }
}