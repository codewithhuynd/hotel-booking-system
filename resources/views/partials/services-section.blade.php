<!-- SERVICES -->
<section id="services" class="services-section">

    <div class="section-title">

        <div>

            <span class="section-badge service-badge">
                HOTEL SERVICES
            </span>

            <h2>
                Our Services
            </h2>

            <p>
                Những tiện ích nổi bật giúp nâng cao trải nghiệm khách hàng.
            </p>

        </div>

    </div>

    <div class="services-grid">

        @foreach($services as $service)

        <div class="service-card">

            <div class="service-icon">

                @php
                    $icons = [
                        'fa-solid fa-wifi',
                        'fa-solid fa-water-ladder',
                        'fa-solid fa-utensils',
                        'fa-solid fa-spa',
                        'fa-solid fa-dumbbell',
                        'fa-solid fa-car-side',
                        'fa-solid fa-bell-concierge',
                        'fa-solid fa-mug-hot',
                    ];
                @endphp

                <i class="{{ $icons[$loop->index % count($icons)] }}"></i>

            </div>

            <h4>
                {{ $service->title }}
            </h4>

            <p>
                {{ $service->description }}
            </p>

        </div>

        @endforeach

    </div>

</section>