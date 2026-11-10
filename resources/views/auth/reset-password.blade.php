<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu | Grand Elite Hotel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400..700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen bg-[#111318] text-gray-200 flex items-center justify-center px-4 font-sans">
    <main class="w-full max-w-md rounded-2xl border border-gray-800 bg-[#16181F] p-8 shadow-2xl sm:p-12">
        <p class="text-xs uppercase tracking-[0.3em] text-amber-400">Bảo mật tài khoản</p>
        <h1 class="mt-3 font-serif text-3xl text-white">Đặt lại mật khẩu</h1>
        <p class="mt-3 text-sm leading-relaxed text-gray-400">
            Tạo mật khẩu mới có ít nhất 8 ký tự.
        </p>

        @if ($errors->any())
            <div class="mt-6 rounded-lg border border-red-500/40 bg-red-950/40 p-4 text-sm text-red-200">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="mt-8 space-y-5">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div>
                <label for="email" class="mb-2 block text-sm text-gray-300">Địa chỉ email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $email) }}" required
                       autocomplete="email"
                       class="w-full rounded-lg border border-gray-700 bg-[#111318] px-4 py-3 text-white outline-none transition focus:border-amber-400">
            </div>
            <div>
                <label for="password" class="mb-2 block text-sm text-gray-300">Mật khẩu mới</label>
                <input id="password" name="password" type="password" required autocomplete="new-password"
                       class="w-full rounded-lg border border-gray-700 bg-[#111318] px-4 py-3 text-white outline-none transition focus:border-amber-400">
            </div>
            <div>
                <label for="password_confirmation" class="mb-2 block text-sm text-gray-300">Xác nhận mật khẩu mới</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                       autocomplete="new-password"
                       class="w-full rounded-lg border border-gray-700 bg-[#111318] px-4 py-3 text-white outline-none transition focus:border-amber-400">
            </div>
            <button type="submit"
                    class="w-full rounded-lg bg-amber-400 py-3 font-semibold text-[#111318] transition hover:bg-amber-300">
                Cập nhật mật khẩu
            </button>
        </form>
    </main>
</body>
</html>
