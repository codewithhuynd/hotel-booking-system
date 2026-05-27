<!-- CONTACT -->
<section id="contact" style="padding:0 0 100px;">

    <div class="section-title">

        <div>

            <h2>
                Contact Us
            </h2>

            <p>
                Liên hệ với chúng tôi để được hỗ trợ nhanh chóng.
            </p>

        </div>

    </div>

    <div class="info-strip">

        <div class="info-card">

            <h4>
                Hotline
            </h4>

            <p>
                {{ $hotelSetting->hotline }}
            </p>

        </div>

        <div class="info-card">

            <h4>
                Email
            </h4>

            <p>
                {{ $hotelSetting->email }}
            </p>

        </div>

        <div class="info-card">

            <h4>
                Address
            </h4>

            <p>
                {{ $hotelSetting->address }}
            </p>

        </div>

        <div class="info-card">

            <h4>
                Working Hours
            </h4>

            <p>
                {{ $hotelSetting->working_hours }}
            </p>

        </div>
        <div class="info-card">

            <h4>
                FaceBook
            </h4>

            <p>
                {{ $hotelSetting->facebook_link }}
            </p>

        </div>
        <div class="info-card">

            <h4>
                Map
            </h4>

            <p>
                {{ $hotelSetting->google_map_link }}
            </p>

        </div>

        <div class="info-card">
            {{-- Chỉ hiển thị form gửi liên hệ nếu KHÔNG phải host --}}
            @unless(Auth::check() && Auth::user()->role === 'host')
            <form method="POST" action="{{ route('contact-messages.store') }}" style="margin-top:12px;">
                @csrf

                @auth
                {{-- User thường hoặc guest đã đăng nhập --}}
                <input type="text" name="name" value="{{ old('name', Auth::user()->full_name) }}" placeholder="Your name" style="margin-bottom:12px;">
                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" placeholder="Your email" style="margin-bottom:12px;">
                @else
                {{-- Chưa đăng nhập --}}
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Your name" style="margin-bottom:12px;">
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Your email" style="margin-bottom:12px;">
                @endauth

                <textarea name="message" placeholder="Your message" style="width:100%; min-height:120px; padding:15px; border-radius:14px; border:1px solid #dbe3ee; background:#f8fafc; resize:none; margin-bottom:12px; font-family:Poppins,sans-serif;">{{ old('message') }}</textarea>

                <button type="submit" class="btn btn-white" style="width:100%;">Send Message</button>
            </form>
            @else
            {{-- Thông báo hoặc để trống cho host --}}
            <p style="color: #cbd5e1; text-align: center;">Bạn đang là quản trị viên, hãy dùng trang quản lý để xem tin nhắn.</p>
            @endunless
        </div>

    </div>

</section>
