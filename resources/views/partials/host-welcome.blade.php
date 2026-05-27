<!-- HOST -->
@if(Auth::check() && Auth::user()->role === 'host')

<div class="welcome-box">

    <div
        style="
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:20px;
            flex-wrap:wrap;
        ">

        <div>

            <h2
                style="
                    font-family:'Playfair Display', serif;
                    margin-bottom:10px;
                    font-size:32px;
                ">
                Host Dashboard
            </h2>

            <p style="color:#475569;">
                Quản lý phòng, booking và hoạt động kinh doanh.
            </p>

        </div>

        <a
            href="{{ route('host.dashboard') }}"
            class="btn btn-dark">
            Đi tới Dashboard
        </a>

    </div>

</div>

@endif
