<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hội Viên Đặc Quyền | Grand Elite Hotel</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Serif cho tiêu đề sang trọng & Sans-serif cho nội dung dễ đọc -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght=0,400..700;1,400..700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['"Playfair Display"', 'serif'],
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            slateDark: '#0f172a',      /* Deep slate primary dark */
                            white: '#ffffff',          /* Pure white elements */
                            grayLight: '#e2e8f0',      /* Border slate light */
                            grayMedium: '#cbd5e1',     /* Border focus active */
                            bluePrimary: '#2563eb',    /* Premium royal blue accent */
                            greenSuccess: '#16a34a',   /* Elegant alert green */
                            jetBlack: '#111827',       /* Ultimate head title dark */
                            textMuted: '#475569',      /* Medium slate for description label */
                            textDark: '#334155',       /* Slate 700 for text/buttons */
                            iceBlue: '#dbe3ee',        /* Cool background highlights */
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans bg-slate-50 text-brand-textDark min-h-screen pb-16 transition-colors duration-300">

    <!-- Thanh định hướng sang trọng ở trên cùng -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
        <div class="flex items-center justify-between border-b border-brand-grayLight pb-4 mb-8">
            <a href="{{ route('home') }}" class="flex items-center space-x-2 text-xs uppercase tracking-widest text-brand-textDark hover:text-brand-bluePrimary font-semibold transition-all duration-300 group">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform text-brand-bluePrimary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Về trang chủ</span>
            </a>
            <span class="font-serif text-sm tracking-[0.2em] text-brand-slateDark font-bold">THE DolPHPhins Hotel</span>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Khung Banner Chào Mừng Thượng Khách sử dụng tone xanh thẳm #0f172a và các lớp phủ mờ tinh tế -->
        <div class="relative bg-brand-slateDark rounded-2xl p-8 sm:p-10 shadow-lg border border-brand-grayMedium/10 mb-8 overflow-hidden">
            <!-- Họa tiết trừu tượng với các lớp phủ mờ rgba(255, 255, 255, 0.08) đến 0.12 -->
            <div class="absolute right-0 bottom-0 pointer-events-none translate-x-10 translate-y-10 flex space-x-2">
                <div class="w-48 h-48 rounded-full bg-[rgba(255,255,255,0.08)] blur-xl"></div>
                <div class="w-32 h-32 rounded-full bg-[rgba(255,255,255,0.12)] blur-lg -translate-x-12 -translate-y-12"></div>
            </div>

            <div class="relative z-10 flex flex-col sm:flex-row items-center sm:space-x-6 text-center sm:text-left">
                <!-- Vòng tròn Avatar tinh tế mang ký tự đầu của khách phối tông nền xanh nhạt lạnh #dbe3ee -->
                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-brand-iceBlue to-brand-white flex items-center justify-center border-2 border-brand-bluePrimary/40 shadow-md mb-4 sm:mb-0">
                    <span class="font-serif text-2xl text-brand-slateDark font-semibold uppercase">
                        {{ substr($user->full_name ?? 'G', 0, 1) }}
                    </span>
                </div>
                <div>
                    
                    <h1 class="font-serif text-3xl sm:text-4xl text-brand-white mt-3 font-light tracking-wide">
                        Chào Quý Khách, <span class="font-normal text-brand-white">{{ $user->full_name }}</span>
                    </h1>
                   
                </div>
            </div>
        </div>

        <!-- Khu vực thông báo thành công sử dụng màu xanh lục quý tộc #16a34a -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-brand-greenSuccess/30 rounded-xl p-4 text-sm text-brand-greenSuccess flex items-center space-x-3 mb-8 shadow-sm">
                <svg class="w-5 h-5 text-brand-greenSuccess flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-semibold tracking-wide">{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 rounded-xl p-5 text-sm text-rose-800 mb-8 shadow-sm">
                <div class="flex items-center space-x-2 text-rose-700 font-semibold mb-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span>Phát hiện thông tin chưa hợp lệ:</span>
                </div>
                <ul class="list-disc pl-5 space-y-1 text-xs text-rose-600 font-medium">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Bố cục lưới chứa các Form cập nhật -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- CARD 1: CẬP NHẬT THÔNG TIN CÁ NHÂN -->
            <div class="bg-brand-white rounded-2xl p-6 sm:p-8 shadow-sm border border-brand-grayLight hover:border-brand-grayMedium transition-all duration-300 flex flex-col justify-between">
                <div>
                    <!-- Tiêu đề thẻ -->
                    <div class="border-b border-brand-grayLight pb-4 mb-6">
                        <h2 class="font-serif text-xl font-normal text-brand-jetBlack tracking-wide flex items-center">
                            <span class="w-1.5 h-6 bg-brand-bluePrimary rounded-full mr-3"></span>
                            Thông tin cá nhân
                        </h2>
                        <p class="text-xs text-brand-textMuted mt-1">Quản lý và cập nhật thông tin thành viên của bạn</p>
                    </div>

                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
                        @csrf

                        <!-- Họ và tên -->
                        <div class="space-y-1.5">
                            <label for="full_name" class="block text-xs uppercase tracking-wider text-brand-textMuted font-semibold">Họ và tên</label>
                            <input
                                type="text"
                                id="full_name"
                                name="full_name"
                                value="{{ old('full_name', $user->full_name) }}"
                                placeholder="Nhập họ tên đầy đủ"
                                class="w-full bg-brand-iceBlue/20 border border-brand-grayLight focus:border-brand-bluePrimary focus:ring-1 focus:ring-brand-bluePrimary rounded-lg px-4 py-3 text-sm outline-none transition-all duration-300 text-brand-jetBlack font-medium"
                            >
                            @error('full_name')
                                <div class="text-xs text-rose-600 mt-1 flex items-center font-medium">
                                    <span class="mr-1">⚠️</span> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Số điện thoại -->
                        <div class="space-y-1.5">
                            <label for="phone" class="block text-xs uppercase tracking-wider text-brand-textMuted font-semibold">Số điện thoại</label>
                            <input
                                type="text"
                                id="phone"
                                name="phone"
                                value="{{ old('phone', $user->phone) }}"
                                placeholder="Nhập số điện thoại"
                                class="w-full bg-brand-iceBlue/20 border border-brand-grayLight focus:border-brand-bluePrimary focus:ring-1 focus:ring-brand-bluePrimary rounded-lg px-4 py-3 text-sm outline-none transition-all duration-300 text-brand-jetBlack font-medium"
                            >
                            @error('phone')
                                <div class="text-xs text-rose-600 mt-1 flex items-center font-medium">
                                    <span class="mr-1">⚠️</span> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Ngày sinh -->
                        <div class="space-y-1.5">
                            <label for="birthday" class="block text-xs uppercase tracking-wider text-brand-textMuted font-semibold">Ngày sinh</label>
                            <input
                                type="date"
                                id="birthday"
                                name="birthday"
                                value="{{ old('birthday', optional($user->birthday)->format('Y-m-d')) }}"
                                class="w-full bg-brand-iceBlue/20 border border-brand-grayLight focus:border-brand-bluePrimary focus:ring-1 focus:ring-brand-bluePrimary rounded-lg px-4 py-3 text-sm outline-none transition-all duration-300 text-brand-textDark font-medium"
                            >
                            @error('birthday')
                                <div class="text-xs text-rose-600 mt-1 flex items-center font-medium">
                                    <span class="mr-1">⚠️</span> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Nút cập nhật thông tin màu xanh dương #2563eb -->
                        <div class="pt-4">
                            <button type="submit" class="w-full bg-brand-bluePrimary hover:bg-blue-700 text-brand-white font-medium tracking-wider text-xs uppercase py-3.5 px-6 rounded-lg shadow-sm hover:shadow transition-all duration-300 active:scale-[0.99]">
                                Cập nhật thông tin
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- CARD 2: ĐỔI MẬT KHẨU BẢO MẬT -->
            <div class="bg-brand-white rounded-2xl p-6 sm:p-8 shadow-sm border border-brand-grayLight hover:border-brand-grayMedium transition-all duration-300 flex flex-col justify-between">
                <div>
                    <!-- Tiêu đề thẻ -->
                    <div class="border-b border-brand-grayLight pb-4 mb-6">
                        <h2 class="font-serif text-xl font-normal text-brand-jetBlack tracking-wide flex items-center">
                            <span class="w-1.5 h-6 bg-brand-slateDark rounded-full mr-3"></span>
                            Đổi mật khẩu
                        </h2>
                        <p class="text-xs text-brand-textMuted mt-1">Thay đổi mật khẩu định kỳ để bảo đảm an toàn</p>
                    </div>

                    <form method="POST" action="{{ route('profile.change-password') }}" class="space-y-5">
                        @csrf

                        <!-- Mật khẩu hiện tại -->
                        <div class="space-y-1.5">
                            <label for="current_password" class="block text-xs uppercase tracking-wider text-brand-textMuted font-semibold">Mật khẩu hiện tại</label>
                            <input
                                type="password"
                                id="current_password"
                                name="current_password"
                                placeholder="••••••••"
                                class="w-full bg-brand-iceBlue/20 border border-brand-grayLight focus:border-brand-bluePrimary focus:ring-1 focus:ring-brand-bluePrimary rounded-lg px-4 py-3 text-sm outline-none transition-all duration-300 text-brand-jetBlack"
                            >
                            @error('current_password')
                                <div class="text-xs text-rose-600 mt-1 flex items-center font-medium">
                                    <span class="mr-1">⚠️</span> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Mật khẩu mới -->
                        <div class="space-y-1.5">
                            <label for="new_password" class="block text-xs uppercase tracking-wider text-brand-textMuted font-semibold">Mật khẩu mới</label>
                            <input
                                type="password"
                                id="new_password"
                                name="new_password"
                                placeholder="••••••••"
                                class="w-full bg-brand-iceBlue/20 border border-brand-grayLight focus:border-brand-bluePrimary focus:ring-1 focus:ring-brand-bluePrimary rounded-lg px-4 py-3 text-sm outline-none transition-all duration-300 text-brand-jetBlack"
                            >
                            @error('new_password')
                                <div class="text-xs text-rose-600 mt-1 flex items-center font-medium">
                                    <span class="mr-1">⚠️</span> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Xác nhận mật khẩu mới -->
                        <div class="space-y-1.5">
                            <label for="new_password_confirmation" class="block text-xs uppercase tracking-wider text-brand-textMuted font-semibold">Xác nhận mật khẩu mới</label>
                            <input
                                type="password"
                                id="new_password_confirmation"
                                name="new_password_confirmation"
                                placeholder="••••••••"
                                class="w-full bg-brand-iceBlue/20 border border-brand-grayLight focus:border-brand-bluePrimary focus:ring-1 focus:ring-brand-bluePrimary rounded-lg px-4 py-3 text-sm outline-none transition-all duration-300 text-brand-jetBlack"
                            >
                        </div>

                        <!-- Nút đổi mật khẩu màu đen phiến đá #0f172a -->
                        <div class="pt-4">
                            <button type="submit" class="w-full bg-brand-slateDark hover:bg-brand-jetBlack text-brand-white font-medium tracking-wider text-xs uppercase py-3.5 px-6 rounded-lg shadow-sm hover:shadow transition-all duration-300 active:scale-[0.99]">
                                Đổi mật khẩu
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

      

    </div>

</body>
</html>