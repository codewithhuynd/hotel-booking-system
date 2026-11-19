<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\Mailer\Bridge\Brevo\Transport\BrevoApiTransport;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Tests\TestCase;

class BrevoMailerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'mail.default' => 'brevo',
            'mail.mailers.brevo.key' => 'xkeysib-test-key',
            'mail.from.address' => 'sender@example.com',
            'mail.from.name' => 'Hotel Test',
        ]);
    }

    public function test_brevo_mailer_uses_http_api_transport(): void
    {
        $this->assertInstanceOf(BrevoApiTransport::class, app('mail.manager')->mailer('brevo')->getSymfonyTransport());
    }

    public function test_verification_email_is_sent_through_brevo_api(): void
    {
        $requests = [];

        $this->app->instance(HttpClientInterface::class, new MockHttpClient(function (string $method, string $url, array $options) use (&$requests) {
            $requests[] = compact('method', 'url', 'options');

            return new MockResponse('{"messageId":"<test@brevo>"}', ['http_code' => 201]);
        }));

        $user = new User(['full_name' => 'Khách Brevo', 'email' => 'guest@example.com']);
        $user->id = 1;

        $user->notifyNow(new VerifyEmail);

        $this->assertCount(1, $requests);
        $this->assertSame('POST', $requests[0]['method']);
        $this->assertSame('https://api.brevo.com/v3/smtp/email', $requests[0]['url']);
        $this->assertContains('api-key: xkeysib-test-key', $requests[0]['options']['headers']);

        $payload = json_decode($requests[0]['options']['body'], true);
        $this->assertSame('sender@example.com', $payload['sender']['email']);
        $this->assertSame('guest@example.com', $payload['to'][0]['email']);
    }
}
