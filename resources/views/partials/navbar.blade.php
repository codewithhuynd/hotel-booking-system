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

            @auth
            @php
                $notifications = Auth::user()
                    ->notifications()
                    ->latest()
                    ->take(8)
                    ->get();

                $unreadCount = Auth::user()
                    ->notifications()
                    ->where('is_read', false)
                    ->count();
            @endphp

            <div class="notification-wrapper">
                <button type="button" class="notification-btn" id="notificationToggle">
                    {{-- Icon chuông trắng --}}
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 7h18s-3 0-3-7"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>

                    @if($unreadCount > 0)
                        <span class="notification-badge">{{ $unreadCount }}</span>
                    @endif
                </button>

                <div class="notification-dropdown" id="notificationDropdown">
                    <div class="notification-header">
                        <strong>Thông báo</strong>

                        @if($unreadCount > 0)
                            <form action="{{ route('notifications.readAll') }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit">Đọc tất cả</button>
                            </form>
                        @endif
                    </div>

                    <div class="notification-list">
                        @forelse($notifications as $notification)
                            <form action="{{ route('notifications.read', $notification) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        class="notification-item {{ !$notification->is_read ? 'unread' : '' }}">
                                    <span>{{ $notification->title ?? 'Thông báo mới' }}</span>
                                    <small>{{ $notification->message ?? '' }}</small>
                                </button>
                            </form>
                        @empty
                            <div class="notification-empty">
                                Chưa có thông báo nào.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            @endauth

            @if(Auth::user()->role === 'host')

            <a
                href="{{ route('host.dashboard') }}"
                class="btn btn-dark">
                Dashboard
            </a>

            @endif

            <div class="user-dropdown">

                <button class="user-btn">
                    {{ Auth::user()->full_name }} ▼
                </button>

                <div class="dropdown-menu">

                    @if(Auth::user()->role === 'guest')

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