<!-- ABOUT -->
<section id="about" style="padding:0 0 100px;">

    <div class="section-title">

        <div>

            <h2>
                About Our Hotel
            </h2>

            <p>
                Trải nghiệm nghỉ dưỡng hiện đại, sang trọng và tiện nghi
                dành cho khách du lịch, gia đình và doanh nhân.
            </p>

        </div>

    </div>

    <div class="info-strip">

        @foreach($aboutSections as $about)

        <div class="info-card">

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
