<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Room> */
class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        return [
            'room_code' => 'R-'.strtoupper(fake()->unique()->bothify('####')),
            'room_name' => fake()->words(2, true),
            'description' => fake()->sentence(),
            'price' => 500000,
            'capacity' => 2,
            'status' => 'available',
        ];
    }
}
