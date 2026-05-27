<style>
    /* =========================
   BASE
========================= */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    scroll-behavior: smooth;
}

body {
    font-family: 'Poppins', sans-serif;
    background: #0f172a;
    color: #e2e8f0;
    line-height: 1.6;
}

a {
    text-decoration: none;
    color: inherit;
}

img {
    display: block;
    max-width: 100%;
}

/* =========================
   NAVBAR
========================= */

.navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;

    padding: 16px 60px;

    display: flex;
    justify-content: space-between;
    align-items: center;

    background: rgba(2, 6, 23, 0.75);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.18);
}

.nav-link,
.btn,
.user-btn,
.dropdown-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.nav-wrapper {
    display: flex;
    align-items: center;
    gap: 40px;
}

.nav-left,
.nav-right {
    display: flex;
    align-items: center;
    gap: 14px;
}

.nav-link {
    color: #e2e8f0;
    font-weight: 500;
    transition: 0.25s;
    position: relative;
}

.nav-link:hover {
    color: #fff;
}

.nav-link::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -6px;
    width: 0%;
    height: 2px;
    background: #fff;
    transition: 0.3s;
}

.nav-link:hover::after,
.nav-link.active::after {
    width: 100%;
}

.nav-link.active {
    color: #fff;
}

/* Nav colors */
.nav-rooms:hover {
    color: #60a5fa;
}

.nav-rooms:hover::after,
.nav-rooms.active::after {
    background: #60a5fa;
}

.nav-rooms:hover i,
.nav-rooms.active i {
    color: #60a5fa;
    transform: translateY(-2px) scale(1.15);
}

.nav-about:hover {
    color: #c084fc;
}

.nav-about:hover::after,
.nav-about.active::after {
    background: #c084fc;
}

.nav-about:hover i,
.nav-about.active i {
    color: #c084fc;
    transform: translateY(-2px) scale(1.15);
}

.nav-services:hover {
    color: #fbbf24;
}

.nav-services:hover::after,
.nav-services.active::after {
    background: #fbbf24;
}

.nav-services:hover i,
.nav-services.active i {
    color: #fbbf24;
    transform: translateY(-2px) scale(1.15);
}

.nav-contact:hover {
    color: #4ade80;
}

.nav-contact:hover::after,
.nav-contact.active::after {
    background: #4ade80;
}

.nav-contact:hover i,
.nav-contact.active i {
    color: #4ade80;
    transform: translateY(-2px) scale(1.15);
}

.logo {
    display: flex;
    align-items: center;
    gap: 14px;
    color: #fff;
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    font-weight: 800;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.logo-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #22c55e, #16a34a);
    font-size: 20px;
}

.logo-text {
    display: flex;
    flex-direction: column;
    line-height: 1.1;
    font-family: 'Playfair Display', serif;
}

.logo-text span {
    font-size: 12px;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #cbd5e1;
    font-family: 'Poppins', sans-serif;
}

/* =========================
   BUTTONS
========================= */

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 18px;
    border-radius: 999px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    transition: 0.25s ease;
}

.btn:hover {
    transform: translateY(-2px);
}

.btn-white,
.btn-green,
.btn-dark {
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}

.btn-white {
    background: #fff;
    color: #111827;
}

.btn-dark {
    background: #111827;
    color: #fff;
}

.btn-green {
    background: #16a34a;
    color: #fff;
}

.btn-outline {
    border: 1px solid rgba(255, 255, 255, 0.35);
    background: transparent;
    color: #fff;
}

.auth-btn {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 22px;
    border-radius: 999px;
    font-weight: 600;
    font-size: 15px;
    overflow: hidden;
    transition: all 0.35s ease;
    backdrop-filter: blur(10px);
}

/* Login */
.login-btn {
    color: #fff;
    border: 1px solid rgba(255, 255, 255, 0.18);
    background: rgba(255, 255, 255, 0.08);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.login-btn:hover {
    background: rgba(255, 255, 255, 0.14);
    border-color: rgba(255, 255, 255, 0.3);
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
}

.login-btn i {
    color: #93c5fd;
}

/* Register */
.register-btn {
    color: white;
    background: linear-gradient(135deg, #22c55e, #16a34a);
    box-shadow: 0 10px 25px rgba(34, 197, 94, 0.35);
    border: 1px solid rgba(255, 255, 255, 0.15);
}

.register-btn:hover {
    transform: translateY(-4px) scale(1.03);
    box-shadow: 0 15px 35px rgba(34, 197, 94, 0.55);
}

.register-btn::before {
    content: "";
    position: absolute;
    top: 0;
    left: -120%;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        120deg,
        transparent,
        rgba(255, 255, 255, 0.4),
        transparent
    );
    transition: 0.6s;
}

.register-btn:hover::before {
    left: 120%;
}

.register-btn i {
    color: #dcfce7;
}

/* =========================
   HERO
========================= */

.hero {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    overflow: hidden;

    background:
        linear-gradient(
            135deg,
            rgba(15, 23, 42, 0.55),
            rgba(15, 23, 42, 0.35)
        ),
        url('{{ $hotelSetting && $hotelSetting->hero_image ? asset("storage/" . $hotelSetting->hero_image) : asset("images/hero.jpg") }}');

    background-size: cover;
    background-position: center;
}

.hero::before {
    content: "";
    position: absolute;
    top: -250px;
    right: -250px;
    width: 650px;
    height: 650px;
    border-radius: 50%;
    background: radial-gradient(
        circle,
        rgba(34, 197, 94, 0.08),
        transparent 70%
    );
    z-index: 1;
}

.hero::after {
    content: "";
    position: absolute;
    bottom: -250px;
    left: -250px;
    width: 550px;
    height: 550px;
    border-radius: 50%;
    background: radial-gradient(
        circle,
        rgba(96, 165, 250, 0.18),
        transparent 70%
    );
    z-index: 1;
}

.hero-inner {
    position: relative;
    z-index: 5;
    width: 100%;
    max-width: 1280px;
    margin: auto;
    padding: 150px 30px 90px;
}

.hero-grid {
    display: grid;
    grid-template-columns: 1.2fr 0.8fr;
    gap: 50px;
    align-items: center;
}

.hero-content {
    animation: fadeUp 1s ease;
}

.hero-kicker {
    display: inline-block;
    padding: 10px 18px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.10);
    margin-bottom: 24px;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: #fff;
}

.hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(50px, 6vw, 84px);
    line-height: 1.05;
    margin-bottom: 24px;
    font-weight: 800;
    background: linear-gradient(to right, #ffffff, #d1fae5);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.hero-description {
    max-width: 650px;
    font-size: 18px;
    line-height: 1.8;
    color: #cbd5e1;
    margin-bottom: 32px;
}

/* Location */
.hero-location {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
    margin-bottom: 32px;
}

.location-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 18px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.10);
    backdrop-filter: blur(10px);
    transition: 0.3s ease;
    cursor: pointer;
}

.location-item:hover {
    transform: translateY(-3px);
    background: rgba(255, 255, 255, 0.12);
    color: #60a5fa;
}

.location-item i {
    color: #4ade80;
}

/* Actions */
.hero-actions {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 34px;
}

/* Rating */
.hero-rating {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
    margin-bottom: 34px;
}

.rating-stars {
    display: flex;
    gap: 4px;
}

.rating-stars i {
    color: #fbbf24;
    filter: drop-shadow(0 0 8px rgba(251, 191, 36, 0.5));
}

.hero-rating span {
    color: #e2e8f0;
}

/* Stats */
.hero-stats {
    display: flex;
    gap: 18px;
    flex-wrap: wrap;
}

.stat-chip {
    min-width: 150px;
    padding: 18px 20px;
    border-radius: 22px;
    background: linear-gradient(
        135deg,
        rgba(255, 255, 255, 0.12),
        rgba(255, 255, 255, 0.04)
    );
    border: 1px solid rgba(255, 255, 255, 0.10);
    backdrop-filter: blur(12px);
    transition: 0.35s ease;
}

.stat-chip:hover {
    transform: translateY(-6px);
    border-color: rgba(74, 222, 128, 0.40);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
}

.stat-chip strong {
    display: block;
    margin-bottom: 6px;
    font-size: 28px;
    font-weight: 800;
    color: #fff;
}

.stat-chip span {
    font-size: 14px;
    color: #cbd5e1;
}

/* Hero card */
.hero-card-wrapper {
    position: relative;
    animation: fadeUp 1.2s ease;
}

.hero-card {
    position: relative;
    padding: 32px;
    border-radius: 30px;
    background: linear-gradient(
        135deg,
        rgba(255, 255, 255, 0.12),
        rgba(255, 255, 255, 0.04)
    );
    border: 1px solid rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(16px);
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
}

.hero-card::before {
    content: "";
    position: absolute;
    top: -80px;
    right: -80px;
    width: 220px;
    height: 220px;
    border-radius: 50%;
    background: radial-gradient(
        circle,
        rgba(74, 222, 128, 0.20),
        transparent 70%
    );
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 24px;
}

.card-header h3 {
    font-size: 34px;
    color: #fff;
    margin-bottom: 8px;
    font-family: 'Playfair Display', serif;
}

.card-header p {
    color: #cbd5e1;
}

.card-list {
    display: grid;
    gap: 16px;
}

.card-item {
    display: flex;
    gap: 16px;
    align-items: flex-start;
    padding: 18px;
    border-radius: 22px;
    background: rgba(15, 23, 42, 0.45);
    border: 1px solid rgba(255, 255, 255, 0.06);
    transition: 0.35s ease;
}

.card-item:hover {
    transform: translateX(6px);
    background: rgba(15, 23, 42, 0.65);
    border-color: rgba(255, 255, 255, 0.14);
}

.item-icon {
    min-width: 52px;
    height: 52px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    background: linear-gradient(
        135deg,
        rgba(255, 255, 255, 0.12),
        rgba(255, 255, 255, 0.04)
    );
}

.fa-bolt {
    color: #fbbf24;
}

.fa-image {
    color: #60a5fa;
}

.fa-shield-heart {
    color: #fb7185;
}

.fa-wifi {
    color: #4ade80;
}

.card-item strong {
    display: block;
    color: #fff;
    margin-bottom: 6px;
    font-size: 16px;
}

.card-item span {
    font-size: 14px;
    line-height: 1.6;
    color: #cbd5e1;
}

/* =========================
   SEARCH BOX
========================= */

.search-box {
    margin-top: 40px;
    position: relative;
    z-index: 5;
    background: #fff;
    color: #111827;
    border-radius: 28px;
    padding: 35px;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
}

.search-head {
    margin-bottom: 25px;
}

.search-subtitle {
    display: inline-block;
    color: #0e2557;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.search-head h2 {
    font-size: 32px;
    font-weight: 800;
    color: #111827;
    font-family: 'Playfair Display', serif;
}

.search-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 22px;
    align-items: end;
}

.field {
    display: flex;
    flex-direction: column;
}

.field label {
    margin-bottom: 10px;
    font-weight: 600;
    color: #374151;
    font-size: 14px;
}

.field label i {
    margin-right: 6px;
    color: #0f2555;
}

.field input,
.field select,
.field textarea {
    width: 100%;
    height: 55px;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 0 18px;
    font-size: 15px;
    transition: all 0.25s ease;
    background: #f9fafb;
    font-family: inherit;
    outline: none;
}

.field textarea {
    height: auto;
    min-height: 120px;
    padding: 14px 18px;
    resize: vertical;
}

.field input:focus,
.field select:focus,
.field textarea:focus {
    border-color: #0c1f47;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
}

.search-btn-wrap {
    justify-content: flex-end;
}

.search-btn {
    height: 55px;
    width: 100%;
    border: none;
    border-radius: 16px;
    background: linear-gradient(135deg, #133376, #08173f);
    color: white;
    font-weight: 700;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.search-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(18, 49, 116, 0.25);
}

.search-btn i {
    margin-right: 8px;
}

/* =========================
   ROOMS
========================= */

.rooms-section {
    padding: 90px 0;
}

.section-title {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 20px;
    margin-bottom: 34px;
    flex-wrap: wrap;
}

.section-title h2 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(32px, 4vw, 50px);
    color: #fff;
}

.section-title p {
    max-width: 700px;
    color: #cbd5e1;
}

.room-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
    gap: 28px;
}

.room-card {
    background: #fff;
    color: #111827;
    border-radius: 26px;
    overflow: hidden;
    transition: 0.25s ease;
}

.room-card:hover {
    transform: translateY(-8px);
}

.room-slider {
    position: relative;
    overflow: hidden;
}

.slider-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 40px;
    height: 40px;
    border: none;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.5);
    color: white;
    cursor: pointer;
    font-size: 18px;
    z-index: 5;
}

.prev-btn {
    left: 10px;
}

.next-btn {
    right: 10px;
}

.slider-btn:hover {
    background: rgba(0, 0, 0, 0.8);
}

.room-image {
    width: 100%;
    aspect-ratio: 16 / 10;
    object-fit: cover;
    background: #e2e8f0;
}

.room-content {
    padding: 22px;
}

.room-content h3 {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    margin-bottom: 12px;
}

.price {
    font-size: 30px;
    font-weight: 800;
    margin-bottom: 14px;
}

.meta {
    display: grid;
    gap: 8px;
    margin-bottom: 20px;
}

.meta p {
    color: #475569;
    font-size: 14px;
}

/* =========================
   ABOUT
========================= */

#about {
    padding: 0 0 100px;
    scroll-margin-top: 100px;
}

.info-strip {
    margin-top: 36px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 18px;
}

.info-card {
    background: linear-gradient(
        135deg,
        rgba(255, 255, 255, 0.08),
        rgba(255, 255, 255, 0.04)
    );
    border: 1px solid rgba(255, 255, 255, 0.10);
    border-radius: 22px;
    padding: 22px;
    backdrop-filter: blur(10px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    transition: 0.3s ease;
}

.info-card:hover {
    transform: translateY(-5px);
    border-color: rgba(96, 165, 250, 0.35);
    background: linear-gradient(
        135deg,
        rgba(255, 255, 255, 0.10),
        rgba(255, 255, 255, 0.06)
    );
}

.info-card h4 {
    margin-bottom: 10px;
    color: #fff;
    font-size: 18px;
}

.info-card p {
    color: #cbd5e1;
    font-size: 14px;
}

.welcome-box {
    margin-top: 40px;
    background: #fff;
    color: #111827;
    padding: 30px;
    border-radius: 28px;
}

.empty-box {
    background: #fff;
    color: #111827;
    padding: 20px;
    border-radius: 20px;
}

/* =========================
   MODAL MAP
========================= */

.map-modal {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    opacity: 0;
    visibility: hidden;
    transition: 0.3s;
    z-index: 9999;
}

.map-modal.active {
    opacity: 1;
    visibility: visible;
}

.map-modal-content {
    width: 90%;
    max-width: 900px;
    background: #fff;
    border-radius: 24px;
    overflow: hidden;
    position: relative;
    animation: popupScale 0.3s ease;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.map-modal-content h3 {
    color: #111827;
    font-family: 'Playfair Display', serif;
    font-size: 30px;
    margin: 0;
    padding: 24px 24px 0;
}

.map-modal-content p {
    color: #475569;
    padding: 10px 24px 18px;
}

.map-frame iframe {
    width: 100%;
    height: 500px;
    border: none;
    display: block;
}

.close-map {
    position: absolute;
    top: 16px;
    right: 16px;
    width: 42px;
    height: 42px;
    border: none;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.6);
    color: white;
    cursor: pointer;
    font-size: 18px;
    z-index: 10;
}

.location-item.map-trigger {
    cursor: pointer;
    transition: 0.25s;
}

.location-item.map-trigger:hover {
    transform: translateY(-2px);
    color: #60a5fa;
}

@keyframes popupScale {
    from {
        transform: scale(0.9);
        opacity: 0;
    }

    to {
        transform: scale(1);
        opacity: 1;
    }
}

/* =========================
   DROPDOWN
========================= */

.user-dropdown {
    position: relative;
}

.user-btn {
    background: rgba(255, 255, 255, 0.10);
    border: 1px solid rgba(255, 255, 255, 0.10);
    color: #fff;
    padding: 10px 16px;
    border-radius: 999px;
    cursor: pointer;
}

.dropdown-menu {
    position: absolute;
    top: 120%;
    right: 0;
    width: 220px;
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px);
    transition: 0.25s;
    box-shadow: 0 18px 40px rgba(0, 0, 0, 0.15);
}

.user-dropdown:hover .dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-item {
    display: block;
    width: 100%;
    padding: 14px 18px;
    background: #fff;
    color: #111827;
    border: none;
    text-align: left;
    cursor: pointer;
    font-size: 16px;
}

.dropdown-item:hover {
    background: #f8fafc;
}

.logout-btn {
    font-family: inherit;
    font-size: inherit;
}

/* =========================
   ANIMATION
========================= */

@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* =========================
   RESPONSIVE
========================= */

@media (max-width: 1200px) {
    .search-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 1024px) {
    .hero-grid {
        grid-template-columns: 1fr;
    }

    .hero-card-wrapper {
        max-width: 700px;
    }
}

@media (max-width: 768px) {
    .navbar {
        padding: 18px;
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }

    .nav-wrapper {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
        width: 100%;
    }

    .nav-left,
    .nav-right {
        flex-wrap: wrap;
    }

    .navbar.scrolled {
        background: rgba(2, 6, 23, 0.92);
        padding: 12px 18px;
    }

    .hero-inner {
        padding: 170px 18px 80px;
    }

    .hero h1 {
        font-size: 52px;
    }

    .hero-actions {
        flex-direction: column;
    }

    .btn {
        width: 100%;
    }

    .hero-stats {
        display: grid;
        grid-template-columns: 1fr;
    }

    .stat-chip {
        width: 100%;
    }

    .container {
        padding: 0 18px;
    }

    .search-box {
        margin-top: -30px;
        padding: 20px;
    }

    .search-grid {
        grid-template-columns: 1fr;
    }

    .rooms-section {
        padding: 70px 0;
    }

    .map-frame iframe {
        height: 320px;
    }

    .map-modal-content h3 {
        font-size: 24px;
    }
}

#about,
#contact,
#services {
    scroll-margin-top: 100px;
}

.container {
    max-width: 1280px;
    margin: auto;
    padding: 0 30px;
}

/* =========================
   ABOUT SECTION
========================= */

.about-section{
    padding: 0 0 110px;
}

.section-badge{
    display: inline-block;

    padding: 8px 16px;

    border-radius: 999px;

    background: rgba(192, 132, 252, 0.15);

    color: #d8b4fe;

    font-size: 13px;
    font-weight: 700;

    letter-spacing: 1px;
    text-transform: uppercase;

    margin-bottom: 16px;

    border: 1px solid rgba(192, 132, 252, 0.25);
}

.info-strip{
    margin-top: 45px;

    display: grid;

    grid-template-columns:
        repeat(auto-fit, minmax(260px, 1fr));

    gap: 24px;
}

.info-card{
    position: relative;

    padding: 32px 26px;

    border-radius: 28px;

    overflow: hidden;

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,0.08),
            rgba(255,255,255,0.03)
        );

    border:
        1px solid rgba(255,255,255,0.08);

    backdrop-filter: blur(14px);

    transition: all 0.35s ease;
}

.info-card:hover{
    transform:
        translateY(-10px);

    border-color:
        rgba(192,132,252,0.35);

    box-shadow:
        0 25px 45px rgba(0,0,0,0.25);
}

/* glow effect */

.info-card::before{
    content: "";

    position: absolute;

    top: -80px;
    right: -80px;

    width: 180px;
    height: 180px;

    border-radius: 50%;

    background:
        radial-gradient(
            circle,
            rgba(192,132,252,0.18),
            transparent 70%
        );
}

/* ICON */

.info-icon{
    width: 68px;
    height: 68px;

    border-radius: 20px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin-bottom: 22px;

    font-size: 26px;

    background:
        linear-gradient(
            135deg,
            #9333ea,
            #7c3aed
        );

    color: white;

    box-shadow:
        0 12px 25px rgba(124,58,237,0.35);
}

.info-card:nth-child(2) .info-icon{
    background:
        linear-gradient(
            135deg,
            #22c55e,
            #16a34a
        );

    box-shadow:
        0 12px 25px rgba(34,197,94,0.35);
}

.info-card:nth-child(3) .info-icon{
    background:
        linear-gradient(
            135deg,
            #3b82f6,
            #2563eb
        );

    box-shadow:
        0 12px 25px rgba(59,130,246,0.35);
}

.info-card:nth-child(4) .info-icon{
    background:
        linear-gradient(
            135deg,
            #f59e0b,
            #d97706
        );

    box-shadow:
        0 12px 25px rgba(245,158,11,0.35);
}

.info-card h4{
    font-size: 24px;
    font-weight: 700;

    color: #fff;

    margin-bottom: 14px;
}

.info-card p{
    color: #cbd5e1;

    line-height: 1.8;

    font-size: 15px;
}

/* responsive */

@media (max-width: 768px){

    .info-strip{
        grid-template-columns: 1fr;
    }

    .info-card{
        padding: 26px 22px;
    }

}
/* =========================
   SERVICES
========================= */

.services-section{
    padding: 0 0 110px;
}

.service-badge{
    background: rgba(34,197,94,0.15);
    color: #86efac;
    border: 1px solid rgba(34,197,94,0.25);
}

.services-grid{
    margin-top: 45px;

    display: grid;

    grid-template-columns:
        repeat(auto-fit, minmax(280px,1fr));

    gap: 28px;
}

.service-card{
    position: relative;

    overflow: hidden;

    padding: 34px 28px;

    border-radius: 30px;

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,0.08),
            rgba(255,255,255,0.03)
        );

    border:
        1px solid rgba(255,255,255,0.08);

    backdrop-filter: blur(14px);

    transition: all 0.35s ease;
}

.service-card:hover{
    transform:
        translateY(-10px);

    border-color:
        rgba(34,197,94,0.35);

    box-shadow:
        0 25px 45px rgba(0,0,0,0.25);
}

/* glow */

.service-card::before{
    content: "";

    position: absolute;

    top: -80px;
    right: -80px;

    width: 180px;
    height: 180px;

    border-radius: 50%;

    background:
        radial-gradient(
            circle,
            rgba(34,197,94,0.18),
            transparent 70%
        );
}

/* ICON */

.service-icon{
    width: 72px;
    height: 72px;

    border-radius: 22px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin-bottom: 24px;

    font-size: 28px;

    color: white;

    transition: 0.35s ease;
}

/* màu icon */

.service-card:nth-child(1) .service-icon{
    background:
        linear-gradient(135deg,#22c55e,#16a34a);
}

.service-card:nth-child(2) .service-icon{
    background:
        linear-gradient(135deg,#3b82f6,#2563eb);
}

.service-card:nth-child(3) .service-icon{
    background:
        linear-gradient(135deg,#f59e0b,#d97706);
}

.service-card:nth-child(4) .service-icon{
    background:
        linear-gradient(135deg,#ec4899,#be185d);
}

.service-card:nth-child(5) .service-icon{
    background:
        linear-gradient(135deg,#8b5cf6,#6d28d9);
}

.service-card:nth-child(6) .service-icon{
    background:
        linear-gradient(135deg,#06b6d4,#0891b2);
}

.service-card:hover .service-icon{
    transform:
        rotate(-6deg) scale(1.08);
}

/* TEXT */

.service-card h4{
    font-size: 24px;
    font-weight: 700;

    color: #fff;

    margin-bottom: 14px;
}

.service-card p{
    color: #cbd5e1;

    line-height: 1.8;

    font-size: 15px;
}

/* responsive */

@media (max-width:768px){

    .services-grid{
        grid-template-columns: 1fr;
    }

}
/* =========================
   CONTACT
========================= */

.contact-section{
    padding: 0 0 120px;
}

.contact-badge{
    background: rgba(59,130,246,0.15);
    color: #93c5fd;
    border: 1px solid rgba(59,130,246,0.25);
}

.contact-grid{
    margin-top: 45px;

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 32px;
}

/* LEFT */

.contact-info-wrapper{
    display: grid;
    gap: 22px;
}

.contact-card{
    display: flex;
    gap: 18px;
    align-items: flex-start;

    padding: 26px;

    border-radius: 28px;

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,0.08),
            rgba(255,255,255,0.03)
        );

    border:
        1px solid rgba(255,255,255,0.08);

    backdrop-filter: blur(14px);

    transition: all 0.35s ease;
}

.contact-card:hover{
    transform: translateY(-6px);

    border-color:
        rgba(59,130,246,0.35);

    box-shadow:
        0 20px 40px rgba(0,0,0,0.25);
}

.contact-icon{
    min-width: 65px;
    height: 65px;

    border-radius: 20px;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 24px;

    color: white;

    background:
        linear-gradient(
            135deg,
            #2563eb,
            #1d4ed8
        );
}

.contact-card h4{
    color: #fff;

    font-size: 22px;

    margin-bottom: 8px;
}

.contact-card p{
    color: #cbd5e1;

    line-height: 1.7;
}

.contact-link{
    color: #93c5fd;

    font-weight: 600;

    transition: 0.25s;
}

.contact-link:hover{
    color: #fff;
}

/* RIGHT FORM */

.contact-form-box{
    padding: 34px;

    border-radius: 32px;

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,0.08),
            rgba(255,255,255,0.03)
        );

    border:
        1px solid rgba(255,255,255,0.08);

    backdrop-filter: blur(16px);
}

.contact-form-box h3{
    font-size: 34px;

    color: #fff;

    margin-bottom: 10px;

    font-family: 'Playfair Display', serif;
}

.contact-form-box p{
    color: #cbd5e1;

    margin-bottom: 24px;
}

.contact-form-box form{
    display: grid;
    gap: 18px;
}

.contact-form-box input,
.contact-form-box textarea{
    width: 100%;

    border: none;

    border-radius: 18px;

    padding: 16px 18px;

    background:
        rgba(255,255,255,0.08);

    color: white;

    font-size: 15px;

    transition: 0.25s;
}

.contact-form-box input::placeholder,
.contact-form-box textarea::placeholder{
    color: #94a3b8;
}

.contact-form-box input:focus,
.contact-form-box textarea:focus{
    outline: none;

    background:
        rgba(255,255,255,0.12);

    box-shadow:
        0 0 0 4px rgba(59,130,246,0.18);
}

.contact-form-box textarea{
    min-height: 150px;

    resize: none;
}

.contact-submit-btn{
    height: 58px;

    border: none;

    border-radius: 18px;

    background:
        linear-gradient(
            135deg,
            #2563eb,
            #1d4ed8
        );

    color: white;

    font-weight: 700;
    font-size: 15px;

    cursor: pointer;

    transition: 0.3s ease;
}

.contact-submit-btn:hover{
    transform: translateY(-3px);

    box-shadow:
        0 14px 30px rgba(37,99,235,0.35);
}

/* HOST MESSAGE */

.host-message{
    text-align: center;

    padding: 40px 20px;
}

.host-message i{
    font-size: 50px;

    color: #60a5fa;

    margin-bottom: 20px;
}

.host-message p{
    color: #cbd5e1;
}

/* RESPONSIVE */

@media (max-width: 992px){

    .contact-grid{
        grid-template-columns: 1fr;
    }

}

@media (max-width: 768px){

    .contact-form-box{
        padding: 26px;
    }

    .contact-card{
        padding: 22px;
    }

}

/* =========================
   MAP CARD
========================= */

.contact-map-card{
    grid-column: span 2;

    background: linear-gradient(
        135deg,
        rgba(255,255,255,0.08),
        rgba(255,255,255,0.03)
    );

    border: 1px solid rgba(255,255,255,0.08);

    border-radius: 28px;

    padding: 24px;

    backdrop-filter: blur(12px);

    overflow: hidden;
}

.map-header{
    display: flex;
    align-items: center;
    gap: 16px;

    margin-bottom: 20px;
}

.map-header h4{
    color: #fff;
    font-size: 20px;
    margin-bottom: 4px;
}

.map-header p{
    color: #cbd5e1;
    font-size: 14px;
}

.map-frame{
    width: 100%;
    height: 420px;

    border-radius: 22px;

    overflow: hidden;

    border: 1px solid rgba(255,255,255,0.08);

    box-shadow:
        0 20px 40px rgba(0,0,0,0.25);
}

.map-frame iframe{
    width: 100%;
    height: 100%;

    border: none;

    filter: grayscale(0.1) contrast(1.05);
}

/* Responsive */

@media (max-width: 768px){

    .contact-map-card{
        grid-column: span 1;
    }

    .map-frame{
        height: 300px;
    }

}

/* =========================
   NOTIFICATION BELL
========================= */
.notification-wrapper {
    position: relative;
}

.notification-btn {
    position: relative;
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 8px;
    display: flex;
    align-items: center;
}

.notification-badge {
    position: absolute;
    top: 2px;
    right: 0;
    min-width: 18px;
    height: 18px;
    padding: 0 5px;
    border-radius: 999px;
    background: #ef4444;
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
}

.notification-dropdown {
    display: none;
    position: absolute;
    top: 42px;
    right: 0;
    width: 340px;
    max-height: 420px;
    overflow-y: auto;
    background: #ffffff;
    color: #111827;
    border-radius: 16px;
    box-shadow: 0 20px 45px rgba(0, 0, 0, 0.25);
    z-index: 9999;
}

.notification-dropdown.show {
    display: block;
}

.notification-header {
    padding: 14px 16px;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.notification-header button {
    border: none;
    background: none;
    color: #2563eb;
    font-size: 13px;
    cursor: pointer;
}

.notification-item {
    width: 100%;
    border: none;
    background: #fff;
    text-align: left;
    padding: 13px 16px;
    cursor: pointer;
    border-bottom: 1px solid #f1f5f9;
}

.notification-item:hover {
    background: #f8fafc;
}

.notification-item.unread {
    background: #eff6ff;
}

.notification-item span {
    display: block;
    font-weight: 600;
    color: #111827;
}

.notification-item small {
    display: block;
    margin-top: 4px;
    color: #64748b;
    line-height: 1.4;
}

.notification-empty {
    padding: 20px;
    text-align: center;
    color: #64748b;
}

</style>