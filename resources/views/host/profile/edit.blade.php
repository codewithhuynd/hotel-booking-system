@extends('host.layouts.app')

@section('title', 'Hồ sơ của tôi')

@section('content')

<style>
    .hp-wrap { font-family: 'Segoe UI', sans-serif; max-width: 1100px; }
    .hp-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; }
    .hp-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 20px; padding: 28px; }
    .hp-card h2 { margin: 0 0 6px; font-size: 18px; color: #0f172a; }
    .hp-card p.hp-sub { margin: 0 0 22px; font-size: 13px; color: #64748b; line-height: 1.6; }
    .hp-field { margin-bottom: 18px; }
    .hp-field label { display: block; margin-bottom: 8px; font-size: 12px; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 1px; }
    .hp-field input { width: 100%; padding: 13px 16px; border-radius: 14px; border: 1px solid #dbe2ea; background: #f8fafc; font-size: 15px; color: #0f172a; outline: none; box-sizing: border-box; transition: .2s; }
    .hp-field input:focus { border-color: #22c55e; background: #fff; box-shadow: 0 0 0 4px rgba(34, 197, 94, .12); }
    .hp-field input[readonly] { color: #64748b; cursor: not-allowed; }
    .hp-error { margin-top: 6px; font-size: 13px; color: #dc2626; }
    .hp-btn { border: none; border-radius: 14px; padding: 13px 22px; font-size: 14px; font-weight: 700; cursor: pointer; color: #fff; background: #16a34a; }
    .hp-btn.dark { background: #1e293b; }
    .hp-alert { padding: 14px 16px; border-radius: 10px; margin-bottom: 20px; font-weight: 600; }
    .hp-alert.ok { background: #f0fdf4; border-left: 4px solid #16a34a; color: #166534; }
    .hp-alert.err { background: #fef2f2; border-left: 4px solid #dc2626; color: #991b1b; }
</style>

<div class="hp-wrap">

    <h1 style="margin:0 0 6px;font-size:26px;color:#0f172a;">Hồ sơ của tôi</h1>
    <p style="margin:0 0 24px;color:#64748b;">Cập nhật thông tin cá nhân và đổi mật khẩu tài khoản host.</p>

    @if(session('success'))
        <div class="hp-alert ok">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="hp-alert err">{{ session('error') }}</div>
    @endif

    <div class="hp-grid">

        <!-- THÔNG TIN CÁ NHÂN -->
        <div class="hp-card">
            <h2>Thông tin cá nhân</h2>
            <p class="hp-sub">Email dùng để đăng nhập nên không thể thay đổi.</p>

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf

                <div class="hp-field">
                    <label>Email</label>
                    <input type="email" value="{{ $user->email }}" readonly>
                </div>

                <div class="hp-field">
                    <label for="full_name">Họ và tên</label>
                    <input id="full_name" type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}" required>
                    @error('full_name') <div class="hp-error">{{ $message }}</div> @enderror
                </div>

                <div class="hp-field">
                    <label for="phone">Số điện thoại</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="0901234567">
                    @error('phone') <div class="hp-error">{{ $message }}</div> @enderror
                </div>

                <div class="hp-field">
                    <label for="birthday">Ngày sinh</label>
                    <input id="birthday" type="date" name="birthday" max="{{ now()->format('Y-m-d') }}"
                        value="{{ old('birthday', optional($user->birthday)->format('Y-m-d')) }}">
                    @error('birthday') <div class="hp-error">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="hp-btn">Lưu thông tin</button>
            </form>
        </div>

        <!-- ĐỔI MẬT KHẨU -->
        <div class="hp-card">
            <h2>Đổi mật khẩu</h2>
            <p class="hp-sub">Mật khẩu mới tối thiểu 8 ký tự, gồm chữ và số. Hệ thống sẽ gửi link xác nhận (hiệu lực 15 phút) về email của bạn.</p>

            <form method="POST" action="{{ route('profile.change-password') }}">
                @csrf

                <div class="hp-field">
                    <label for="current_password">Mật khẩu hiện tại</label>
                    <input id="current_password" type="password" name="current_password" required>
                    @error('current_password') <div class="hp-error">{{ $message }}</div> @enderror
                </div>

                <div class="hp-field">
                    <label for="new_password">Mật khẩu mới</label>
                    <input id="new_password" type="password" name="new_password" minlength="8" required>
                    @error('new_password') <div class="hp-error">{{ $message }}</div> @enderror
                </div>

                <div class="hp-field">
                    <label for="new_password_confirmation">Xác nhận mật khẩu mới</label>
                    <input id="new_password_confirmation" type="password" name="new_password_confirmation" required>
                </div>

                <button type="submit" class="hp-btn dark">Đổi mật khẩu</button>
            </form>
        </div>

    </div>
</div>

@endsection
