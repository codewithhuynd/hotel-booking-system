<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\HotelSetting;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Room;
use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AuditFixesTest extends TestCase
{
    use RefreshDatabase;

    public function test_overdue_deposit_with_submitted_proof_is_not_auto_cancelled(): void
    {
        $booking = Booking::factory()->create(['status' => 'awaiting_deposit']);
        $payment = Payment::factory()->create([
            'booking_id' => $booking->id,
            'status' => 'pending',
            'deposit_deadline' => now()->subHour(),
        ]);

        $this->artisan('payments:expire-deposits')->assertSuccessful();

        $this->assertSame('awaiting_deposit', $booking->fresh()->status);
        $this->assertSame('pending', $payment->fresh()->status);
    }

    public function test_host_cannot_delete_user_with_booking_history(): void
    {
        $host = User::factory()->create(['role' => 'host']);
        $booking = Booking::factory()->create(['status' => 'completed']);

        $this->actingAs($host)
            ->delete(route('host.users.destroy', $booking->user_id))
            ->assertSessionHasErrors();

        $this->assertDatabaseHas('users', ['id' => $booking->user_id]);
        $this->assertDatabaseHas('bookings', ['id' => $booking->id]);
    }

    public function test_host_can_delete_user_without_bookings(): void
    {
        $host = User::factory()->create(['role' => 'host']);
        $guest = User::factory()->create(['role' => 'guest']);

        $this->actingAs($host)
            ->delete(route('host.users.destroy', $guest))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('users', ['id' => $guest->id]);
    }

    public function test_host_role_cannot_be_demoted(): void
    {
        $host = User::factory()->create(['role' => 'host']);
        $otherHost = User::factory()->create(['role' => 'host']);

        $this->actingAs($host)
            ->put(route('host.users.update', $otherHost), [
                'full_name' => $otherHost->full_name,
                'role' => 'guest',
            ])
            ->assertSessionHasErrors('role');

        $this->assertSame('host', $otherHost->fresh()->role);
    }

    public function test_cancelling_booking_does_not_free_room_occupied_by_another_guest(): void
    {
        $host = User::factory()->create(['role' => 'host']);
        $room = Room::factory()->create(['status' => 'occupied']);
        $booking = Booking::factory()->create(['room_id' => $room->id, 'status' => 'pending']);

        $this->actingAs($host)
            ->post(route('host.bookings.cancel', $booking), ['reason' => 'Khách yêu cầu huỷ'])
            ->assertSessionHas('success');

        $this->assertSame('cancelled', $booking->fresh()->status);
        $this->assertSame('occupied', $room->fresh()->status);
    }

    public function test_guest_notification_links_point_to_guest_pages(): void
    {
        Notification::fake();

        $host = User::factory()->create(['role' => 'host']);
        $booking = Booking::factory()->create(['status' => 'pending']);

        $this->actingAs($host)->post(route('host.bookings.confirm', $booking));

        Notification::assertSentTo($booking->user, SystemNotification::class, function (SystemNotification $notification) use ($booking) {
            return $notification->data['url'] === route('guest.bookings.show', ['booking' => $booking->id]);
        });
    }

    public function test_updating_hotel_settings_refreshes_cached_deposit_percent(): void
    {
        $setting = HotelSetting::create([
            'deposit_percent' => 30,
            'hero_title' => 'Hotel',
            'hero_description' => 'Mô tả',
        ]);

        $this->assertSame(30.0, getSetting('deposit_percent'));

        $setting->update(['deposit_percent' => 50]);

        $this->assertSame(50.0, getSetting('deposit_percent'));
    }

    public function test_guest_cannot_upload_proof_for_expired_payment(): void
    {
        Storage::fake('public');

        $booking = Booking::factory()->create(['status' => 'cancelled']);
        $payment = Payment::factory()->create(['booking_id' => $booking->id, 'status' => 'expired']);
        $method = PaymentMethod::create(['name' => 'Bank', 'type' => 'banking', 'is_active' => true]);

        $this->actingAs($booking->user)
            ->post(route('guest.payments.upload-proof', $payment), [
                'payment_method_id' => $method->id,
                'proof_image' => UploadedFile::fake()->image('proof.jpg'),
            ])
            ->assertSessionHas('error');

        $this->assertSame('expired', $payment->fresh()->status);
    }

    public function test_guest_cannot_use_inactive_payment_method(): void
    {
        Storage::fake('public');

        $booking = Booking::factory()->create(['status' => 'awaiting_deposit']);
        $payment = Payment::factory()->create(['booking_id' => $booking->id]);
        $method = PaymentMethod::create(['name' => 'Old bank', 'type' => 'banking', 'is_active' => false]);

        $this->actingAs($booking->user)
            ->post(route('guest.payments.upload-proof', $payment), [
                'payment_method_id' => $method->id,
                'proof_image' => UploadedFile::fake()->image('proof.jpg'),
            ])
            ->assertSessionHasErrors('payment_method_id');

        $this->assertSame('unpaid', $payment->fresh()->status);
    }

    public function test_reuploading_proof_deletes_previous_image(): void
    {
        Storage::fake('public');

        $booking = Booking::factory()->create(['status' => 'awaiting_deposit']);
        $payment = Payment::factory()->create(['booking_id' => $booking->id]);
        $method = PaymentMethod::create(['name' => 'Bank', 'type' => 'banking', 'is_active' => true]);

        $upload = fn () => $this->actingAs($booking->user)
            ->post(route('guest.payments.upload-proof', $payment), [
                'payment_method_id' => $method->id,
                'proof_image' => UploadedFile::fake()->image('proof.jpg'),
            ]);

        $upload();
        $firstPath = $payment->fresh()->proof_image;
        $upload();

        Storage::disk('public')->assertMissing($firstPath);
        Storage::disk('public')->assertExists($payment->fresh()->proof_image);
    }

    public function test_login_is_rate_limited(): void
    {
        $user = User::factory()->create();

        for ($i = 0; $i < 5; $i++) {
            $this->post(route('login'), ['email' => $user->email, 'password' => 'sai-mat-khau']);
        }

        $this->post(route('login'), ['email' => $user->email, 'password' => 'sai-mat-khau'])
            ->assertStatus(429);
    }

    public function test_host_can_edit_user_without_role_field(): void
    {
        $host = User::factory()->create(['role' => 'host']);
        $guest = User::factory()->create(['role' => 'guest']);

        $this->actingAs($host)
            ->put(route('host.users.update', $guest), [
                'full_name' => 'Tên mới',
                'phone' => '0911222333',
            ])
            ->assertRedirect(route('host.users.index'));

        $this->assertSame('Tên mới', $guest->fresh()->full_name);
        $this->assertSame('guest', $guest->fresh()->role);
    }

    public function test_user_list_hides_delete_button_for_users_with_bookings(): void
    {
        $host = User::factory()->create(['role' => 'host']);
        $booking = Booking::factory()->create();
        $freeGuest = User::factory()->create(['role' => 'guest']);

        $this->actingAs($host)
            ->get(route('host.users.index'))
            ->assertOk()
            // Link "Xem" dùng cùng URL nên kiểm tra theo thuộc tính action của form xoá.
            ->assertSee('action="'.route('host.users.destroy', $freeGuest).'"', false)
            ->assertDontSee('action="'.route('host.users.destroy', $booking->user_id).'"', false)
            ->assertDontSee('action="'.route('host.users.destroy', $host).'"', false);
    }
}
