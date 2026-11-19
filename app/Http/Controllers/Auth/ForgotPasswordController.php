<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function createLinkRequest()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        try {
            Password::sendResetLink($request->only('email'));
        } catch (\Throwable $exception) {
            Log::warning('Unable to send password reset email.', [
                'email' => $request->input('email'),
                'exception' => $exception,
            ]);

            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Hệ thống chưa gửi được email đặt lại mật khẩu. Vui lòng thử lại sau hoặc liên hệ khách sạn.']);
        }

        return redirect()->route('password.request')->with(
            'status',
            'Nếu địa chỉ email có trong hệ thống, hướng dẫn đặt lại mật khẩu sẽ được gửi đến email đó.'
        );
    }

    public function createResetForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $status = Password::reset(
            $validated,
            function (User $user, string $password): void {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with(
                'status',
                'Mật khẩu đã được đặt lại. Vui lòng đăng nhập bằng mật khẩu mới.'
            );
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Liên kết đặt lại mật khẩu không hợp lệ hoặc đã hết hạn. Vui lòng yêu cầu liên kết mới.',
            ]);
    }
}
