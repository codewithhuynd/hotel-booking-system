<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DepositExpireTest extends TestCase
{
    use RefreshDatabase;

    public function test_overdue_deposit_payment_cancels_booking(): void
    {
        $booking = $this->createBooking('pending', now()->subMinute());

        $this->artisan('payments:expire-deposits')->assertSuccessful();

        $this->assertSame('cancelled', $booking->fresh()->status);
        $this->assertSame('expired', $booking->depositPayment->fresh()->status);
    }

    public function test_deposit_payment_before_deadline_keeps_booking_unchanged(): void
    {
        $booking = $this->createBooking('awaiting_deposit', now()->addMinute());

        $this->artisan('payments:expire-deposits')->assertSuccessful();

        $this->assertSame('awaiting_deposit', $booking->fresh()->status);
        $this->assertSame('unpaid', $booking->depositPayment->fresh()->status);
    }

    private function createBooking(string $status, $deadline): Booking
    {
        $user = User::factory()->create(['role' => 'guest']);
        $room = Room::create([
            'room_code' => 'R-'.uniqid(),
            'room_name' => 'Phòng thử nghiệm',
            'description' => 'Phòng dùng trong kiểm thử',
            'price' => 500000,
            'capacity' => 2,
            'status' => 'available',
        ]);

        $booking = Booking::create([
            'booking_code' => 'BK-'.uniqid(),
            'user_id' => $user->id,
            'room_id' => $room->id,
            'check_in_date' => now()->addDay()->toDateString(),
            'check_out_date' => now()->addDays(2)->toDateString(),
            'guest_count' => 1,
            'contact_name' => 'Khách kiểm thử',
            'contact_phone' => '0900000000',
            'contact_email' => 'guest@example.com',
            'room_price' => 500000,
            'total_price' => 500000,
            'deposit_amount' => 150000,
            'status' => $status,
            'booked_at' => now(),
        ]);

        Payment::create([
            'booking_id' => $booking->id,
            'type' => 'deposit',
            'deposit_amount' => 150000,
            'payment_method' => 'banking',
            'status' => 'unpaid',
            'deposit_deadline' => $deadline,
        ]);

        return $booking;
    }
}
