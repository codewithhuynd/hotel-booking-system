<?php

namespace Tests\Feature;

use App\Mail\PasswordChangeConfirmationMail;
use App\Mail\PasswordChangedMail;
use App\Models\PasswordChangeRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tests\TestCase;

class PasswordChangeFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_change_request_is_created_and_confirmation_email_is_sent(): void
    {
        Mail::fake();

        /** @var User $user */
        $user = User::factory()->create([
            'password' => Hash::make('OldPass123'),
        ]);

        $this->actingAs($user)
            ->post(route('profile.change-password'), [
                'current_password' => 'OldPass123',
                'new_password' => 'NewPass123!',
                'new_password_confirmation' => 'NewPass123!',
            ])
            ->assertSessionHas('success', 'Vui lòng xác nhận đổi mật khẩu qua email.');

        $this->assertDatabaseHas('password_change_requests', [
            'user_id' => $user->id,
            'used_at' => null,
        ]);

        Mail::assertSent(PasswordChangeConfirmationMail::class);
    }

    public function test_password_change_email_failure_is_logged_and_shows_real_error_in_debug_mode(): void
    {
        config(['app.debug' => true]);

        /** @var User $user */
        $user = User::factory()->create([
            'password' => Hash::make('OldPass123'),
        ]);

        Log::spy();
        Mail::shouldReceive('to')->once()->andThrow(new \RuntimeException('SMTP test failure'));

        $this->actingAs($user)
            ->post(route('profile.change-password'), [
                'current_password' => 'OldPass123',
                'new_password' => 'NewPass123!',
                'new_password_confirmation' => 'NewPass123!',
            ])
            ->assertSessionHas('error', fn (string $message) => str_contains($message, 'SMTP test failure'));

        Log::shouldHaveReceived('error')
            ->withArgs(fn (string $message, array $context) => str_contains($message, 'Password change confirmation email failed') && $context['user_id'] === $user->id);
    }

    public function test_confirmation_link_updates_password_and_marks_token_used(): void
    {
        Mail::fake();

        /** @var User $user */
        $user = User::factory()->create([
            'password' => Hash::make('OldPass123'),
        ]);

        $token = Str::random(64);
        $request = PasswordChangeRequest::create([
            'user_id' => $user->id,
            'token_hash' => hash('sha256', $token),
            'new_password_hash' => Hash::make('NewPass123!'),
            'expires_at' => now()->addMinutes(15),
        ]);

        $this->get(route('profile.change-password.confirm', ['token' => $token]))
            ->assertRedirect(route('login'))
            ->assertSessionHas('success', 'Mật khẩu của bạn đã được thay đổi thành công.');

        $request->refresh();
        $this->assertNotNull($request->used_at);
        $this->assertTrue(Hash::check('NewPass123!', $user->fresh()->password));

        Mail::assertSent(PasswordChangedMail::class);
    }
}
