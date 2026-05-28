<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Mail\PasswordChangeConfirmationMail;
use App\Mail\PasswordChangedMail;
use App\Models\PasswordChangeRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('guest.profile.edit', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'full_name' => ['required', 'string', 'min:2', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^(0|\+84)[0-9]{9,10}$/'],
            'birthday' => ['nullable', 'date', 'before_or_equal:today'],
        ], [
            'full_name.required' => 'Vui lòng nhập họ và tên.',
            'full_name.min' => 'Họ và tên phải có ít nhất 2 ký tự.',
            'full_name.max' => 'Họ và tên không được vượt quá 100 ký tự.',
            'phone.regex' => 'Số điện thoại không đúng định dạng. Ví dụ: 0901234567 hoặc +84901234567.',
            'birthday.date' => 'Ngày sinh phải là ngày hợp lệ.',
            'birthday.before_or_equal' => 'Ngày sinh không được lớn hơn ngày hiện tại.',
        ]);

        /** @var User $user */
        $user = Auth::user();

        $user->update([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'birthday' => $request->birthday,
        ]);

        return back()->with('success', 'Cập nhật thông tin thành công');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed', 'regex:/^(?=.*[A-Za-z])(?=.*\d).+$/', 'different:current_password'],
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'new_password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'new_password.regex' => 'Mật khẩu mới phải chứa ít nhất 1 chữ cái và 1 số.',
            'new_password.different' => 'Mật khẩu mới phải khác mật khẩu hiện tại.',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Mật khẩu hiện tại không đúng.',
            ])->withInput();
        }

        try {
            $token = Str::random(64);

            $changeRequest = PasswordChangeRequest::create([
                'user_id' => $user->id,
                'token_hash' => hash('sha256', $token),
                'new_password_hash' => Hash::make($request->new_password),
                'expires_at' => now()->addMinutes(15),
            ]);

            Mail::to($user->email)->send(new PasswordChangeConfirmationMail($user, $changeRequest, $token));

            return back()->with('success', 'Vui lòng xác nhận đổi mật khẩu qua email.');
        } catch (\Throwable $e) {
            Log::error('Password change confirmation email failed.', [
                'user_id' => $user->id,
                'email' => $user->email,
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $message = config('app.debug')
                ? 'Không thể gửi email xác nhận. Chi tiết: ' . $e->getMessage()
                : 'Không thể gửi email xác nhận. Vui lòng thử lại sau.';

            return back()->with('error', $message)->withInput();
        }
    }

    public function confirmPasswordChange(string $token)
    {
        $tokenHash = hash('sha256', $token);

        $changeRequest = PasswordChangeRequest::query()
            ->where('token_hash', $tokenHash)
            ->first();

        if (! $changeRequest) {
            return redirect()->route('login')->with('error', 'Link xác nhận không hợp lệ hoặc đã bị hủy.');
        }

        if (! is_null($changeRequest->used_at) || $changeRequest->expires_at->isPast()) {
            return redirect()->route('login')->with('error', 'Link xác nhận đã hết hạn hoặc đã được sử dụng.');
        }

        /** @var User $user */
        $user = $changeRequest->user;

        $user->forceFill([
            'password' => $changeRequest->new_password_hash,
            'remember_token' => Str::random(60),
        ])->save();

        $changeRequest->markAsUsed();

        if (Schema::hasTable('sessions')) {
            DB::table('sessions')->where('user_id', $user->id)->delete();
        }

        if (Auth::check() && Auth::id() === $user->id) {
            Auth::logout();
        }

        Mail::to($user->email)->send(new PasswordChangedMail($user));

        return redirect()->route('login')->with('success', 'Mật khẩu của bạn đã được thay đổi thành công.');
    }
}