<style>
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

    /* ROOMS */
    .nav-rooms:hover {
        color: #60a5fa;
    }

    .nav-rooms:hover::after {
        background: #60a5fa;
    }

    .nav-rooms:hover i {
        color: #60a5fa;

        transform: translateY(-2px) scale(1.15);
    }

    /* ABOUT */
    .nav-about:hover {
        color: #c084fc;
    }

    .nav-about:hover::after {
        background: #c084fc;
    }

    .nav-about:hover i {
        color: #c084fc;

        transform: translateY(-2px) scale(1.15);
    }

    /* SERVICES */
    .nav-services:hover {
        color: #fbbf24;
    }

    .nav-services:hover::after {
        background: #fbbf24;
    }

    .nav-services:hover i {
        color: #fbbf24;

        transform: translateY(-2px) scale(1.15);
    }

    /* CONTACT */
    .nav-contact:hover {
        color: #4ade80;
    }

    .nav-contact:hover::after {
        background: #4ade80;
    }

    .nav-contact:hover i {
        color: #4ade80;

        transform: translateY(-2px) scale(1.15);
    }

    .nav-rooms.active {
        color: #60a5fa;
    }

    .nav-rooms.active::after {
        background: #60a5fa;
        width: 100%;
    }

    .nav-about.active {
        color: #c084fc;
    }

    .nav-about.active::after {
        background: #c084fc;
        width: 100%;
    }

    .nav-services.active {
        color: #fbbf24;
    }

    .nav-services.active::after {
        background: #fbbf24;
        width: 100%;
    }

    .nav-contact.active {
        color: #4ade80;
    }

    .nav-contact.active::after {
        background: #4ade80;
        width: 100%;
    }

    .logo {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        font-weight: 800;
        letter-spacing: 2px;
        color: #fff;
        text-transform: uppercase;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 14px;

        color: #fff;
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

    .nav-link:hover::after {
        width: 100%;
    }

    .nav-link.active {
        color: #fff;
    }

    .nav-link.active::after {
        width: 100%;
    }

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

    .btn-white,
    .btn-green,
    .btn-dark {
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .btn:hover {
        transform: translateY(-2px);
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

    /* ================= LOGIN ================= */

    .login-btn {
        color: #fff;

        border: 1px solid rgba(255, 255, 255, 0.18);

        background: rgba(255, 255, 255, 0.08);

        box-shadow:
            0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .login-btn:hover {
        background: rgba(255, 255, 255, 0.14);

        border-color: rgba(255, 255, 255, 0.3);

        transform: translateY(-3px);

        box-shadow:
            0 12px 30px rgba(0, 0, 0, 0.25);
    }

    .login-btn i {
        color: #93c5fd;
    }

    /* ================= REGISTER ================= */

    .register-btn {
        color: white;

        background: linear-gradient(135deg,
                #22c55e,
                #16a34a);

        box-shadow:
            0 10px 25px rgba(34, 197, 94, 0.35);

        border: 1px solid rgba(255, 255, 255, 0.15);
    }

    .register-btn:hover {
        transform: translateY(-4px) scale(1.03);

        box-shadow:
            0 15px 35px rgba(34, 197, 94, 0.55);
    }

    /* ánh sáng chạy */

    .register-btn::before {
        content: "";

        position: absolute;

        top: 0;
        left: -120%;

        width: 100%;
        height: 100%;

        background: linear-gradient(120deg,
                transparent,
                rgba(255, 255, 255, 0.4),
                transparent);

        transition: 0.6s;
    }

    .register-btn:hover::before {
        left: 120%;
    }

    .register-btn i {
        color: #dcfce7;
    }

    .hero {
        min-height: 100vh;

        display: flex;
        align-items: center;

        background: linear-gradient(rgba(2, 6, 23, 0.75),
            rgba(2, 6, 23, 0.60)),
        url('{{ $hotelSetting && $hotelSetting->hero_image ? asset("storage/" . $hotelSetting->hero_image) : asset("images/hero.jpg") }}');

        background-size: cover;
        background-position: center;
    }

    .hero-inner {
        width: 100%;
        max-width: 1280px;
        margin: auto;

        padding: 140px 30px 90px;
    }

    .hero-grid {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 40px;
        align-items: center;
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
    }

    .hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(46px, 6vw, 84px);
        line-height: 1.05;

        margin-bottom: 20px;

        color: #fff;
    }

    .hero p {
        max-width: 650px;
        margin-bottom: 30px;
        color: #cbd5e1;
    }

    .hero-actions {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;

        margin-bottom: 30px;
    }

    .hero-stats {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
    }

    .stat-chip {
        padding: 14px 18px;

        border-radius: 18px;

        background: rgba(255, 255, 255, 0.08);

        border: 1px solid rgba(255, 255, 255, 0.10);
    }

    .stat-chip strong {
        display: block;
        color: #fff;
        margin-bottom: 4px;
    }

    .stat-chip span {
        font-size: 13px;
        color: #cbd5e1;
    }

    .hero-card {
        background: rgba(255, 255, 255, 0.08);

        border: 1px solid rgba(255, 255, 255, 0.12);

        border-radius: 28px;

        padding: 26px;

        backdrop-filter: blur(10px);
    }

    .hero-card h3 {
        font-family: 'Playfair Display', serif;
        font-size: 30px;

        margin-bottom: 12px;
    }

    .hero-card p {
        font-size: 15px;
        margin-bottom: 18px;
    }

    /* =========================
   HERO SECTION
========================= */

    .hero {
        position: relative;

        min-height: 100vh;

        display: flex;
        align-items: center;

        overflow: hidden;

        background: linear-gradient(135deg,
            rgba(15, 23, 42, 0.55),
            rgba(15, 23, 42, 0.35)),
        url('{{ $hotelSetting && $hotelSetting->hero_image ? asset("storage/" . $hotelSetting->hero_image) : asset("images/hero.jpg") }}');

        background-size: cover;
        background-position: center;
    }

    /* glow background */

    .hero::before {
        content: "";

        position: absolute;

        top: -250px;
        right: -250px;

        width: 650px;
        height: 650px;

        border-radius: 50%;

        background:
            radial-gradient(circle,
                rgba(34, 197, 94, 0.08) transparent 70%);

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

        background:
            radial-gradient(circle,
                rgba(96, 165, 250, 0.18),
                transparent 70%);

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

    /* =========================
   LEFT CONTENT
========================= */

    .hero-content {
        animation: fadeUp 1s ease;
    }

    .hero h1 {
        font-family: 'Playfair Display', serif;

        font-size: clamp(50px, 6vw, 84px);

        line-height: 1.05;

        margin-bottom: 24px;

        font-weight: 800;

        background:
            linear-gradient(to right,
                #ffffff,
                #d1fae5);

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

    /* =========================
   LOCATION
========================= */

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

        background:
            rgba(255, 255, 255, 0.08);

        border:
            1px solid rgba(255, 255, 255, 0.10);

        backdrop-filter: blur(10px);

        transition: 0.3s ease;
    }

    .location-item:hover {
        transform: translateY(-3px);

        background:
            rgba(255, 255, 255, 0.12);
    }

    .location-item i {
        color: #4ade80;
    }

    /* =========================
   ACTION BUTTONS
========================= */

    .hero-actions {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;

        margin-bottom: 34px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;

        padding: 14px 24px;

        border-radius: 999px;

        font-weight: 600;

        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-4px);
    }

    .btn-white {
        background:
            linear-gradient(135deg,
                #ffffff,
                #f1f5f9);

        color: #0f172a;

        box-shadow:
            0 12px 30px rgba(255, 255, 255, 0.15);
    }

    .btn-white:hover {
        box-shadow:
            0 16px 40px rgba(255, 255, 255, 0.25);
    }

    .btn-outline {
        border:
            1px solid rgba(255, 255, 255, 0.18);

        background:
            rgba(255, 255, 255, 0.08);

        color: #fff;

        backdrop-filter: blur(12px);
    }

    .btn-outline:hover {
        background:
            rgba(255, 255, 255, 0.14);

        border-color:
            rgba(255, 255, 255, 0.30);
    }

    /* =========================
   RATING
========================= */

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

        filter:
            drop-shadow(0 0 8px rgba(251, 191, 36, 0.5));
    }

    .hero-rating span {
        color: #e2e8f0;
    }

    /* =========================
   STATS
========================= */

    .hero-stats {
        display: flex;
        gap: 18px;
        flex-wrap: wrap;
    }

    .stat-chip {
        min-width: 150px;

        padding: 18px 20px;

        border-radius: 22px;

        background:
            linear-gradient(135deg,
                rgba(255, 255, 255, 0.12),
                rgba(255, 255, 255, 0.04));

        border:
            1px solid rgba(255, 255, 255, 0.10);

        backdrop-filter: blur(12px);

        transition: 0.35s ease;
    }

    .stat-chip:hover {
        transform: translateY(-6px);

        border-color:
            rgba(74, 222, 128, 0.40);

        box-shadow:
            0 20px 40px rgba(0, 0, 0, 0.25);
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

    /* =========================
   RIGHT CARD
========================= */

    .hero-card-wrapper {
        position: relative;

        animation: fadeUp 1.2s ease;
    }

    .hero-card {
        position: relative;

        padding: 32px;

        border-radius: 30px;

        background:
            linear-gradient(135deg,
                rgba(255, 255, 255, 0.12),
                rgba(255, 255, 255, 0.04));

        border:
            1px solid rgba(255, 255, 255, 0.12);

        backdrop-filter: blur(16px);

        overflow: hidden;

        box-shadow:
            0 20px 60px rgba(0, 0, 0, 0.25);
    }

    .hero-card::before {
        content: "";

        position: absolute;

        top: -80px;
        right: -80px;

        width: 220px;
        height: 220px;

        border-radius: 50%;

        background:
            radial-gradient(circle,
                rgba(74, 222, 128, 0.20),
                transparent 70%);
    }

    .map-modal {

        position: fixed;
        inset: 0;

        background: rgba(0, 0, 0, 0.7);

        display: flex;
        align-items: center;
        justify-content: center;

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
    }

    .map-frame iframe {

        width: 100%;
        height: 500px;

        border: none;
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
    }

    .location-item {

        cursor: pointer;

        transition: 0.25s;
    }

    .location-item:hover {

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
   CARD HEADER
========================= */

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: start;

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

    /* =========================
   CARD ITEMS
========================= */

    .card-list {
        display: grid;
        gap: 16px;
    }

    .card-item {
        display: flex;
        gap: 16px;
        align-items: start;

        padding: 18px;

        border-radius: 22px;

        background:
            rgba(15, 23, 42, 0.45);

        border:
            1px solid rgba(255, 255, 255, 0.06);

        transition: 0.35s ease;
    }

    .card-item:hover {
        transform: translateX(6px);

        background:
            rgba(15, 23, 42, 0.65);

        border-color:
            rgba(255, 255, 255, 0.14);
    }

    .item-icon {
        min-width: 52px;
        height: 52px;

        border-radius: 16px;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 20px;

        background:
            linear-gradient(135deg,
                rgba(255, 255, 255, 0.12),
                rgba(255, 255, 255, 0.04));
    }

    /* icon colors */

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

    @media (max-width: 1024px) {

        .hero-grid {
            grid-template-columns: 1fr;
        }

        .hero-card-wrapper {
            max-width: 700px;
        }

    }

    @media (max-width: 768px) {

        .hero-inner {
            padding: 170px 18px 90px;
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
            grid-template-columns: 1fr;
        }

    }

    .card-list {
        display: grid;
        gap: 12px;
    }

    .card-item {
        padding: 14px 16px;

        border-radius: 18px;

        background: rgba(15, 23, 42, 0.4);

        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .card-item strong {
        color: #fff;
    }

    .card-item span {
        font-size: 13px;
        color: #cbd5e1;
    }

    .container {
        max-width: 1280px;
        margin: auto;
        padding: 0 30px;
    }

    .search-box {
        margin-top: -70px;

        position: relative;
        z-index: 5;

        background: #fff;
        color: #111827;

        border-radius: 28px;

        padding: 30px;

        box-shadow: 0 24px 60px rgba(0, 0, 0, 0.15);
    }

    .search-head h2 {
        font-family: 'Playfair Display', serif;
        font-size: 34px;
        margin-bottom: 20px;
    }

    .search-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 16px;
        align-items: end;
    }

    .field label {
        display: block;

        margin-bottom: 8px;

        font-size: 13px;
        font-weight: 600;

        color: #334155;
    }

    input,
    select,
    textarea {
        width: 100%;

        padding: 14px 16px;

        border-radius: 14px;

        border: 1px solid #dbe3ee;

        background: #f8fafc;

        outline: none;

        font-family: inherit;
    }

    input:focus,
    select:focus,
    textarea:focus {
        border-color: #94a3b8;
        background: #fff;

        box-shadow: 0 0 0 4px rgba(148, 163, 184, 0.18);
    }

    .rooms-section {
        padding: 90px 0;
    }

    .section-title {
        display: flex;
        justify-content: space-between;
        align-items: end;

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

    .room-card:hover {
        transform: translateY(-8px);
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

    .welcome-box {
        margin-top: 40px;

        background: #fff;
        color: #111827;

        padding: 30px;

        border-radius: 28px;
    }

    .info-strip {
        margin-top: 36px;

        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));

        gap: 18px;
    }

    .info-card {
        background: rgba(255, 255, 255, 0.06);

        border: 1px solid rgba(255, 255, 255, 0.08);

        border-radius: 22px;

        padding: 22px;

        backdrop-filter: blur(10px);
    }

    .info-card h4 {
        margin-bottom: 10px;
        color: #fff;
    }

    .info-card p {
        color: #cbd5e1;
        font-size: 14px;
    }

    .empty-box {
        background: #fff;
        color: #111827;

        padding: 20px;

        border-radius: 20px;
    }

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

    @media (max-width: 1200px) {
        .search-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 1024px) {
        .hero-grid {
            grid-template-columns: 1fr;
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
            padding: 12px 60px;
        }

        .hero-inner {
            padding: 170px 18px 80px;
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
    }

    #about,
    #contact,
    #services {
        scroll-margin-top: 100px;
    }
</style>