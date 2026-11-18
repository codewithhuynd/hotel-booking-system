<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Booking> */
class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        $checkIn = now()->addDays(10)->toDateString();

        return [
            'booking_code' => 'BK-'.strtoupper(fake()->unique()->bothify('########')),
            'user_id' => User::factory()->state(['role' => 'guest']),
            'room_id' => Room::factory(),
            'check_in_date' => $checkIn,
            'check_out_date' => now()->addDays(12)->toDateString(),
            'guest_count' => 1,
            'contact_name' => fake()->name(),
            'contact_phone' => '0900000000',
            'contact_email' => fake()->safeEmail(),
            'room_price' => 500000,
            'total_price' => 1000000,
            'deposit_amount' => 300000,
            'note' => null,
            'status' => 'pending',
            'booked_at' => now(),
        ];
    }
}
