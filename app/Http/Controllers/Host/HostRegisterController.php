<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class HostRegisterController extends Controller
{
    public function create()
    {
        return view('host.register-host');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'host',
        ]);

        $verificationEmailSent = true;

        try {
            $user->sendEmailVerificationNotification();
        } catch (\Throwable $exception) {
            $verificationEmailSent = false;
            Log::warning('Unable to send host verification email after registration.', [
                'user_id' => $user->id,
                'exception' => $exception,
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        $response = redirect()->route('verification.notice');

        return $verificationEmailSent
            ? $response
            : $response->with('error', 'Tài khoản đã được tạo nhưng chưa gửi được email xác minh. Vui lòng kiểm tra SMTP và gửi lại.');
    }
}
