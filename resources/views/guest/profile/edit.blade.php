<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #111827;
        }

        .wrapper {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            padding: 28px;
            margin-bottom: 24px;
        }

        h1, h2 {
            margin-top: 0;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            outline: none;
            font-size: 15px;
        }

        input:focus {
            border-color: #2563eb;
        }

        .btn {
            display: inline-block;
            border: none;
            border-radius: 10px;
            padding: 12px 18px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-primary {
            background: #2563eb;
            color: #fff;
        }

        .btn-dark {
            background: #111827;
            color: #fff;
        }

        .text-danger {
            color: #dc2626;
            font-size: 14px;
            margin-top: 6px;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }

        .grid {
            display: grid;
            gap: 24px;
        }
    </style>
</head>
<body>

<div class="wrapper">

    <a href="{{ route('home') }}" class="back-link">← Quay về trang chủ</a>

    <h1>Quản lý tài khoản</h1>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            <strong>Có lỗi xảy ra:</strong>
            <ul style="margin:8px 0 0 18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid">

        {{-- UPDATE PROFILE --}}
        <div class="card">
            <h2>Thông tin cá nhân</h2>

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf

                <div class="form-group">
                    <label for="full_name">Họ và tên</label>
                    <input
                        type="text"
                        id="full_name"
                        name="full_name"
                        value="{{ old('full_name', $user->full_name) }}"
                        placeholder="Nhập họ tên"
                    >
                    @error('full_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        value="{{ old('phone', $user->phone) }}"
                        placeholder="Nhập số điện thoại"
                    >
                    @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="birthday">Ngày sinh</label>
                    <input
                        type="date"
                        id="birthday"
                        name="birthday"
                        value="{{ old('birthday', optional($user->birthday)->format('Y-m-d')) }}"
                    >
                    @error('birthday')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Cập nhật thông tin
                </button>
            </form>
        </div>

        {{-- CHANGE PASSWORD --}}
        <div class="card">
            <h2>Đổi mật khẩu</h2>

            <form method="POST" action="{{ route('profile.change-password') }}">
                @csrf

                <div class="form-group">
                    <label for="current_password">Mật khẩu hiện tại</label>
                    <input
                        type="password"
                        id="current_password"
                        name="current_password"
                        placeholder="Nhập mật khẩu hiện tại"
                    >
                    @error('current_password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="new_password">Mật khẩu mới</label>
                    <input
                        type="password"
                        id="new_password"
                        name="new_password"
                        placeholder="Nhập mật khẩu mới"
                    >
                    @error('new_password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="new_password_confirmation">Nhập lại mật khẩu mới</label>
                    <input
                        type="password"
                        id="new_password_confirmation"
                        name="new_password_confirmation"
                        placeholder="Nhập lại mật khẩu mới"
                    >
                </div>

                <button type="submit" class="btn btn-dark">
                    Đổi mật khẩu
                </button>
            </form>
        </div>

    </div>
</div>

</body>
</html>