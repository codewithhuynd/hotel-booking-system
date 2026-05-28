<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactMessageSubmitTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_submit_contact_message_and_redirect_back_to_home_contact_section(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'role' => 'guest',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($user)
            ->from(route('home'))
            ->post(route('contact-messages.store'), [
                'name' => 'Guest Bug',
                'email' => 'guest-bug@example.com',
                'message' => 'Test message from guest.',
            ])
            ->assertRedirect(route('home') . '#contact')
            ->assertSessionHas('success', 'Tin nhắn đã được gửi thành công.');

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'guest-bug@example.com',
            'message' => 'Test message from guest.',
            'status' => 'unread',
        ]);

        $this->assertDatabaseCount('contact_messages', 1);
    }
}
