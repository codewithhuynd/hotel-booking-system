<script>
    document.addEventListener('DOMContentLoaded', function() {

        /*
        |--------------------------------------------------------------------------
        | ROOM IMAGE SLIDER
        |--------------------------------------------------------------------------
        */

        const sliders = {};

        window.changeSlide = function(roomId, direction) {

            const slides = document.querySelectorAll('.slide-' + roomId);

            if (!slides.length) return;

            if (!(roomId in sliders)) {
                sliders[roomId] = 0;
            }

            slides[sliders[roomId]].style.display = 'none';

            sliders[roomId] += direction;

            if (sliders[roomId] >= slides.length) {
                sliders[roomId] = 0;
            }

            if (sliders[roomId] < 0) {
                sliders[roomId] = slides.length - 1;
            }

            slides[sliders[roomId]].style.display = 'block';
        };


        /*
        |--------------------------------------------------------------------------
        | AUTO SCROLL TO ROOMS AFTER SEARCH
        |--------------------------------------------------------------------------
        */

        if (window.location.search.length > 0) {

            const rooms = document.getElementById('rooms');

            if (rooms) {

                setTimeout(() => {

                    rooms.scrollIntoView({
                        behavior: 'smooth'
                    });

                }, 200);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | ACTIVE NAVBAR LINK WHEN SCROLLING
        |--------------------------------------------------------------------------
        */

        const sections = document.querySelectorAll("section[id]");
        const navLinks = document.querySelectorAll(".nav-link");

        function updateActiveNav() {

            let current = "";

            sections.forEach(section => {

                const sectionTop = section.offsetTop - 140;

                if (window.scrollY >= sectionTop) {
                    current = section.getAttribute("id");
                }
            });

            navLinks.forEach(link => {

                link.classList.remove("active");

                if (link.getAttribute("href") === `#${current}`) {
                    link.classList.add("active");
                }
            });
        }


        /*
        |--------------------------------------------------------------------------
        | NAVBAR SCROLL EFFECT
        |--------------------------------------------------------------------------
        */

        const navbar = document.querySelector('.navbar');

        function updateNavbar() {

            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }


        /*
        |--------------------------------------------------------------------------
        | MOBILE MENU
        |--------------------------------------------------------------------------
        */

        const menuToggle = document.getElementById('menuToggle');
        const navWrapper = document.querySelector('.nav-wrapper');

        if (menuToggle) {

            menuToggle.addEventListener('click', () => {
                navWrapper.classList.toggle('active');
            });

            /*
            |--------------------------------------------------------------------------
            | AUTO CLOSE MENU WHEN CLICK LINK
            |--------------------------------------------------------------------------
            */

            navLinks.forEach(link => {

                link.addEventListener('click', () => {
                    navWrapper.classList.remove('active');
                });
            });
        }


        /*
        |--------------------------------------------------------------------------
        | SCROLL EVENTS
        |--------------------------------------------------------------------------
        */

        window.addEventListener('scroll', () => {

            updateNavbar();
            updateActiveNav();

        });


        /*
        |--------------------------------------------------------------------------
        | INITIAL RUN
        |--------------------------------------------------------------------------
        */

        updateNavbar();
        updateActiveNav();

    });


    const mapModal = document.getElementById('mapModal');
    const openMapModal = document.getElementById('openMapModal');
    const closeMapModal = document.getElementById('closeMapModal');

    if (mapModal && openMapModal && closeMapModal) {

        openMapModal.addEventListener('click', () => {
            mapModal.classList.add('active');
        });

        closeMapModal.addEventListener('click', () => {
            mapModal.classList.remove('active');
        });

        mapModal.addEventListener('click', (e) => {
            if (e.target === mapModal) {
                mapModal.classList.remove('active');
            }
        });

    }

    /*
    |--------------------------------------------------------------------------
    | NOTIFICATION DROPDOWN & POLLING
    |--------------------------------------------------------------------------
    */

    const notificationToggle = document.getElementById('notificationToggle');
    const notificationDropdown = document.getElementById('notificationDropdown');
    const notificationBadge = document.getElementById('notificationBadge');
    const notificationList = document.getElementById('notificationList');

    function loadNotifications() {
        if (!notificationList) return;

        fetch('{{ route('notifications.dropdown') }}?t=' + Date.now(), {
            method: 'GET',
            cache: 'no-store',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Cache-Control': 'no-cache'
            }
        })
        .then(response => response.json())
        .then(data => {
            notificationList.innerHTML = data.html;

            if (notificationBadge) {
                if (data.unread_count > 0) {
                    notificationBadge.style.display = 'flex';
                    notificationBadge.textContent = data.unread_count;
                } else {
                    notificationBadge.style.display = 'none';
                    notificationBadge.textContent = '';
                }
            }
        })
        .catch(error => {
            console.error('Load notifications error:', error);
        });
    }

    if (notificationToggle && notificationDropdown) {
        notificationToggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            notificationDropdown.classList.toggle('show');

            loadNotifications();
        });

        document.addEventListener('click', function (e) {
            if (
                !notificationDropdown.contains(e.target) &&
                !notificationToggle.contains(e.target)
            ) {
                notificationDropdown.classList.remove('show');
            }
        });

        loadNotifications();
        setInterval(loadNotifications, 2000);
    }
</script>