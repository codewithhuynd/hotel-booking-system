<!-- SERVICES -->
<section id="services" style="padding:0 0 100px;">

    <div class="section-title">

        <div>

            <h2>
                Our Services
            </h2>

            <p>
                Những tiện ích nổi bật giúp nâng cao trải nghiệm khách hàng.
            </p>

        </div>

    </div>

    <div class="info-strip">

        @foreach($services as $service)

        <div class="info-card">

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
