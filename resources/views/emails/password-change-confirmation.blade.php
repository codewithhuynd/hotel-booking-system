<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đổi mật khẩu</title>
</head>
<body style="margin:0; padding:0; background:#0f172a; font-family:Arial, sans-serif; color:#e2e8f0;">
    <div style="max-width:640px; margin:0 auto; background:linear-gradient(135deg,#111827,#1f2937); border-radius:24px; overflow:hidden; border:1px solid rgba(148,163,184,0.18);">
        <div style="padding:28px 28px 8px; text-align:center;">
            <div style="display:inline-block; padding:10px 14px; border-radius:999px; background:rgba(59,130,246,0.12); color:#bfdbfe; font-size:12px; text-transform:uppercase; letter-spacing:2px;">Dolphins Hotel</div>
            <h2 style="margin:16px 0 8px; font-size:28px; color:#fff;">Xác nhận đổi mật khẩu</h2>
            <p style="margin:0; color:#cbd5e1; line-height:1.6;">Chúng tôi nhận được yêu cầu đổi mật khẩu cho tài khoản <strong>{{ $user->email }}</strong>.</p>
        </div>

        <div style="padding:0 28px 28px;">
            <p style="margin:0 0 12px; color:#e5e7eb; line-height:1.7;">Nếu bạn là người thực hiện yêu cầu này, vui lòng xác nhận bằng nút bên dưới. Link này sẽ hết hạn vào <strong>{{ $expiresAt }}</strong>.</p>
            <p style="margin:0 0 20px; color:#fca5a5; font-size:13px;">Nếu bạn không yêu cầu đổi mật khẩu, hãy bỏ qua email này.</p>

            <div style="text-align:center; margin:18px 0 10px;">
                <a href="{{ $confirmUrl }}" style="display:inline-block; background:linear-gradient(135deg,#2563eb,#1d4ed8); color:#fff; text-decoration:none; padding:14px 22px; border-radius:14px; font-weight:700;">Xác nhận đổi mật khẩu</a>
            </div>
        </div>
    </div>
</body>
</html>
