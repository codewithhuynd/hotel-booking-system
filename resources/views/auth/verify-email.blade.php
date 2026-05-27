<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vui lòng xác thực email | Grand Elite Hotel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..700;1,400..700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen bg-gray-950 text-gray-100 flex items-center justify-center px-4">
    <div class="w-full max-w-3xl bg-[#111318] rounded-3xl shadow-2xl overflow-hidden border border-gray-800">
        <div class="grid grid-cols-1 lg:grid-cols-2">
            <div class="hidden lg:block bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&q=80&w=1200');"></div>
            <div class="p-10 lg:p-14">
                <div class="space-y-6">
                    <div>
                        <p class="text-sm uppercase tracking-[0.35em] text-gold-300 font-semibold">Xác thực Email</p>
                        <h1 class="mt-4 text-3xl font-serif text-white">Hoàn tất đăng ký bằng Gmail</h1>
                        <p class="mt-3 text-sm text-gray-400 leading-relaxed">Một liên kết xác thực đã được gửi đến email của bạn. Vui lòng mở Gmail, nhấp vào liên kết để kích hoạt tài khoản và tiếp tục đặt phòng.</p>
                    </div>

                    @if (session('status') === 'verification-link-sent')
                        <div class="rounded-2xl bg-emerald-900/70 border border-emerald-500 p-4 text-emerald-200">
                            <strong>Đã gửi lại!</strong> Một email xác thực mới đã được gửi đến địa chỉ của bạn.
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="rounded-2xl bg-emerald-900/70 border border-emerald-500 p-4 text-emerald-200">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="rounded-3xl bg-[#171a20] border border-gray-800 p-6 space-y-5">
                        <div class="space-y-3">
                            <p class="text-sm text-gray-400">Email hiện tại của bạn:</p>
                            <p class="text-base text-white font-semibold">{{ auth()->user()->email }}</p>
                        </div>

                        <div class="space-y-3 text-sm text-gray-300">
                            <p>Nếu bạn chưa nhận được email:</p>
                            <ul class="list-disc list-inside space-y-2 text-gray-400">
                                <li>Kiểm tra thư mục Spam / Quảng cáo.</li>
                                <li>Đảm bảo rằng địa chỉ email bạn đăng ký là chính xác.</li>
                                <li>Nhấn nút dưới đây để gửi lại email xác thực.</li>
                            </ul>
                        </div>

                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="w-full inline-flex justify-center rounded-xl bg-gold-400 px-5 py-3 text-sm font-semibold text-[#111318] transition hover:bg-gold-300">Gửi lại email xác thực</button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}" class="text-center">
                            @csrf
                            <button type="submit" class="text-xs uppercase tracking-[0.35em] text-gray-400 hover:text-white transition">Đăng xuất / Dùng email khác</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
