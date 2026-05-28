<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\HotelSetting;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        try {
            $hotelSetting = HotelSetting::query()->first();
        } catch (\Throwable $e) {
            $hotelSetting = null;
        }

        View::share('hotelSetting', $hotelSetting);
    }
}