<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập | Grand Elite Hotel</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Serif cho tiêu đề sang trọng & Sans-serif cho nội dung dễ đọc -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..700;1,400..700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['"Playfair Display"', 'serif'],
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        gold: {
                            50: '#FDFBF7',
                            100: '#F5EFEB',
                            200: '#E6D7CB',
                            300: '#D7BFAC',
                            400: '#C5A880', /* Vàng Champagne chủ đạo */
                            500: '#B39268',
                            600: '#9C7A53',
                            700: '#7B5E40',
                            800: '#5A432F',
                            900: '#3D2D20',
                        },
                        luxury: {
                            dark: '#111318', /* Màu than đá hoàng gia */
                            charcoal: '#1E2129',
                            cream: '#FCF9F4'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Hiệu ứng focus mượt mà và chuyển động tinh tế */
        .luxury-input:focus ~ label,
        .luxury-input:not(:placeholder-shown) ~ label {
            transform: translateY(-1.25rem) scale(0.85);
            color: #C5A880;
        }
    </style>
</head>
<body class="font-sans bg-luxury-dark text-gray-200 min-h-screen flex items-center justify-center overflow-x-hidden">

    <div class="w-full min-h-screen flex flex-col md:flex-row shadow-2xl overflow-hidden">
        
        <!-- Bên trái: Hình ảnh khách sạn sang trọng và Lời chào (Ẩn trên mobile nhỏ) -->
        <div class="relative hidden md:flex md:w-1/2 lg:w-3/5 bg-luxury-charcoal items-center justify-center overflow-hidden">
            <!-- Hình nền luxury hotel chất lượng cao kèm lớp overlay làm tối nghệ thuật -->
            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-[10000ms] hover:scale-105" 
                 style="background-image: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&q=80&w=1600');">
            </div>
            <!-- Lớp phủ dải màu sang trọng (Gradient Overlay) -->
            <div class="absolute inset-0 bg-gradient-to-t from-luxury-dark via-luxury-dark/60 to-transparent"></div>
            
            <!-- Nội dung thương hiệu phía trên hình nền -->
            <div class="relative z-10 p-12 lg:p-20 flex flex-col justify-between h-full w-full max-w-2xl">
                <!-- Logo / Tên khách sạn phía trên -->
                <div class="flex items-center space-x-3">
                    <span class="font-serif text-2xl tracking-[0.2em] text-gold-400 font-semibold">THE GRAND ELITE</span>
                </div>
                
                <!-- Câu chào thương hiệu ở giữa/dưới -->
                <div class="space-y-6 mb-10">
                    <div class="w-16 h-[2px] bg-gold-400"></div>
                    <h2 class="font-serif text-4xl lg:text-5xl leading-tight text-white font-light">
                        Nơi giao thoa giữa <br>
                        <span class="italic text-gold-300 font-normal">Sự Đẳng Cấp</span> & <span class="font-normal">Sự Riêng Tư</span>
                    </h2>
                    <p class="text-gray-300 text-sm max-w-md tracking-wide leading-relaxed font-light">
                        Chào mừng Quý khách trở lại. Hãy đăng nhập để tiếp tục tận hưởng những dịch vụ đặc quyền cao cấp và cá nhân hóa tối đa dành riêng cho bạn.
                    </p>
                </div>
                

            </div>
        </div>

        <!-- Bên phải: Form đăng nhập thanh lịch -->
        <div class="w-full md:w-1/2 lg:w-2/5 bg-[#16181F] p-8 sm:p-12 lg:p-16 flex flex-col justify-between relative">
            
            <!-- Logo hiển thị trên mobile -->
            <div class="flex md:hidden justify-center mb-8">
                <span class="font-serif text-xl tracking-[0.25em] text-gold-400 font-bold border-b border-gold-400/30 pb-2">THE GRAND ELITE</span>
            </div>

            <div class="my-auto max-w-md w-full mx-auto space-y-8">
                <!-- Tiêu đề Form -->
                <div class="text-center md:text-left space-y-2">
                    <span class="text-xs uppercase tracking-[0.3em] text-gold-400 font-medium">Chào mừng Quý khách</span>
                    <h1 class="font-serif text-3xl sm:text-4xl text-white font-light tracking-wide">Đăng Nhập</h1>
                    <p class="text-gray-400 text-sm">Vui lòng cung cấp thông tin tài khoản thành viên</p>
                </div>

                <!-- Khối hiển thị lỗi (Laravel Errors) được tối ưu cực kỳ tinh tế -->
                @if ($errors->any())
                    <div class="bg-red-950/40 border border-red-500/30 rounded-lg p-4 text-sm text-red-200 space-y-1 backdrop-blur-sm">
                        <div class="flex items-center space-x-2 text-red-400 font-medium mb-1">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span>Đã xảy ra lỗi:</span>
                        </div>
                        <ul class="list-disc pl-5 space-y-1 text-xs text-red-300">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form Đăng nhập -->
                <form method="POST" action="/login" class="space-y-6">
                    @csrf

                    <!-- Trường Email -->
                    <div class="relative group">
                        <input type="email" 
                               name="email" 
                               placeholder=" " 
                               required
                               class="luxury-input w-full bg-transparent border-b-2 border-gray-700 focus:border-gold-400 text-white py-3 px-1 outline-none transition-all duration-300 tracking-wide text-sm placeholder-transparent">
                        <label class="absolute left-1 top-3 text-gray-500 text-sm tracking-wider pointer-events-none transition-all duration-300 transform origin-left uppercase">
                            Địa chỉ Email
                        </label>
                        <!-- Thanh trang trí hiệu ứng lan tỏa khi focus -->
                        <span class="absolute bottom-0 left-0 w-0 h-[2px] bg-gold-400 transition-all duration-300 group-focus-within:w-full"></span>
                    </div>

                    <!-- Trường Password -->
                    <div class="relative group">
                        <input type="password" 
                               name="password" 
                               placeholder=" " 
                               required
                               class="luxury-input w-full bg-transparent border-b-2 border-gray-700 focus:border-gold-400 text-white py-3 px-1 outline-none transition-all duration-300 tracking-wide text-sm placeholder-transparent">
                        <label class="absolute left-1 top-3 text-gray-500 text-sm tracking-wider pointer-events-none transition-all duration-300 transform origin-left uppercase">
                            Mật khẩu
                        </label>
                        <!-- Thanh trang trí hiệu ứng lan tỏa khi focus -->
                        <span class="absolute bottom-0 left-0 w-0 h-[2px] bg-gold-400 transition-all duration-300 group-focus-within:w-full"></span>
                    </div>


                    <!-- Nút Đăng nhập phong cách quý tộc -->
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-gold-600 to-gold-400 text-luxury-dark font-semibold tracking-widest uppercase text-xs py-4 px-6 rounded-sm shadow-lg hover:from-gold-500 hover:to-gold-300 focus:outline-none focus:ring-2 focus:ring-gold-400 focus:ring-offset-2 focus:ring-offset-luxury-dark transform active:scale-[0.98] transition-all duration-300">
                        Đăng Nhập
                    </button>
                </form>

                <!-- Đường chia thẩm mỹ -->
                <div class="relative flex items-center justify-center my-6">
                    <div class="border-t border-gray-800 w-full"></div>
                    <span class="absolute bg-[#16181F] px-4 text-xs tracking-widest text-gray-500 uppercase">Hoặc</span>
                </div>

                <!-- Footer liên kết: Đăng ký / Trang chủ -->
                <div class="flex justify-between items-center text-xs tracking-wider text-gray-400 border-t border-gray-800/60 pt-6">
                    <a href="{{ route('home') }}" class="flex items-center space-x-1.5 hover:text-gold-400 transition-all duration-300 group">
                        <svg class="w-3.5 h-3.5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span>Quay về Trang chủ</span>
                    </a>
                    <a href="{{ route('register') }}" class="flex items-center space-x-1.5 hover:text-gold-400 transition-all duration-300 group">
                        <span>Đăng ký khách mới</span>
                        <svg class="w-3.5 h-3.5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>

            
        </div>
    </div>

</body>
</html>