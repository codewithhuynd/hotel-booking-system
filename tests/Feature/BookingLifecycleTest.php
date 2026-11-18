<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingLifecycleTest extends TestCase
{
    use RefreshDatabase;

    public function test_host_confirms_checkin_and_checks_out_booking(): void
    {
        $host = User::factory()->create(['role' => 'host']);
        $booking = Booking::factory()->create(['status' => 'pending']);

        $this->actingAs($host)->post(route('host.bookings.confirm', $booking))->assertRedirect();
        $booking->refresh();
        $this->assertSame('awaiting_deposit', $booking->status);
        $this->assertDatabaseHas('payments', ['booking_id' => $booking->id, 'type' => 'deposit']);

        $payment = $booking->depositPayment;
        $payment->update(['status' => 'paid', 'paid_at' => now()]);
        $booking->update(['status' => 'confirmed']);

        $this->actingAs($host)->post(route('host.bookings.check-in', $booking))->assertRedirect();
        $this->assertSame('checked_in', $booking->fresh()->status);
        $this->assertSame('occupied', $booking->room->fresh()->status);

        $this->post(route('host.bookings.check-out', $booking))->assertRedirect();
        $this->assertSame('checked_out', $booking->fresh()->status);
        $this->assertSame('available', $booking->room->fresh()->status);
    }

    public function test_host_cannot_check_in_booking_before_confirmation(): void
    {
        $host = User::factory()->create(['role' => 'host']);
        $booking = Booking::factory()->create(['status' => 'pending']);
        Payment::factory()->create(['booking_id' => $booking->id, 'status' => 'paid']);

        $this->actingAs($host)->post(route('host.bookings.check-in', $booking))->assertRedirect();

        $this->assertSame('pending', $booking->fresh()->status);
        $this->assertSame('available', Room::find($booking->room_id)->status);
    }
}
