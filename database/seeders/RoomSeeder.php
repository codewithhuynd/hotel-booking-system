<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        Room::create([
            'room_code' => 'A101',
            'room_name' => 'Standard Room',
            'description' => 'Standard room for 2 guests',
            'price' => 500000,
            'capacity' => 2,
            'status' => 'available',
        ]);

        Room::create([
            'room_code' => 'B201',
            'room_name' => 'Deluxe Room',
            'description' => 'Deluxe room with balcony',
            'price' => 800000,
            'capacity' => 4,
            'status' => 'available',
        ]);

        Room::create([
            'room_code' => 'VIP301',
            'room_name' => 'VIP Suite',
            'description' => 'Luxury VIP suite',
            'price' => 1500000,
            'capacity' => 6,
            'status' => 'available',
        ]);

        foreach ([
            ['A102', 'Standard Twin', 550000, 2],
            ['A103', 'Standard Family', 650000, 3],
            ['B202', 'Deluxe Garden', 850000, 4],
            ['B203', 'Deluxe Ocean', 950000, 4],
            ['VIP302', 'Executive Suite', 1800000, 6],
        ] as [$code, $name, $price, $capacity]) {
            Room::create([
                'room_code' => $code,
                'room_name' => $name,
                'description' => 'Phòng nghỉ tiện nghi tại khách sạn.',
                'price' => $price,
                'capacity' => $capacity,
                'status' => 'available',
            ]);
        }
    }
}
