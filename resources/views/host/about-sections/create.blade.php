@extends('host.layouts.app')

@section('title', 'Add About Section')

@section('content')

<style>
    /* Tổng thể & Typography */
    .add-section-container {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        color: #1e293b;
    }
    .add-section-container h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #0f172a;
        margin-top: 0;
        margin-bottom: 1.5rem;
    }

    /* Khối thẻ chứa form (Card) */
    .add-section-container .card {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    }

    /* Khung nhóm ô nhập liệu */
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        margin-bottom: 1.5rem;
    }
    .form-group label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Thiết kế ô nhập liệu hiện đại */
    .form-group input[type="text"],
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
        border-color: #16a34a;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
    }

    /* Định dạng thông báo lỗi */
    .error-message {
        color: #dc2626;
        font-size: 0.85rem;
        margin: 2px 0 0 0;
        font-weight: 500;
    }

    /* Nút bấm Lưu gốc duy nhất của bạn */
    .btn-save {
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
    .btn-save:hover {
        background: #15803d;
    }
    .btn-save:active {
        transform: scale(0.98);
    }
</style>

<div class="add-section-container">

    <h1>Add About Section</h1>

    <div class="card">
        <form method="POST" action="{{ route('host.about-sections.store') }}">
            @csrf

            <div class="form-group">
                <label>Title</label>
                <input 
                    type="text" 
                    name="title" 
                    value="{{ old('title') }}"
                >
                @error('title') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea 
                    name="description" 
                    rows="5"
                >{{ old('description') }}</textarea>
                @error('description') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Chỉ giữ duy nhất một nút Save gốc -->
            <div style="margin-top: 1.75rem; padding-top: 1.25rem; border-top: 1px solid #f1f5f9;">
                <button type="submit" class="btn-save">
                    Save
                </button>
            </div>
        </form>
    </div>

</div>

@endsection