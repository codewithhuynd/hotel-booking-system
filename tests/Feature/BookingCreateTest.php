<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\HotelSetting;
use App\Models\Payment;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class BookingCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_create_booking_and_deposit_uses_hotel_setting(): void
    {
        HotelSetting::create(['deposit_percent' => 25]);
        Cache::forget('hotel-setting:deposit_percent');
        $room = Room::factory()->create(['price' => 400000]);
        $guest = User::factory()->create(['role' => 'guest']);

        $this->actingAs($guest)->post(route('guest.bookings.store', $room), $this->payload())
            ->assertRedirect(route('guest.bookings.index'));

        $booking = Booking::firstOrFail();
        $this->assertSame(800000.0, (float) $booking->total_price);
        $this->assertSame(200000.0, (float) $booking->deposit_amount);
        $this->assertSame(0, Payment::count());
    }

    public function test_guest_cannot_book_overlapping_dates(): void
    {
        $room = Room::factory()->create();
        $guest = User::factory()->create(['role' => 'guest']);
        Booking::factory()->create([
            'room_id' => $room->id,
            'check_in_date' => now()->addDays(4)->toDateString(),
            'check_out_date' => now()->addDays(6)->toDateString(),
            'status' => 'confirmed',
        ]);

        $this->actingAs($guest)->from(route('guest.bookings.create', $room))
            ->post(route('guest.bookings.store', $room), $this->payload())
            ->assertSessionHasErrors('room');

        $this->assertSame(1, Booking::count());
    }

    public function test_invalid_stay_dates_and_guest_capacity_are_rejected(): void
    {
        $room = Room::factory()->create(['capacity' => 2]);
        $guest = User::factory()->create(['role' => 'guest']);

        foreach ([
            ['check_out_date' => now()->addDays(3)->toDateString()],
            ['check_in_date' => now()->subDay()->toDateString()],
            ['guest_count' => 3],
        ] as $invalidFields) {
            $this->actingAs($guest)->post(route('guest.bookings.store', $room), array_merge($this->payload(), $invalidFields))
                ->assertSessionHasErrors();
        }

        $this->assertSame(0, Booking::count());
    }

    private function payload(): array
    {
        return [
            'check_in_date' => now()->addDays(4)->toDateString(),
            'check_out_date' => now()->addDays(6)->toDateString(),
            'guest_count' => 2,
            'contact_name' => 'Khách đặt phòng',
            'contact_phone' => '0900000000',
            'contact_email' => 'guest@example.com',
        ];
    }
}
