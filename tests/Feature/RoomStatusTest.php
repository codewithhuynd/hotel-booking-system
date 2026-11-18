<?php

namespace Tests\Feature;

use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoomStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_host_can_mark_cleaning_or_maintenance_room_available(): void
    {
        $host = User::factory()->create(['role' => 'host']);

        foreach (['cleaning', 'maintenance'] as $status) {
            $room = Room::factory()->create(['status' => $status]);

            $this->actingAs($host)
                ->post(route('host.rooms.available', $room))
                ->assertRedirect(route('host.rooms.index'));

            $this->assertSame('available', $room->fresh()->status);
        }
    }
}
