@extends('host.layouts.app')

@section('title', 'Cài đặt khách sạn')

@section('content')

<style>
    .settings-container {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
        color: #1e293b;
    }

    .settings-container h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        color: #15803d;
        background: #f0fdf4;
        border-left: 4px solid #16a34a;
    }

    .card {
        background: white;
        padding: 1.75rem;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    .settings-section h2 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 1rem;
        text-transform: uppercase;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1rem;
    }

    .field label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #94a3b8;
        text-transform: uppercase;
    }

    .value {
        margin-top: 4px;
        font-weight: 500;
    }

    .btn-edit-settings {
        display: inline-block;
        margin-top: 1rem;
        padding: 10px 16px;
        background: #2563eb;
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
    }

    .btn-edit-settings:hover {
        background: #1d4ed8;
    }
</style>

<div class="settings-container">

    <h1>Cài đặt khách sạn</h1>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">

        <div class="settings-section">
            <h2>Thiết lập Hero</h2>

            <div class="grid" style="grid-template-columns:1fr;">
                
                <div class="field">
                    <label>Tiêu đề Hero</label>
                    <div class="value" style="font-size:20px; font-weight:700;">
                        {{ $setting->hero_title }}
                    </div>
                </div>

                <div class="field">
                    <label>Mô tả Hero</label>
                    <div class="value">
                        {{ $setting->hero_description }}
                    </div>
                </div>

                <div class="field">
                    <label>Ảnh Hero</label>
                    @if($setting->hero_image)
                        <img src="{{ asset('storage/' . $setting->hero_image) }}"
                             style="width:100%; border-radius:10px; margin-top:10px;">
                    @else
                        <div>Chưa có ảnh Hero</div>
                    @endif
                </div>

            </div>
        </div>

        <hr style="margin:20px 0;">

        <div class="settings-section">
            <h2>Thông tin liên hệ</h2>

            <div class="grid">

                <div class="field">
                    <label>Tỷ lệ đặt cọc</label>
                    <div class="value">
                        {{ number_format($setting->deposit_percent ?? 30) }}%
                    </div>
                </div>

                <div class="field">
                    <label>Hotline</label>
                    <div class="value">{{ $setting->hotline }}</div>
                </div>

                <div class="field">
                    <label>Email</label>
                    <div class="value">{{ $setting->email }}</div>
                </div>

                <div class="field">
                    <label>Giờ làm việc</label>
                    <div class="value">{{ $setting->working_hours }}</div>
                </div>

                <div class="field">
                    <label>Địa chỉ</label>
                    <div class="value">{{ $setting->address }}</div>
                </div>

                <div class="field">
                    <label>Facebook</label>
                    <div class="value">
                        {{ $setting->facebook_link ?? '—' }}
                    </div>
                </div>

                <div class="field">
                    <label>Google Maps</label>
                    <div class="value">
                        {{ $setting->google_map_link ?? '—' }}
                    </div>
                </div>

            </div>
        </div>

        <a href="{{ route('host.hotel-settings.edit') }}" class="btn-edit-settings">
            Chỉnh sửa cài đặt
        </a>

    </div>

</div>

@endsection