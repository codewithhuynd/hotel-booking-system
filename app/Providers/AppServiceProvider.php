<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\HotelSetting;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Bridge\Brevo\Transport\BrevoTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Mailer 'brevo': gửi mail qua Brevo HTTP API (cổng 443) vì Railway chặn SMTP
        // ở gói Free/Hobby. Bật bằng MAIL_MAILER=brevo và BREVO_API_KEY.
        Mail::extend('brevo', function (array $config) {
            // Cho phép test thay HTTP client (MockHttpClient); mặc định Symfony tự tạo client.
            $client = app()->bound(HttpClientInterface::class) ? app(HttpClientInterface::class) : null;

            return (new BrevoTransportFactory(null, $client))->create(
                new Dsn('brevo+api', 'default', $config['key'] ?? config('services.brevo.key'))
            );
        });

        try {
            $hotelSetting = HotelSetting::query()->first();
        } catch (\Throwable $e) {
            $hotelSetting = null;
        }

        View::share('hotelSetting', $hotelSetting);
    }
}