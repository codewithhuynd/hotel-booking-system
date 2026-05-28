<!-- NAVBAR -->
<div class="navbar">

    <a href="/" class="logo">
        <div class="logo-icon">
            <i class="fa-solid fa-hotel"></i>
        </div>

        <div class="logo-text">
            Dolphins
            <span>Khách Sạn Sang Trọng</span>
        </div>
    </a>

    <div class="nav-wrapper">

        <div class="nav-left">

            <a href="#rooms" class="nav-link nav-rooms">
                <i class="fa-solid fa-bed"></i>
                <span>Phòng</span>
            </a>

            <a href="#about" class="nav-link nav-about">
                <i class="fa-solid fa-circle-info"></i>
                <span>Giới Thiệu</span>
            </a>

            <a href="#services" class="nav-link nav-services">
                <i class="fa-solid fa-bell-concierge"></i>
                <span>Dịch Vụ</span>
            </a>

            <a href="#contact" class="nav-link nav-contact">
                <i class="fa-solid fa-envelope"></i>
                <span>Liên Hệ</span>
            </a>

        </div>

        <div class="nav-right">

            @guest

            <a
                href="{{ route('login') }}"
                class="auth-btn login-btn">

                <i class="fa-solid fa-right-to-bracket"></i>

                <span>Đăng Nhập</span>

            </a>

            <a
                href="{{ route('register') }}"
                class="auth-btn register-btn">

                <i class="fa-solid fa-user-plus"></i>

                <span>Đăng Ký</span>

            </a>

            @else

            @php
                $user = auth()->user();
                $unreadNotifications = $user ? $user->unreadNotifications()->latest()->limit(5)->get() : collect();
                $unreadCount = $unreadNotifications->count();
                $latestNotification = $unreadNotifications->first();
            @endphp

            <a href="{{ route('notifications.index') }}" class="relative inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-200">
                <i class="fa-solid fa-bell"></i>
                <span>Thông báo</span>
                @if($unreadCount > 0)
                    <span class="absolute -top-1 -right-1 inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-rose-500 px-1 text-[10px] text-white">{{ $unreadCount }}</span>
                @endif
            </a>

            @if($user->role === 'host')

            <a
                href="{{ route('host.dashboard') }}"
                class="btn btn-dark">
                Dashboard
            </a>

            @endif

            <div class="user-dropdown">

                <button class="user-btn">
                    {{ $user->full_name }} ▼
                </button>

                <div class="dropdown-menu">

                    @if($user->role === 'guest')

                    <a
                        href="{{ route('guest.bookings.index') }}"
                        class="dropdown-item">
                        My Bookings
                    </a>

                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        My Profile
                    </a>

                    @endif

                    <form
                        method="POST"
                        action="{{ route('logout') }}">

                        @csrf

                        <button
                            type="submit"
                            class="dropdown-item logout-btn">
                            Logout
                        </button>

                    </form>

                </div>

            </div>

            @endguest

        </div>

    </div>

</div>