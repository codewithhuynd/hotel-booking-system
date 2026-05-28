<!-- GIỚI THIỆU -->
<section id="about" class="about-section">

    <div class="section-title">

        <div>

            <span class="section-badge">
                GIỚI THIỆU KHÁCH SẠN
            </span>

            <h2>
                Về Khách Sạn Của Chúng Tôi
            </h2>

            <p>Trải nghiệm nghỉ dưỡng hiện đại, sang trọng và tiện nghi dành cho khách du lịch, gia đình và doanh nhân.</p>

        </div>

    </div>

    <div class="info-strip">

        @foreach($aboutSections as $about)

        <div class="info-card">

            <div class="info-icon">
                @if($loop->index == 0)
                    <i class="fa-solid fa-hotel"></i>
                @elseif($loop->index == 1)
                    <i class="fa-solid fa-spa"></i>
                @elseif($loop->index == 2)
                    <i class="fa-solid fa-wifi"></i>
                @elseif($loop->index == 3)
                    <i class="fa-solid fa-utensils"></i>
                @else
                    <i class="fa-solid fa-star"></i>
                @endif
            </div>

            <h4>
                {{ $about->title }}
            </h4>

            <p>
                {{ $about->description }}
            </p>

        </div>

        @endforeach

    </div>

</section>