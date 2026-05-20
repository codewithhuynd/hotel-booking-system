@extends('host.layouts.app')

@section('title', 'Edit Hotel Settings')

@section('content')

<style>
    /* Tổng thể & Typography */
    .edit-settings-container {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
        color: #1e293b;
    }
    .edit-settings-container h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #0f172a;
        margin-top: 0;
        margin-bottom: 1.5rem;
    }

    /* Khối thẻ form (Card) */
    .edit-settings-container .card {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    }

    /* Phân vùng nhóm form */
    .form-section {
        margin-bottom: 2rem;
    }
    .form-section h2 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #475569;
        margin-top: 0;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #f1f5f9;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Hệ thống lưới ô nhập liệu (Grid Form) */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 1.25rem;
    }
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }
    .form-group.full-width {
        grid-column: 1 / -1;
    }

    /* Thiết kế nhãn và ô nhập liệu */
    .form-group label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #475569;
    }
    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="url"],
    .form-group textarea {
        font-family: inherit;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 10px 14px;
        background-color: #fff;
        color: #1e293b;
        font-size: 0.95rem;
        width: 100%;
        box-sizing: border-box;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }
    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    /* Định dạng thông báo lỗi validation */
    .error-message {
        color: #dc2626;
        font-size: 0.85rem;
        margin: 2px 0 0 0;
        font-weight: 500;
    }

    /* Thiết kế khu vực Upload file & Thumbnail */
    .file-upload-wrapper {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .file-input-custom {
        font-size: 0.9rem;
        color: #475569;
    }
    .file-input-custom::-webkit-file-upload-button {
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        padding: 8px 14px;
        border-radius: 6px;
        font-weight: 600;
        color: #334155;
        cursor: pointer;
        margin-right: 10px;
        transition: background 0.15s ease;
    }
    .file-input-custom::-webkit-file-upload-button:hover {
        background: #e2e8f0;
    }
    .current-image-preview {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 0.5rem;
        padding: 8px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        max-width: max-content;
    }
    .current-image-preview img {
        width: 80px;
        height: 50px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #cbd5e1;
    }

    /* Hệ thống nút bấm chính chủ của bạn */
    .btn-submit {
        padding: 12px 24px;
        background: #16a34a;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.95rem;
        font-weight: 600;
        transition: background-color 0.15s ease, transform 0.1s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .btn-submit:hover {
        background: #15803d;
    }
    .btn-submit:active {
        transform: scale(0.98);
    }
</style>

<div class="edit-settings-container">

    <h1>Edit Hotel Settings</h1>

    <div class="card">
        <form method="POST" action="{{ route('host.hotel-settings.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- PHẦN 1: CẤU HÌNH BANNER CHÍNH (HERO) -->
            <div class="form-section">
                <h2>Hero Section</h2>
                
                <div class="form-grid" style="grid-template-columns: 1fr;">
                    <div class="form-group">
                        <label>Hero Title</label>
                        <input 
                            type="text" 
                            name="hero_title" 
                            value="{{ old('hero_title', $setting->hero_title) }}"
                        >
                        @error('hero_title') <p class="error-message">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label>Hero Description</label>
                        <textarea 
                            name="hero_description" 
                            rows="4"
                        >{{ old('hero_description', $setting->hero_description) }}</textarea>
                        @error('hero_description') <p class="error-message">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label>Hero Image</label>
                        <div class="file-upload-wrapper">
                            <input type="file" name="hero_image" class="file-input-custom">
                            
                            @if($setting->hero_image)
                                <div class="current-image-preview">
                                    <img src="{{ asset('storage/' . $setting->hero_image) }}" alt="Current Hero Image">
                                    <div style="font-size: 0.85rem; color: #64748b;">
                                        <span style="display:block; font-weight: 500; color: #334155;">Current:</span>
                                        <span style="font-family: monospace; font-size: 0.8rem;">{{ $setting->hero_image }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @error('hero_image') <p class="error-message">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- PHẦN 2: THÔNG TIN LIÊN HỆ -->
            <div class="form-section">
                <h2>Contact Details</h2>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label>Hotline</label>
                        <input 
                            type="text" 
                            name="hotline" 
                            value="{{ old('hotline', $setting->hotline) }}"
                        >
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input 
                            type="email" 
                            name="email" 
                            value="{{ old('email', $setting->email) }}"
                        >
                    </div>

                    <div class="form-group">
                        <label>Working Hours</label>
                        <input 
                            type="text" 
                            name="working_hours" 
                            value="{{ old('working_hours', $setting->working_hours) }}"
                        >
                    </div>

                    <div class="form-group full-width">
                        <label>Address</label>
                        <input 
                            type="text" 
                            name="address" 
                            value="{{ old('address', $setting->address) }}"
                        >
                    </div>

                    <div class="form-group">
                        <label>Facebook Link</label>
                        <input 
                            type="url" 
                            name="facebook_link" 
                            value="{{ old('facebook_link', $setting->facebook_link) }}"
                        >
                    </div>

                    <div class="form-group">
                        <label>Google Map Link</label>
                        <input 
                            type="url" 
                            name="google_map_link" 
                            value="{{ old('google_map_link', $setting->google_map_link) }}"
                        >
                    </div>
                </div>
            </div>

            <!-- NÚT BẤM LƯU GỐC DUY NHẤT -->
            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #f1f5f9;">
                <button type="submit" class="btn-submit">
                    Save
                </button>
            </div>
        </form>
    </div>

</div>

@endsection