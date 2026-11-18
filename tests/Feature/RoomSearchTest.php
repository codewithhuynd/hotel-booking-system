<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoomSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_hides_rooms_with_overlapping_active_bookings_but_keeps_cancelled_ones(): void
    {
        $guest = User::factory()->create(['role' => 'guest']);
        $overlappingRoom = $this->createRoom('ROOM-OVERLAP');
        $availableRoom = $this->createRoom('ROOM-AVAILABLE');

        $booking = $this->createBooking($guest->id, $overlappingRoom->id, 'confirmed');
        $this->createBooking($guest->id, $availableRoom->id, 'cancelled');

        $response = $this->get(route('rooms.index', [
            'check_in' => now()->addDays(3)->toDateString(),
            'check_out' => now()->addDays(5)->toDateString(),
        ]));

        $response->assertOk();
        $response->assertSee($availableRoom->room_name);
        $response->assertDontSee($overlappingRoom->room_name);
        $response->assertSee('name="check_in"', false);
        $response->assertSee('name="check_out"', false);
    }

    public function test_search_rejects_invalid_date_range(): void
    {
        $this->get(route('rooms.index', [
            'check_in' => now()->addDays(3)->toDateString(),
            'check_out' => now()->addDays(2)->toDateString(),
        ]))->assertSessionHasErrors('check_out');
    }

    public function test_selected_dates_are_prefilled_on_booking_form(): void
    {
        $room = $this->createRoom('ROOM-PREFILL');
        $checkIn = now()->addDays(3)->toDateString();
        $checkOut = now()->addDays(5)->toDateString();

        $guest = User::factory()->create(['role' => 'guest']);

        $this->actingAs($guest)->get(route('guest.bookings.create', [
            'room' => $room,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
        ]))
            ->assertOk()
            ->assertSee('value="'.$checkIn.'"', false)
            ->assertSee('value="'.$checkOut.'"', false);
    }

    private function createRoom(string $code): Room
    {
        return Room::create([
            'room_code' => $code,
            'room_name' => $code,
            'description' => 'Phòng kiểm thử',
            'price' => 500000,
            'capacity' => 2,
            'status' => 'available',
        ]);
    }

    private function createBooking(int $userId, int $roomId, string $status): Booking
    {
        static $code = 0;

        return Booking::create([
            'booking_code' => 'BK-SEARCH-'.++$code,
            'user_id' => $userId,
            'room_id' => $roomId,
            'check_in_date' => now()->addDays(4)->toDateString(),
            'check_out_date' => now()->addDays(6)->toDateString(),
            'guest_count' => 1,
            'contact_name' => 'Khách kiểm thử',
            'contact_phone' => '0900000000',
            'room_price' => 500000,
            'total_price' => 1000000,
            'deposit_amount' => 300000,
            'status' => $status,
            'booked_at' => now(),
        ]);
    }
}
