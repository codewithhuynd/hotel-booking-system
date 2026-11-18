<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_role_is_denied_host_routes(): void
    {
        $guest = User::factory()->create(['role' => 'guest']);

        $this->actingAs($guest)->get(route('host.bookings.index'))->assertForbidden();
        $this->actingAs($guest)->get(route('host.dashboard'))->assertForbidden();
    }

    public function test_guest_cannot_view_or_cancel_another_guests_booking(): void
    {
        $owner = User::factory()->create(['role' => 'guest']);
        $otherGuest = User::factory()->create(['role' => 'guest']);
        $booking = Booking::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($otherGuest)->get(route('guest.bookings.show', $booking))->assertForbidden();
        $this->actingAs($otherGuest)->get(route('guest.bookings.cancel-form', $booking))->assertForbidden();
        $this->actingAs($otherGuest)->post(route('guest.bookings.cancel', $booking), [])->assertForbidden();
    }

    public function test_unauthenticated_guest_booking_request_redirects_to_login(): void
    {
        $booking = Booking::factory()->create();

        $this->get(route('guest.bookings.show', $booking))
            ->assertRedirect(route('login'));
    }
}
