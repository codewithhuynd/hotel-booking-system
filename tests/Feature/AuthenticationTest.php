<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_login_and_registration_pages(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Đăng Nhập');

        $this->get(route('register'))
            ->assertOk()
            ->assertSee('Đăng Ký Khách');
    }

    public function test_verified_user_can_log_in_and_is_redirected_home(): void
    {
        $user = User::factory()->create([
            'email' => 'guest@example.com',
            'password' => Hash::make('secret123'),
        ]);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'secret123',
        ])
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_redirects_unverified_user_to_email_verification(): void
    {
        $user = User::factory()->unverified()->create([
            'email' => 'unverified@example.com',
            'password' => Hash::make('secret123'),
        ]);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'secret123',
        ])
            ->assertRedirect(route('verification.notice'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_returns_user_to_the_page_they_requested(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('secret123'),
        ]);

        $this->get(route('guest.bookings.index'))
            ->assertRedirect(route('login'));

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'secret123',
        ])
            ->assertRedirect(route('guest.bookings.index'));
    }

    public function test_invalid_login_credentials_are_rejected_without_authenticating(): void
    {
        $user = User::factory()->create([
            'email' => 'guest@example.com',
            'password' => Hash::make('secret123'),
        ]);

        $this->from(route('login'))
            ->post(route('login'), [
                'email' => $user->email,
                'password' => 'wrong-password',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_registration_creates_guest_sends_verification_and_logs_user_in(): void
    {
        Notification::fake();

        $this->post(route('register'), [
            'full_name' => 'New Guest',
            'email' => 'new-guest@example.com',
            'password' => 'secret123',
        ])
            ->assertRedirect(route('verification.notice'));

        $user = User::where('email', 'new-guest@example.com')->firstOrFail();

        $this->assertSame('New Guest', $user->full_name);
        $this->assertSame('guest', $user->role);
        $this->assertNull($user->email_verified_at);
        $this->assertTrue(Hash::check('secret123', $user->password));
        $this->assertAuthenticatedAs($user);
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_registration_rejects_invalid_and_duplicate_data(): void
    {
        User::factory()->create(['email' => 'existing@example.com']);

        $this->from(route('register'))
            ->post(route('register'), [
                'full_name' => '',
                'email' => 'not-an-email',
                'password' => '123',
            ])
            ->assertRedirect(route('register'))
            ->assertSessionHasErrors(['full_name', 'email', 'password']);

        $this->from(route('register'))
            ->post(route('register'), [
                'full_name' => 'Duplicate User',
                'email' => 'existing@example.com',
                'password' => 'secret123',
            ])
            ->assertRedirect(route('register'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
        $this->assertSame(1, User::count());
    }

    public function test_signed_verification_link_marks_email_verified(): void
    {
        $user = User::factory()->unverified()->create();
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())],
        );

        $this->actingAs($user)
            ->get($verificationUrl)
            ->assertRedirect(route('home'));

        $this->assertNotNull($user->fresh()->email_verified_at);
    }

    public function test_unverified_user_can_follow_email_link_without_being_logged_in(): void
    {
        $user = User::factory()->unverified()->create();
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())],
        );

        $this->get($verificationUrl)
            ->assertRedirect(route('login'))
            ->assertSessionHas('status', 'Email đã được xác thực. Vui lòng đăng nhập để tiếp tục.');

        $this->assertNotNull($user->fresh()->email_verified_at);
        $this->assertGuest();
    }

    public function test_signed_verification_link_with_wrong_email_hash_does_not_verify_user(): void
    {
        $user = User::factory()->unverified()->create();
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1('different@example.com')],
        );

        $this->get($verificationUrl)->assertForbidden();

        $this->assertNull($user->fresh()->email_verified_at);
    }

    public function test_authenticated_user_cannot_open_guest_login_or_registration_pages(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('login'))->assertRedirect(route('home'));
        $this->get(route('register'))->assertRedirect(route('home'));
    }

    public function test_logout_invalidates_session_and_ends_authentication(): void
    {
        $this->actingAs(User::factory()->create());
        $this->withSession(['logout-test' => 'must be removed']);

        $this->post(route('logout'))
            ->assertRedirect(route('home'))
            ->assertSessionMissing('logout-test');

        $this->assertGuest();
    }

    public function test_guest_cannot_call_logout(): void
    {
        $this->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }
}
