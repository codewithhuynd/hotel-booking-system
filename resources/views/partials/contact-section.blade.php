<!-- CONTACT -->
<section id="contact" class="contact-section">

    <div class="section-title">

        <div>

            <span class="section-badge contact-badge">
                CONTACT US
            </span>

            <h2>
                Contact Us
            </h2>

            <p>
                Liên hệ với chúng tôi để được hỗ trợ nhanh chóng.
            </p>

        </div>

    </div>

    <div class="contact-grid">

        <!-- LEFT INFO -->
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
                    <h4>Address</h4>
                    <p>{{ $hotelSetting->address }}</p>
                </div>

            </div>

            <div class="contact-card">

                <div class="contact-icon">
                    <i class="fa-solid fa-clock"></i>
                </div>

                <div>
                    <h4>Working Hours</h4>
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
                        Visit Page
                    </a>
                </div>

            </div>

            <div class="contact-map-card">

                <div class="map-header">

                    <div class="contact-icon">
                        <i class="fa-solid fa-map-location-dot"></i>
                    </div>

                    <div>
                        <h4>Google Map</h4>
                        <p>Xem vị trí khách sạn trực tiếp</p>
                    </div>

                </div>

                <div class="map-frame">

                    {!! $hotelSetting->google_map_embed !!}

                </div>

            </div>

        </div>

        <!-- RIGHT FORM -->
        <div class="contact-form-box">

            <h3>
                Send Message
            </h3>

            <p>
                Chúng tôi sẽ phản hồi bạn trong thời gian sớm nhất.
            </p>

            @unless(Auth::check() && Auth::user()->role === 'host')

            <form method="POST"
                action="{{ route('contact-messages.store') }}">

                @csrf

                @auth

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', Auth::user()->full_name) }}"
                    placeholder="Your name">

                <input
                    type="email"
                    name="email"
                    value="{{ old('email', Auth::user()->email) }}"
                    placeholder="Your email">

                @else

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Your name">

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Your email">

                @endauth

                <textarea
                    name="message"
                    placeholder="Your message">{{ old('message') }}</textarea>

                <button
                    type="submit"
                    class="contact-submit-btn">

                    <i class="fa-solid fa-paper-plane"></i>

                    Send Message

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