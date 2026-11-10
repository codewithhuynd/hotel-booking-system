<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_links_to_password_recovery_form(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee(route('password.request'));

        $this->get(route('password.request'))
            ->assertOk()
            ->assertSee(route('password.email'));
    }

    public function test_existing_email_receives_a_password_reset_notification(): void
    {
        Notification::fake();
        $user = User::factory()->create(['email' => 'guest@example.com']);

        $this->post(route('password.email'), ['email' => $user->email])
            ->assertRedirect(route('password.request'))
            ->assertSessionHas('status');

        Notification::assertSentTo($user, ResetPassword::class);
        $this->assertDatabaseHas('password_reset_tokens', ['email' => $user->email]);
    }

    public function test_unknown_email_gets_the_same_generic_response_without_notification(): void
    {
        Notification::fake();

        $this->post(route('password.email'), ['email' => 'unknown@example.com'])
            ->assertRedirect(route('password.request'))
            ->assertSessionHas(
                'status',
                'Nếu địa chỉ email có trong hệ thống, hướng dẫn đặt lại mật khẩu sẽ được gửi đến email đó.'
            );

        Notification::assertNothingSent();
    }

    public function test_password_can_be_reset_with_a_valid_token_and_token_cannot_be_reused(): void
    {
        Notification::fake();
        $user = User::factory()->create([
            'email' => 'guest@example.com',
            'password' => Hash::make('old-password'),
        ]);

        $this->post(route('password.email'), ['email' => $user->email]);

        $token = null;
        Notification::assertSentTo(
            $user,
            ResetPassword::class,
            function (ResetPassword $notification) use (&$token): bool {
                $token = $notification->token;

                return true;
            }
        );
        $this->assertNotNull($token);

        $this->get(route('password.reset', ['token' => $token, 'email' => $user->email]))
            ->assertOk()
            ->assertSee($user->email);

        $resetData = [
            'token' => $token,
            'email' => $user->email,
            'password' => 'new-password-123',
            'password_confirmation' => 'new-password-123',
        ];

        $this->post(route('password.update'), $resetData)
            ->assertRedirect(route('login'))
            ->assertSessionHas('status');

        $this->assertTrue(Hash::check('new-password-123', $user->fresh()->password));
        $this->assertDatabaseMissing('password_reset_tokens', ['email' => $user->email]);

        $this->from(route('password.reset', ['token' => $token, 'email' => $user->email]))
            ->post(route('password.update'), $resetData)
            ->assertRedirect(route('password.reset', ['token' => $token, 'email' => $user->email]))
            ->assertSessionHasErrors('email');
    }

    public function test_invalid_token_does_not_change_password(): void
    {
        $user = User::factory()->create([
            'email' => 'guest@example.com',
            'password' => Hash::make('old-password'),
        ]);

        $this->from(route('password.reset', ['token' => 'invalid-token', 'email' => $user->email]))
            ->post(route('password.update'), [
                'token' => 'invalid-token',
                'email' => $user->email,
                'password' => 'new-password-123',
                'password_confirmation' => 'new-password-123',
            ])
            ->assertSessionHasErrors('email');

        $this->assertTrue(Hash::check('old-password', $user->fresh()->password));
    }

    public function test_reset_rejects_short_or_unconfirmed_passwords(): void
    {
        $user = User::factory()->create();

        $this->post(route('password.update'), [
            'token' => 'any-token',
            'email' => $user->email,
            'password' => 'short',
            'password_confirmation' => 'different',
        ])
            ->assertSessionHasErrors(['password']);
    }

    public function test_reset_link_request_requires_a_valid_email_address(): void
    {
        $this->from(route('password.request'))
            ->post(route('password.email'), ['email' => 'not-an-email'])
            ->assertRedirect(route('password.request'))
            ->assertSessionHasErrors('email');
    }
}
