<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác thực Email | DolPHPhins Hotel</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #0a0f1a;
            color: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            background-image:
                radial-gradient(ellipse at 20% 50%, rgba(16, 185, 129, 0.06) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(59, 130, 246, 0.05) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 80%, rgba(139, 92, 246, 0.04) 0%, transparent 50%);
        }

        .verify-wrapper {
            width: 100%;
            max-width: 520px;
        }

        .verify-card {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 28px;
            padding: 48px 40px;
            box-shadow: 0 32px 64px rgba(0, 0, 0, 0.4);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .verify-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #10b981, #3b82f6, #8b5cf6);
        }

        .verify-icon {
            width: 72px;
            height: 72px;
            background: rgba(16, 185, 129, 0.1);
            border: 2px solid rgba(16, 185, 129, 0.25);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 28px;
        }

        .verify-icon svg {
            width: 36px;
            height: 36px;
            stroke: #10b981;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .subtitle {
            color: #94a3b8;
            font-size: 15px;
            line-height: 1.7;
            margin-bottom: 24px;
        }

        .email-highlight {
            display: inline-block;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 6px 14px;
            color: #fff;
            font-weight: 500;
            font-size: 14px;
            margin-top: 6px;
        }

        .alert {
            padding: 14px 18px;
            border-radius: 14px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
            text-align: left;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.25);
            color: #6ee7b7;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 14px 28px;
            border-radius: 14px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 15px;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
            box-shadow: 0 8px 24px rgba(16, 185, 129, 0.25);
            margin-bottom: 12px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(16, 185, 129, 0.35);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px 24px;
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            background: transparent;
            color: #cbd5e1;
            cursor: pointer;
            font-weight: 500;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-secondary:hover {
            border-color: rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.04);
            color: #fff;
        }

        .footer-links {
            margin-top: 28px;
            font-size: 13px;
            color: #64748b;
        }

        .footer-links a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            color: #fff;
        }

        .divider {
            width: 40px;
            height: 3px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 2px;
            margin: 24px auto;
        }

        .expire-note {
            color: #f59e0b;
            font-size: 13px;
            margin-top: 16px;
        }
    </style>
</head>

<body>
    <div class="verify-wrapper">
        <div class="verify-card">

            <div class="verify-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>

            <h1>Xác thực Email của bạn</h1>

            <p class="subtitle">
                Chúng tôi đã gửi một liên kết xác thực đến
                <br>
                <span class="email-highlight">{{ Auth::user()->email }}</span>
            </p>

            @if(session('success'))
            <div class="alert alert-success">
                <svg style="display:inline; vertical-align:middle; margin-right:8px;" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
            @endif

            <p style="color: #94a3b8; font-size: 14px; line-height: 1.6; margin-bottom: 24px;">
                Hãy kiểm tra hộp thư đến (và cả thư mục spam) và nhấp vào nút xác thực trong email.
            </p>

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-primary">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Gửi lại email xác thực
                </button>
            </form>

            <form method="POST" action="{{ route('verification.cancel') }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-secondary">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Hủy đăng ký & Quay lại
                </button>
            </form>

            <div class="divider"></div>

            <div class="footer-links">
                <a href="{{ route('home') }}">← Quay về trang chủ</a>
            </div>

            <p class="expire-note">
                ⏳ Liên kết xác thực sẽ hết hạn sau 24 tiếng. Nếu quá hạn, bạn cần đăng ký lại.
            </p>

        </div>
    </div>
</body>

</html>