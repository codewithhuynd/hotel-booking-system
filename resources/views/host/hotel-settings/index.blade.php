@extends('host.layouts.app')

@section('title', 'Hotel Settings')

@section('content')

<style>
    /* Tổng thể & Typography */
    .settings-container {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
        color: #1e293b;
    }
    .settings-container h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #0f172a;
        margin-top: 0;
        margin-bottom: 1.5rem;
    }

    /* Khối thông báo thành công (Alert) */
    .settings-container .alert-success {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
        font-weight: 500;
        color: #15803d;
        background: #f0fdf4;
        border-left: 4px solid #16a34a;
    }

    /* Khối thẻ thông tin (Card) */
    .settings-container .card {
        background: white;
        padding: 1.75rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    }
    
    /* Phân vùng nhóm thông tin */
    .settings-section {
        margin-bottom: 1.75rem;
    }
    .settings-section:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    .settings-section h2 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #475569;
        margin-top: 0;
        margin-bottom: 1.25rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #f1f5f9;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Hệ thống hiển thị dạng lưới (Grid) */
    .settings-container .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.25rem;
    }
    .settings-container .field label {
        display: block;
        font-size: 0.75rem;
        font-weight: 600;
        color: #94a3b8;
        margin-bottom: 0.35rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .settings-container .field .value {
        font-size: 0.95rem;
        font-weight: 500;
        color: #1e293b;
        word-break: break-word;
    }
    .settings-container .link-text {
        color: #2563eb;
        text-decoration: none;
    }
    .settings-container .link-text:hover {
        text-decoration: underline;
    }

    /* Tinh chỉnh phần hiển thị ảnh Hero */
    .hero-preview-container {
        margin-top: 1rem;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        max-width: 100%;
        background: #f8fafc;
    }
    .hero-preview-img {
        display: block;
        width: 100%;
        max-height: 280px;
        object-fit: cover; /* Giúp ảnh không bị méo khi co giãn */
    }
    .no-image-box {
        padding: 2rem;
        text-align: center;
        color: #94a3b8;
        font-style: italic;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 8px;
    }

    /* Nút hành động Chỉnh sửa */
    .btn-edit-settings {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 18px;
        background: #2563eb;
        color: white !important;
        text-decoration: none;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        transition: background-color 0.15s ease, transform 0.1s ease;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }
    .btn-edit-settings:hover {
        background: #1d4ed8;
    }
    .btn-edit-settings:active {
        transform: scale(0.98);
    }
</style>

<div class="settings-container">

    <h1>Hotel Settings</h1>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        
        <!-- Nhóm 1: Nội dung cấu hình Banner chính -->
        <div class="settings-section">
            <h2>Hero Section</h2>
            <div class="grid" style="grid-template-columns: 1fr;">
                <div class="field">
                    <label>Hero Title</label>
                    <div class="value" style="font-size: 1.25rem; font-weight: 600; color: #0f172a;">
                        {{ $setting->hero_title }}
                    </div>
                </div>
                
                <div class="field">
                    <label>Hero Description</label>
                    <div class="value" style="color: #475569; line-height: 1.5;">
                        {{ $setting->hero_description }}
                    </div>
                </div>

                <!-- KHU VỰC HIỂN THỊ HERO IMAGE -->
                <div class="field" style="margin-top: 0.5rem;">
                    <label>Hero Image Preview</label>
                    @if($setting->hero_image)
                        <div class="hero-preview-container">
                            <img 
                                src="{{ asset('storage/' . $setting->hero_image) }}" 
                                class="hero-preview-img" 
                                alt="Hero Banner Preview"
                            >
                        </div>
                    @else
                        <div class="no-image-box">
                            Chưa có ảnh Hero Image nào được tải lên.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <br>

        <!-- Nhóm 2: Thông tin liên hệ công khai -->
        <div class="settings-section">
            <h2>Contact Details</h2>
            <div class="grid">
                <div class="field">
                    <label>Hotline</label>
                    <div class="value" style="font-weight: 600;">{{ $setting->hotline }}</div>
                </div>

                <div class="field">
                    <label>Email Address</label>
                    <div class="value">{{ $setting->email }}</div>
                </div>

                <div class="field">
                    <label>Working Hours</label>
                    <div class="value">{{ $setting->working_hours }}</div>
                </div>

                <div class="field" style="grid-column: 1 / -1;">
                    <label>Address</label>
                    <div class="value">{{ $setting->address }}</div>
                </div>

                <div class="field">
                    <label>Facebook Page</label>
                    <div class="value">
                        @if($setting->facebook_link)
                            <a href="{{ $setting->facebook_link }}" target="_blank" class="link-text">Đi tới trang liên kết ↗</a>
                        @else
                            <span style="color: #cbd5e1;">—</span>
                        @endif
                    </div>
                </div>

                <div class="field">
                    <label>Google Maps</label>
                    <div class="value">
                        @if($setting->google_map_link)
                            <a href="{{ $setting->google_map_link }}" target="_blank" class="link-text">Xem vị trí trên bản đồ ↗</a>
                        @else
                            <span style="color: #cbd5e1;">—</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #f1f5f9;">
            <a href="{{ route('host.hotel-settings.edit') }}" class="btn-edit-settings">
                Edit Settings
            </a>
        </div>

    </div>

</div>

@endsection