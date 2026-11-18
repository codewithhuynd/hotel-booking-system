<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HostDashboardAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_host_dashboard(): void
    {
        $guest = User::factory()->create(['role' => 'guest']);

        $this->actingAs($guest)
            ->get(route('host.dashboard'))
            ->assertForbidden();
    }
}
