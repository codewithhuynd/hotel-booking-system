<!-- LIÊN HỆ -->
<section id="contact" class="contact-section">

    <div class="section-title">

        <div>

            <span class="section-badge contact-badge">
                LIÊN HỆ VỚI CHÚNG TÔI
            </span>

            <h2>
                Liên Hệ
            </h2>

            <p>
                Liên hệ với chúng tôi để được hỗ trợ nhanh chóng.
            </p>

        </div>

    </div>

    <div class="contact-grid">

        <!-- THÔNG TIN LIÊN HỆ -->
        <div class="contact-info-wrapper">

            <div class="contact-card">

                <div class="contact-icon">
                    <i class="fa-solid fa-phone"></i>
                </div>

                <div>
                    <h4>Hotline</h4>
                    <p>{{ $hotelSetting->hotline }}</p>
                </div>

            </div>

            <div class="contact-card">

                <div class="contact-icon">
                    <i class="fa-solid fa-envelope"></i>
                </div>

                <div>
                    <h4>Email</h4>
                    <p>{{ $hotelSetting->email }}</p>
                </div>

            </div>

            <div class="contact-card">

                <div class="contact-icon">
                    <i class="fa-solid fa-location-dot"></i>
                </div>

                <div>
                    <h4>Địa Chỉ</h4>
                    <p>{{ $hotelSetting->address }}</p>
                </div>

            </div>

            <div class="contact-card">

                <div class="contact-icon">
                    <i class="fa-solid fa-clock"></i>
                </div>

                <div>
                    <h4>Giờ Làm Việc</h4>
                    <p>{{ $hotelSetting->working_hours }}</p>
                </div>

            </div>

            <div class="contact-card">

                <div class="contact-icon">
                    <i class="fa-brands fa-facebook-f"></i>
                </div>

                <div>
                    <h4>Facebook</h4>

                    <a href="{{ $hotelSetting->facebook_link }}"
                        target="_blank"
                        class="contact-link">
                        Truy Cập Trang
                    </a>
                </div>

            </div>

            <div class="contact-map-card">

                <div class="map-header">

                    <div class="contact-icon">
                        <i class="fa-solid fa-map-location-dot"></i>
                    </div>

                    <div>
                        <h4>Bản Đồ Google</h4>
                        <p>Xem vị trí khách sạn trực tiếp</p>
                    </div>

                </div>

                <div class="map-frame">

                    {!! $hotelSetting->google_map_embed !!}

                </div>

            </div>

        </div>

        <!-- FORM LIÊN HỆ -->
        <div class="contact-form-box">

            <h3>
                Gửi Tin Nhắn
            </h3>

            <p>
                Chúng tôi sẽ phản hồi bạn trong thời gian sớm nhất.
            </p>

            @if(session('success'))
                <div style="margin-bottom: 14px; padding: 10px 12px; border-radius: 10px; background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; font-size: 14px; font-weight: 500;">
                    {{ session('success') }}
                </div>
            @endif

            @unless(auth()->check() && auth()->user()->role === 'host')

            <form method="POST"
                action="{{ route('contact-messages.store') }}">

                @csrf

                @auth

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', Auth::user()->full_name) }}"
                    placeholder="Tên của bạn">

                <input
                    type="email"
                    name="email"
                    value="{{ old('email', Auth::user()->email) }}"
                    placeholder="Email của bạn">

                @else

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Tên của bạn">

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Email của bạn">

                @endauth

                <textarea
                    name="message"
                    placeholder="Nội dung tin nhắn">{{ old('message') }}</textarea>

                <button
                    type="submit"
                    class="contact-submit-btn">

                    <i class="fa-solid fa-paper-plane"></i>

                    Gửi Tin Nhắn

                </button>

            </form>

            @else

            <div class="host-message">

                <i class="fa-solid fa-shield-halved"></i>

                <p>
                    Bạn đang là quản trị viên,
                    hãy dùng trang quản lý để xem tin nhắn.
                </p>

            </div>

            @endunless

        </div>

    </div>

</section>