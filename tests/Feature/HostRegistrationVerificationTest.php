<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class HostRegistrationVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_host_registration_sends_verification_email_and_redirects_to_verification_notice(): void
    {
        Notification::fake();

        /** @var User $host */
        $host = User::factory()->create([
            'email' => 'host-admin@example.com',
            'role' => 'host',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($host);

        $response = $this->post(route('host.register-host.store'), [
            'full_name' => 'Host Test',
            'email' => 'new-host@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('verification.notice'));

        $newHost = User::where('email', 'new-host@example.com')->firstOrFail();

        $this->assertSame('host', $newHost->role);
        $this->assertNull($newHost->email_verified_at);

        Notification::assertSentTo($newHost, VerifyEmail::class);
    }
}
