<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_update_returns_vietnamese_validation_errors_for_invalid_input(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'role' => 'guest',
            'full_name' => 'Nguyễn Văn A',
            'phone' => '0901234567',
        ]);

        $this->actingAs($user)
            ->from(route('profile.edit'))
            ->post(route('profile.update'), [
                'full_name' => 'A',
                'phone' => 'abc',
                'birthday' => now()->addDay()->format('Y-m-d'),
            ])
            ->assertSessionHasErrors([
                'full_name',
                'phone',
                'birthday',
            ])
            ->assertSessionHasErrors([
                'full_name' => 'Họ và tên phải có ít nhất 2 ký tự.',
                'phone' => 'Số điện thoại không đúng định dạng. Ví dụ: 0901234567 hoặc +84901234567.',
                'birthday' => 'Ngày sinh không được lớn hơn ngày hiện tại.',
            ]);
    }
}
