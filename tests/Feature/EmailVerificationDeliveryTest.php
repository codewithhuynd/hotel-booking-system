<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\Mailer\Exception\TransportException;
use Tests\TestCase;

class EmailVerificationDeliveryTest extends TestCase
{
    use RefreshDatabase;

    public function test_resend_failure_shows_a_vietnamese_error_instead_of_a_server_error(): void
    {
        $user = User::factory()->unverified()->create();
        Notification::shouldReceive('send')->once()->andThrow(new TransportException('SMTP connection refused'));

        $this->actingAs($user)
            ->from(route('verification.notice'))
            ->post(route('verification.send'))
            ->assertRedirect(route('verification.notice'))
            ->assertSessionHas('error', 'Chưa gửi được email xác minh. Vui lòng kiểm tra kết nối SMTP rồi thử lại.');

        $this->assertNull($user->fresh()->email_verified_at);
    }

    public function test_registration_keeps_the_account_and_shows_resend_guidance_when_mail_is_unavailable(): void
    {
        Notification::shouldReceive('send')->once()->andThrow(new TransportException('SMTP connection refused'));

        $this->post(route('register'), [
            'full_name' => 'Guest Mail Test',
            'email' => 'guest-mail-test@example.com',
            'password' => 'secret123',
        ])
            ->assertRedirect(route('verification.notice'))
            ->assertSessionHas('error', 'Tài khoản đã được tạo nhưng chưa gửi được email xác minh. Vui lòng kiểm tra SMTP và gửi lại.');

        $this->assertDatabaseHas('users', ['email' => 'guest-mail-test@example.com']);
    }
}
