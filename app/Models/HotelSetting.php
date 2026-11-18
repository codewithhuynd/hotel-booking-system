<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class HotelSetting extends Model
{
    protected $fillable = [
        'deposit_percent',
        'hero_title',
        'hero_description',
        'hero_image',

        'hotline',
        'email',
        'address',
        'working_hours',

        'facebook_link',
        'google_map_link',

        'hotel_address',
        'google_map_embed',
    ];

    protected static function booted(): void
    {
        // Xoá cache của getSetting() để thay đổi (vd. % đặt cọc) có hiệu lực ngay.
        static::saved(function (HotelSetting $setting) {
            foreach (array_keys($setting->getAttributes()) as $key) {
                Cache::forget("hotel-setting:{$key}");
            }
        });
    }
}
