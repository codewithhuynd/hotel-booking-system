<?php

use App\Models\HotelSetting;
use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

if (! function_exists('getSetting')) {
    function getSetting(string $key, mixed $default = null): mixed
    {
        try {
            if (! Schema::hasTable('hotel_settings')) {
                return $default;
            }

            return Cache::remember("hotel-setting:{$key}", 3600, function () use ($key, $default) {
                $value = HotelSetting::query()->value($key);

                if (is_numeric($value)) {
                    return (float) $value;
                }

                return $value ?? $default;
            });
        } catch (\Throwable $e) {
            return $default;
        }
    }
}

if (! function_exists('notifyUser')) {
    function notifyUser(mixed $user, string $title, string $message, string $type = 'info', array $data = []): void
    {
        try {
            if (is_numeric($user) || is_string($user)) {
                $user = User::find($user);
            }

            if (! $user) {
                return;
            }

            $notificationData = $data;

            if (empty($notificationData['url'])) {
                if (! empty($notificationData['booking_id'])) {
                    $notificationData['url'] = $user->role === 'host'
                        ? route('admin.bookings.show', ['booking' => $notificationData['booking_id']])
                        : route('guest.bookings.show', ['booking' => $notificationData['booking_id']]);
                } elseif (! empty($notificationData['payment_id'])) {
                    $notificationData['url'] = $user->role === 'host'
                        ? route('admin.payments.show', ['payment' => $notificationData['payment_id']])
                        : route('guest.payments.show', ['payment' => $notificationData['payment_id']]);
                }
            }

            $user->notify(new SystemNotification($title, $message, $type, $notificationData));
        } catch (\Throwable $e) {
            // Ignore notification failures so the main workflow keeps running.
        }
    }
}

if (! function_exists('notifyRole')) {
    function notifyRole(string $role, string $title, string $message, string $type = 'info', array $data = []): void
    {
        try {
            User::query()
                ->where('role', $role)
                ->whereNotNull('email_verified_at')
                ->chunkById(100, function ($users) use ($title, $message, $type, $data) {
                    foreach ($users as $user) {
                        notifyUser($user, $title, $message, $type, $data);
                    }
                });
        } catch (\Throwable $e) {
            // Ignore notification failures so the main workflow keeps running.
        }
    }
}
