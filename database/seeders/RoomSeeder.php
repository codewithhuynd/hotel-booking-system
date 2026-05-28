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
            'room_name' => 'Phòng tiêu chuẩn',
            'description' => 'Phòng tiêu chuẩn cho 2 khách',
            'price' => 500000,
            'capacity' => 2,
            'status' => 'available',
        ]);

        Room::create([
            'room_code' => 'B201',
            'room_name' => 'Phòng cao cấp',
            'description' => 'Phòng cao cấp có ban công',
            'price' => 800000,
            'capacity' => 4,
            'status' => 'available',
        ]);

        Room::create([
            'room_code' => 'VIP301',
            'room_name' => 'Suite VIP',
            'description' => 'Suite VIP sang trọng',
            'price' => 1500000,
            'capacity' => 6,
            'status' => 'available',
        ]);
    }
}