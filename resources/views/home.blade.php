{{-- resources/views/home.blade.php --}}

<!DOCTYPE html>
<html lang="vi">

@include('partials.head')

<body>

    @include('partials.toast-notification')

    @include('partials.navbar')

    @include('partials.hero')

    <div class="container">

        @include('partials.search-box')

        @include('partials.rooms-section')

        @include('partials.about-section')

        @include('partials.services-section')

        @include('partials.contact-section')

    </div>

    @include('partials.scripts')

</body>

</html>
