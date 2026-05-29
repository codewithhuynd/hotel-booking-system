<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vui lòng xác thực email | Grand Elite Hotel</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400..700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        .font-serif { font-family: "Playfair Display", serif; }
    </style>
</head>

<body class="min-h-screen bg-gray-950 text-gray-100 flex items-center justify-center px-4">

<div class="w-full max-w-3xl bg-[#111318] rounded-3xl shadow-2xl overflow-hidden border border-gray-800">

    <div class="grid grid-cols-1 lg:grid-cols-2">

        <div class="hidden lg:block bg-cover bg-center"
             style="background-image:url('https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&q=80&w=1200');">
        </div>

        <div class="p-10 lg:p-14">

            <p class="text-sm uppercase tracking-[0.35em] text-amber-400 font-semibold">
                Xác thực Email
            </p>

            <h1 >
                Hoàn tất đăng ký bằng Gmail
            </h1>

            <p class="mt-3 text-sm text-gray-400 leading-relaxed">
                Một liên kết xác thực đã được gửi đến email của bạn. Vui lòng mở Gmail, nhấp vào liên kết để kích hoạt tài khoản.
            </p>

            @if (session('status') === 'verification-link-sent')
                <div class="mt-6 rounded-2xl bg-emerald-900/40 border border-emerald-500 p-4 text-emerald-200">
                    <strong>Đã gửi lại!</strong> Email xác thực mới đã được gửi.
                </div>
            @endif

            @if (session('success'))
                <div class="mt-6 rounded-2xl bg-emerald-900/40 border border-emerald-500 p-4 text-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mt-6 rounded-3xl bg-[#171a20] border border-gray-800 p-6 space-y-5">

                <div>
                    <p class="text-sm text-gray-400">Email hiện tại:</p>
                    <p class="text-base text-white font-semibold">
                        {{ auth()->user()->email }}
                    </p>
                </div>

                <div class="text-sm text-gray-300">
                    <p class="mb-2">Nếu bạn chưa nhận được email:</p>
                    <ul class="list-disc list-inside space-y-1 text-gray-400">
                        <li>Kiểm tra Spam / Quảng cáo</li>
                        <li>Kiểm tra email đăng ký</li>
                        <li>Gửi lại email xác thực</li>
                    </ul>
                </div>

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                        class="w-full rounded-xl bg-amber-400 hover:bg-amber-300 transition text-[#111318] font-semibold py-3">
                        Gửi lại email xác thực
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="text-center">
                    @csrf
                    <button type="submit"
                        class="text-xs uppercase tracking-[0.35em] text-gray-400 hover:text-white transition">
                        Đăng xuất / Dùng email khác
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>

</body>
</html>