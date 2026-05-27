<!-- HERO -->
<section class="hero">

    <div class="hero-inner">

        <div class="hero-grid">

            <!-- LEFT -->
            <div class="hero-content">



                <!-- TITLE -->
                <h1>
                    {{ $hotelSetting->hero_title ?? 'Trải nghiệm nghỉ dưỡng đẳng cấp' }}
                </h1>

                <!-- DESCRIPTION -->
                <p class="hero-description">
                    {{ $hotelSetting->hero_description ?? 'Tận hưởng không gian sang trọng, phòng nghỉ hiện đại và dịch vụ cao cấp với trải nghiệm nghỉ dưỡng hoàn hảo.' }}
                </p>

                <!-- LOCATION -->
                <div class="hero-location">

                    <div class="location-item" id="openMapModal">

                        <i class="fa-solid fa-location-dot"></i>

                        <span>
                            {{ $hotelSetting->hotel_address ?? 'Trung tâm thành phố' }}
                        </span>

                    </div>

                    <div class="location-item">
                        <i class="fa-solid fa-water"></i>
                        <span>View biển cực đẹp</span>
                    </div>

                </div>

                <!-- ACTIONS -->
                <div class="hero-actions">

                    <a href="#rooms" class="btn btn-white">
                        <i class="fa-solid fa-bed"></i>
                        Khám phá phòng
                    </a>

                    @guest
                    <a
                        href="{{ route('login') }}"
                        class="btn btn-outline">

                        <i class="fa-solid fa-right-to-bracket"></i>
                        Đăng nhập đặt phòng
                    </a>
                    @endguest

                </div>

                <!-- RATING -->
                <div class="hero-rating">

                    <div class="rating-stars">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>

                    <span>
                        4.9/5 đánh giá từ hơn 2000 khách hàng
                    </span>

                </div>

                <!-- STATS -->
                <div class="hero-stats">

                    <div class="stat-chip">
                        <strong>100+</strong>
                        <span>Phòng cao cấp</span>
                    </div>

                    <div class="stat-chip">
                        <strong>24/7</strong>
                        <span>Hỗ trợ khách hàng</span>
                    </div>

                    <div class="stat-chip">
                        <strong>5000+</strong>
                        <span>Khách hài lòng</span>
                    </div>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="hero-card-wrapper">

                <!-- BOOKING CARD -->

                <!-- HIGHLIGHTS -->
                <div class="hero-card highlights-card">

                    <div class="card-header">

                        <div>
                            <h3>Điểm nổi bật</h3>

                            <p>
                                Những giá trị giúp khách hàng tin tưởng
                            </p>
                        </div>



                    </div>

                    <div class="card-list">

                        <div class="card-item">

                            <div class="item-icon">
                                <i class="fa-solid fa-bolt"></i>
                            </div>

                            <div>
                                <strong>Đặt phòng siêu nhanh</strong>

                                <span>
                                    Tìm và đặt phòng chỉ trong vài giây
                                </span>
                            </div>

                        </div>

                        <div class="card-item">

                            <div class="item-icon">
                                <i class="fa-solid fa-image"></i>
                            </div>

                            <div>
                                <strong>Ảnh phòng thực tế</strong>

                                <span>
                                    Hình ảnh rõ nét và chân thực
                                </span>
                            </div>

                        </div>

                        <div class="card-item">

                            <div class="item-icon">
                                <i class="fa-solid fa-shield-heart"></i>
                            </div>

                            <div>
                                <strong>Giá minh bạch</strong>

                                <span>
                                    Không phát sinh chi phí ẩn
                                </span>
                            </div>

                        </div>

                        <div class="card-item">

                            <div class="item-icon">
                                <i class="fa-solid fa-wifi"></i>
                            </div>

                            <div>
                                <strong>Wifi miễn phí</strong>

                                <span>
                                    Internet tốc độ cao toàn khách sạn
                                </span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>
<!-- MAP MODAL -->
<div class="map-modal" id="mapModal">

    <div class="map-modal-content">

        <button class="close-map" id="closeMapModal">
            <i class="fa-solid fa-xmark"></i>
        </button>

    
        <div class="map-frame">

            {!! $hotelSetting->google_map_embed !!}

        </div>

    </div>

</div>