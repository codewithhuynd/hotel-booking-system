<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\BookingCancellation;
use App\Models\ContactMessage;
use App\Models\PasswordChangeRequest;
use App\Models\Payment;
use App\Models\Room;
use App\Models\RoomImage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Mailer\Exception\TransportException;
use Tests\TestCase;

class ThirdAuditFixesTest extends TestCase
{
    use RefreshDatabase;

    /* ---------- 1. Trust proxy ---------- */

    public function test_forwarded_https_scheme_is_trusted(): void
    {
        $this->get('/', ['X-Forwarded-Proto' => 'https', 'X-Forwarded-Host' => 'hotel.example.com'])
            ->assertOk()
            ->assertSee('https://hotel.example.com', false);
    }

    /* ---------- 3. Mail failures do not crash ---------- */

    public function test_forgot_password_mail_failure_shows_error_instead_of_500(): void
    {
        $user = User::factory()->create();
        Notification::shouldReceive('send')->andThrow(new TransportException('SMTP down'));

        $this->from(route('password.request'))
            ->post(route('password.email'), ['email' => $user->email])
            ->assertRedirect(route('password.request'))
            ->assertSessionHasErrors('email');
    }

    public function test_contact_reply_mail_failure_keeps_message_unreplied(): void
    {
        $host = User::factory()->create(['role' => 'host']);
        $message = ContactMessage::create(['name' => 'Khách', 'email' => 'khach@example.com', 'message' => 'Xin chào', 'status' => 'read']);
        Mail::shouldReceive('to')->andThrow(new TransportException('SMTP down'));

        $this->actingAs($host)
            ->post(route('host.contact-messages.send-reply', $message), ['reply_message' => 'Cảm ơn bạn'])
            ->assertSessionHasErrors('reply_message');

        $this->assertSame('read', $message->fresh()->status);
    }

    public function test_password_change_succeeds_even_if_notification_mail_fails(): void
    {
        $user = User::factory()->create();
        $token = Str::random(64);
        PasswordChangeRequest::create([
            'user_id' => $user->id,
            'token_hash' => hash('sha256', $token),
            'new_password_hash' => Hash::make('matkhaumoi1'),
            'expires_at' => now()->addMinutes(15),
        ]);
        Mail::shouldReceive('to')->andThrow(new TransportException('SMTP down'));

        $this->get(route('profile.change-password.confirm', ['token' => $token]))
            ->assertRedirect(route('login'));

        $this->assertTrue(Hash::check('matkhaumoi1', $user->fresh()->password));
    }

    /* ---------- 4. Register password rules ---------- */

    public function test_register_requires_password_confirmation_and_strength(): void
    {
        $this->post(route('register'), [
            'full_name' => 'Khách Mới',
            'email' => 'moi@example.com',
            'password' => 'matkhau123',
            'password_confirmation' => 'khac12345',
        ])->assertSessionHasErrors('password');

        $this->post(route('register'), [
            'full_name' => 'Khách Mới',
            'email' => 'moi@example.com',
            'password' => 'chiconchu',
            'password_confirmation' => 'chiconchu',
        ])->assertSessionHasErrors('password');

        $this->assertDatabaseMissing('users', ['email' => 'moi@example.com']);
    }

    /* ---------- 5. Contact spam ---------- */

    public function test_contact_form_is_rate_limited_and_length_limited(): void
    {
        $this->post(route('contact-messages.store'), ['name' => 'A', 'email' => 'a@example.com', 'message' => str_repeat('a', 2001)])
            ->assertSessionHasErrors('message');

        for ($i = 0; $i < 2; $i++) {
            $this->post(route('contact-messages.store'), ['name' => 'A', 'email' => 'a@example.com', 'message' => 'Xin chào']);
        }

        $this->post(route('contact-messages.store'), ['name' => 'A', 'email' => 'a@example.com', 'message' => 'Xin chào'])
            ->assertStatus(429);
    }

    /* ---------- 6. Pending expiry & no-show ---------- */

    public function test_stale_pending_booking_is_auto_cancelled(): void
    {
        $stale = Booking::factory()->create(['status' => 'pending', 'booked_at' => now()->subHours(49)]);
        $fresh = Booking::factory()->create(['status' => 'pending', 'booked_at' => now()->subHour()]);
        $sameDay = Booking::factory()->create([
            'status' => 'pending',
            'booked_at' => now(),
            'check_in_date' => today()->toDateString(),
            'check_out_date' => today()->addDay()->toDateString(),
        ]);

        $this->artisan('bookings:expire')->assertSuccessful();

        $this->assertSame('cancelled', $stale->fresh()->status);
        $this->assertSame('pending', $fresh->fresh()->status);
        $this->assertSame('pending', $sameDay->fresh()->status);
    }

    public function test_confirmed_booking_past_checkout_is_marked_no_show(): void
    {
        $noShow = Booking::factory()->create([
            'status' => 'confirmed',
            'check_in_date' => today()->subDays(3)->toDateString(),
            'check_out_date' => today()->subDay()->toDateString(),
        ]);
        $deposit = Payment::factory()->create(['booking_id' => $noShow->id, 'status' => 'paid']);
        $upcoming = Booking::factory()->create(['status' => 'confirmed']);

        $this->artisan('bookings:expire')->assertSuccessful();

        $this->assertSame('cancelled', $noShow->fresh()->status);
        $this->assertSame('paid', $deposit->fresh()->status, 'Tiền cọc được giữ lại khi no-show.');
        $this->assertSame('confirmed', $upcoming->fresh()->status);
    }

    /* ---------- 7. Main image ---------- */

    public function test_first_uploaded_image_becomes_main_and_deleting_main_promotes_next(): void
    {
        Storage::fake('public');
        $host = User::factory()->create(['role' => 'host']);
        $room = Room::factory()->create();

        $this->actingAs($host)->post(route('host.rooms.images.store', $room), [
            'images' => [UploadedFile::fake()->image('a.jpg'), UploadedFile::fake()->image('b.jpg')],
        ]);

        [$first, $second] = RoomImage::where('room_id', $room->id)->orderBy('id')->get();
        $this->assertTrue($first->is_main);
        $this->assertFalse($second->is_main);

        $this->actingAs($host)->delete(route('host.rooms.images.destroy', $first));

        $this->assertTrue($second->fresh()->is_main);
    }

    /* ---------- 8. Private proof images ---------- */

    public function test_payment_proof_is_private_and_only_visible_to_owner_and_host(): void
    {
        Storage::fake('public');
        Storage::fake('local');

        $booking = Booking::factory()->create();
        Storage::disk('local')->put('payment_proofs/proof.jpg', 'image-bytes');
        $payment = Payment::factory()->create(['booking_id' => $booking->id, 'status' => 'pending', 'proof_image' => 'payment_proofs/proof.jpg']);

        $host = User::factory()->create(['role' => 'host']);
        $stranger = User::factory()->create(['role' => 'guest']);

        $this->get(route('files.payment-proof', $payment))->assertRedirect(route('login'));
        $this->actingAs($stranger)->get(route('files.payment-proof', $payment))->assertForbidden();
        $this->actingAs($booking->user)->get(route('files.payment-proof', $payment))->assertOk();
        $this->actingAs($host)->get(route('files.payment-proof', $payment))->assertOk();

        Storage::disk('public')->assertMissing('payment_proofs/proof.jpg');
    }

    public function test_legacy_proof_on_public_disk_is_still_served(): void
    {
        Storage::fake('public');
        Storage::fake('local');

        $booking = Booking::factory()->create(['status' => 'cancelled']);
        Storage::disk('public')->put('refund_proofs/old.png', 'image-bytes');
        $cancellation = BookingCancellation::create([
            'booking_id' => $booking->id,
            'cancelled_by_user_id' => $booking->user_id,
            'cancelled_by_type' => 'guest',
            'reason' => 'Đổi lịch trình',
            'refund_completed' => true,
            'refund_proof_image' => 'refund_proofs/old.png',
            'cancelled_at' => now(),
        ]);

        $this->actingAs($booking->user)->get(route('files.refund-proof', $cancellation))->assertOk();
    }

    /* ---------- 9. Maintenance rooms ---------- */

    public function test_maintenance_room_is_hidden_and_cannot_be_booked(): void
    {
        $guest = User::factory()->create(['role' => 'guest']);
        $room = Room::factory()->create(['room_name' => 'Phong Dang Bao Tri', 'status' => 'maintenance']);

        $this->get(route('rooms.index'))->assertOk()->assertDontSee('Phong Dang Bao Tri');

        $this->actingAs($guest)->get(route('guest.bookings.create', $room))->assertRedirect(route('rooms.show', $room));

        $this->actingAs($guest)->post(route('guest.bookings.store', $room), [
            'check_in_date' => today()->addDays(5)->toDateString(),
            'check_out_date' => today()->addDays(6)->toDateString(),
            'guest_count' => 1,
            'contact_name' => 'Khách',
            'contact_phone' => '0900000000',
        ])->assertSessionHasErrors('room');

        $this->assertSame(0, Booking::count());
    }

    /* ---------- 10. Check-in date ---------- */

    public function test_host_cannot_check_in_before_check_in_date(): void
    {
        $host = User::factory()->create(['role' => 'host']);
        $booking = Booking::factory()->create(['status' => 'confirmed']); // nhận phòng sau 10 ngày
        Payment::factory()->create(['booking_id' => $booking->id, 'status' => 'paid']);

        $this->actingAs($host)->post(route('host.bookings.check-in', $booking))->assertSessionHas('error');

        $this->assertSame('confirmed', $booking->fresh()->status);
    }

    /* ---------- 11. Refund policy ---------- */

    public function test_late_guest_cancellation_forfeits_deposit_without_bank_info(): void
    {
        $booking = Booking::factory()->create([
            'status' => 'confirmed',
            'check_in_date' => today()->addDay()->toDateString(),
            'check_out_date' => today()->addDays(2)->toDateString(),
        ]);
        Payment::factory()->create(['booking_id' => $booking->id, 'status' => 'paid']);

        $this->actingAs($booking->user)
            ->post(route('guest.bookings.cancel', $booking), ['reason' => 'Thay đổi kế hoạch đột xuất'])
            ->assertSessionHas('success');

        $cancellation = $booking->fresh()->cancellation;
        $this->assertSame('cancelled', $booking->fresh()->status);
        $this->assertTrue((bool) $cancellation->refund_completed, 'Huỷ muộn: không có khoản hoàn tiền nào cần xử lý.');
        $this->assertNull($cancellation->bank_name);
    }

    public function test_early_guest_cancellation_still_requires_bank_info_for_refund(): void
    {
        $booking = Booking::factory()->create(['status' => 'confirmed']); // nhận phòng sau 10 ngày
        Payment::factory()->create(['booking_id' => $booking->id, 'status' => 'paid']);

        $this->actingAs($booking->user)
            ->post(route('guest.bookings.cancel', $booking), ['reason' => 'Thay đổi kế hoạch đột xuất'])
            ->assertSessionHasErrors(['bank_name', 'bank_account_number', 'bank_account_name']);

        $this->assertSame('confirmed', $booking->fresh()->status);
    }
}
