<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelSetting extends Model
{
    protected $fillable = [
        'hero_title',
        'hero_description',
        'hero_image',

        'hotline',
        'email',
        'address',
        'working_hours',

        'facebook_link',
        'google_map_link',
    ];
}
