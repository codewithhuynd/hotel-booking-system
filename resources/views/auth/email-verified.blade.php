<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email đã xác thực | DolPHPhins Hotel</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #0a0f1a; color: #e2e8f0; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px; }
        .card { background: rgba(15,23,42,0.85); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.08); border-radius: 28px; padding: 48px 40px; max-width: 480px; width: 100%; text-align: center; box-shadow: 0 24px 48px rgba(0,0,0,0.4); }
        .icon { width: 72px; height: 72px; background: rgba(16,185,129,0.12); border: 2px solid rgba(16,185,129,0.25); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 28px; }
        .icon svg { width: 36px; height: 36px; stroke: #10b981; }
        h1 { font-family: 'Playfair Display', serif; font-size: 32px; font-weight: 700; color: #fff; margin-bottom: 12px; }
        p { color: #94a3b8; font-size: 15px; line-height: 1.6; margin-bottom: 32px; }
        .btn { display: inline-block; padding: 12px 28px; border-radius: 12px; font-weight: 600; font-size: 15px; text-decoration: none; transition: all 0.3s; }
        .btn-primary { background: #10b981; color: #fff; margin-right: 10px; }
        .btn-primary:hover { background: #059669; transform: translateY(-2px); }
        .btn-secondary { border: 1px solid rgba(255,255,255,0.2); color: #cbd5e1; }
        .btn-secondary:hover { border-color: rgba(255,255,255,0.4); color: #fff; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h1>Email đã được xác thực!</h1>
        <p>Tài khoản của bạn đã kích hoạt thành công. Bạn có thể đăng nhập để bắt đầu trải nghiệm đặt phòng.</p>
        <a href="{{ route('login') }}" class="btn btn-primary">Đăng nhập ngay</a>
        <a href="{{ route('home') }}" class="btn btn-secondary">Về trang chủ</a>
    </div>
</body>
</html>