@extends('host.layouts.app')

@section('title', 'Tạo tài khoản host')

@section('content')

<style>
    /* Tổng thể & Typography */
    .form-container {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        max-width: 500px;
        margin: 2rem auto;
        padding: 0 20px;
        color: #1e293b;
    }
    .form-container h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #0f172a;
        margin-top: 0;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    /* Khối thông báo lỗi (Validation Errors) */
    .error-alert {
        background-color: #fef2f2;
        border: 1px solid #fee2e2;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    .error-alert-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: #dc2626;
        margin-bottom: 0.5rem;
    }
    .error-list {
        margin: 0;
        padding-left: 1.25rem;
        font-size: 0.875rem;
        color: #b91c1c;
    }
    .error-list li {
        margin-bottom: 0.25rem;
    }

    /* Khối thẻ chứa Form (Card) */
    .form-card {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    }

    /* Thành phần Form Group */
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-bottom: 1.25rem;
    }
    .form-group label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #475569;
    }

    /* Định dạng trường nhập liệu (Input) */
    .form-control {
        width: 100%;
        padding: 11px 14px;
        font-size: 0.95rem;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        color: #0f172a;
        background-color: #fff;
        box-sizing: border-box;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }
    .form-control:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }
    .form-control::placeholder {
        color: #94a3b8;
    }

    /* Nút Submit hành động */
    .btn-submit {
        width: 100%;
        padding: 12px 24px;
        background: #4f46e5;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.95rem;
        font-weight: 600;
        margin-top: 0.5rem;
        transition: background-color 0.15s ease;
    }
    .btn-submit:hover {
        background: #4338ca;
    }

    /* Liên kết điều hướng phụ ở chân trang (Footer links) */
    .form-footer-nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1.5rem;
        padding: 0 4px;
        font-size: 0.875rem;
    }
    .form-link {
        color: #64748b;
        text-decoration: none;
        transition: color 0.15s ease;
    }
    .form-link:hover {
        color: #4f46e5;
        text-decoration: underline;
    }
    .nav-divider {
        color: #cbd5e1;
    }
</style>

<div class="form-container">

    <h1>Tạo tài khoản host</h1>

    <!-- Thông báo lỗi kiểm định dữ liệu -->
    @if ($errors->any())
        <div class="error-alert">
            <div class="error-alert-title">Vui lòng kiểm tra lại thông tin:</div>
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">
        <form method="POST" action="{{ route('host.register-host.store') }}">
            @csrf

            <!-- Họ và tên -->
            <div class="form-group">
                <label for="full_name">Họ và tên</label>
                <input 
                    type="text" 
                    name="full_name" 
                    id="full_name"
                    class="form-control"
                    placeholder="Nhập họ và tên" 
                    value="{{ old('full_name') }}"
                >
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Địa chỉ Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email"
                    class="form-control"
                    placeholder="name@example.com" 
                    value="{{ old('email') }}"
                >
            </div>

            <!-- Mật khẩu -->
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password"
                    class="form-control"
                    placeholder="Tối thiểu 8 ký tự"
                >
            </div>

            <!-- Nhập lại mật khẩu -->
            <div class="form-group">
                <label for="password_confirmation">Xác nhận mật khẩu</label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation"
                    class="form-control"
                    placeholder="Nhập lại mật khẩu phía trên"
                >
            </div>

            <!-- Nút gửi form -->
            <button type="submit" class="btn-submit">
                Tạo tài khoản host
            </button>
        </form>
    </div>

    <!-- Thanh điều hướng chân trang -->
    <div class="form-footer-nav">
        <a href="{{ route('host.dashboard') }}" class="form-link">
            ← Về bảng điều khiển
        </a>
        <span class="nav-divider">·</span>
        <a href="{{ route('home') }}" class="form-link">
            Trang chủ
        </a>
    </div>

</div>

@endsection