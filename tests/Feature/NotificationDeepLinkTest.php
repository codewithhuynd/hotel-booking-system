<?php

namespace Tests\Feature;

use App\Notifications\SystemNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotificationDeepLinkTest extends TestCase
{
    public function test_guest_notification_uses_guest_booking_detail_link(): void
    {
        Notification::fake();

        $user = new class
        {
            use Notifiable;

            public int $id = 1;

            public string $role = 'guest';

            public function getKey(): int
            {
                return $this->id;
            }
        };

        notifyUser($user, 'Booking mới', 'Có booking cần xử lý', 'info', [
            'booking_id' => 42,
        ]);

        Notification::assertSentTo($user, SystemNotification::class, function (SystemNotification $notification) {
            return $notification->data['url'] === route('guest.bookings.show', ['booking' => 42]);
        });
    }

    public function test_host_notification_uses_admin_detail_link(): void
    {
        Notification::fake();

        $user = new class
        {
            use Notifiable;

            public int $id = 2;

            public string $role = 'host';

            public function getKey(): int
            {
                return $this->id;
            }
        };

        notifyUser($user, 'Thanh toán mới', 'Có payment cần xác nhận', 'info', [
            'payment_id' => 18,
        ]);

        Notification::assertSentTo($user, SystemNotification::class, function (SystemNotification $notification) {
            return $notification->data['url'] === route('admin.payments.show', ['payment' => 18]);
        });
    }
}
