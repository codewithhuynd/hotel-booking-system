<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác thực email - DolPHPhins Hotel</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f9; font-family: 'Inter', Arial, Helvetica, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f4f6f9;">
        <tr>
            <td align="center" style="padding:40px 20px;">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0" style="background-color:#ffffff; border-radius:20px; overflow:hidden; box-shadow:0 8px 24px rgba(0,0,0,0.06);">
                    <!-- Header -->
                    <tr>
                        <td style="background-color:#0f172a; padding:40px 30px; text-align:center;">
                            <h1 style="color:#ffffff; font-size:28px; font-weight:700; margin:0; font-family:'Playfair Display', Georgia, serif;">🏨 DolPHPhins Hotel</h1>
                        </td>
                    </tr>
                    <!-- Body -->
                    <tr>
                        <td style="padding:48px 40px; color:#1e293b;">
                            <h2 style="font-size:24px; font-weight:700; margin-top:0; margin-bottom:20px; color:#0f172a;">Xác thực địa chỉ email của bạn</h2>
                            <p style="font-size:16px; line-height:1.7; color:#475569; margin:0 0 20px;">Xin chào <strong>{{ $user->full_name }}</strong>,</p>
                            <p style="font-size:16px; line-height:1.7; color:#475569; margin:0 0 30px;">Cảm ơn bạn đã đăng ký tài khoản tại DolPHPhins Hotel. Vui lòng nhấp vào nút bên dưới để xác thực email và bắt đầu trải nghiệm đặt phòng.</p>
                            <!-- Nút Xác thực ngay (inline toàn bộ) -->
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="margin:0 auto;">
                                <tr>
                                    <td align="center" style="background: linear-gradient(135deg, #10b981, #059669); padding:16px 40px; border-radius:12px; box-shadow:0 6px 20px rgba(16,185,129,0.4);">
                                        <a href="{{ $url }}" target="_blank" style="color:#ffffff; text-decoration:none; font-weight:700; font-size:18px; font-family:'Inter', Arial, sans-serif; display:inline-block; letter-spacing:0.5px;">Xác thực ngay</a>
                                    </td>
                                </tr>
                            </table>
                            <p style="font-size:14px; color:#64748b; margin:30px 0 20px; text-align:center;">Liên kết này sẽ hết hạn sau <strong>24 tiếng</strong>.</p>
                            <p style="font-size:14px; color:#94a3b8; margin:0; text-align:center;">Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email.</p>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#f8fafc; padding:24px 30px; text-align:center; font-size:13px; color:#64748b; border-top:1px solid #e2e8f0;">
                            © 2026 DolPHPhins Hotel. Tất cả quyền được bảo lưu.<br>
                            <a href="{{ url('/') }}" style="color:#475569; text-decoration:underline;">Về trang chủ</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>