<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Models\User;
use App\Services\StatisticsService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatisticsServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_revenue_is_grouped_by_paid_month(): void
    {
        $booking = $this->createBooking('2026-05-12', '2026-05-14', 'confirmed');
        Payment::create([
            'booking_id' => $booking->id,
            'type' => 'deposit',
            'deposit_amount' => 125000,
            'payment_method' => 'banking',
            'status' => 'paid',
            'paid_at' => '2026-05-20 12:00:00',
        ]);

        $stats = app(StatisticsService::class)->forPeriod(
            Carbon::parse('2026-05-01'),
            Carbon::parse('2026-06-30')
        );

        $this->assertSame(125000.0, $stats['monthlyRevenue']['2026-05']);
        $this->assertSame(0.0, $stats['monthlyRevenue']['2026-06']);
        $this->assertSame(125000.0, $stats['totalRevenue']);
    }

    public function test_occupancy_rate_uses_booked_nights_over_room_days(): void
    {
        $booking = $this->createBooking('2026-05-01', '2026-05-03', 'confirmed');
        $this->createRoom('ROOM-EMPTY');

        $stats = app(StatisticsService::class)->forPeriod(
            Carbon::parse('2026-05-01'),
            Carbon::parse('2026-05-10')
        );

        $this->assertSame(10.0, $stats['occupancyRate']);
    }

    private function createBooking(string $checkIn, string $checkOut, string $status): Booking
    {
        $user = User::factory()->create(['role' => 'guest']);
        $room = $this->createRoom('ROOM-'.uniqid());

        return Booking::create([
            'booking_code' => 'BK-'.uniqid(),
            'user_id' => $user->id,
            'room_id' => $room->id,
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'guest_count' => 1,
            'contact_name' => 'Khách thống kê',
            'contact_phone' => '0900000000',
            'room_price' => 100000,
            'total_price' => 200000,
            'deposit_amount' => 60000,
            'status' => $status,
            'booked_at' => $checkIn,
        ]);
    }

    private function createRoom(string $code): Room
    {
        return Room::create([
            'room_code' => $code,
            'room_name' => $code,
            'description' => 'Phòng thống kê',
            'price' => 100000,
            'capacity' => 2,
            'status' => 'available',
        ]);
    }
}
