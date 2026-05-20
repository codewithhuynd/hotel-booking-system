@extends('host.layouts.app')

@section('title', 'Contact Message Detail')

@section('content')

<style>
    /* Tổng thể & Typography */
    .message-detail-container {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
        color: #1e293b;
    }
    .message-detail-container h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #0f172a;
        margin-top: 0;
        margin-bottom: 1.5rem;
    }

    /* Khối thông báo thành công (Alert) */
    .alert-success {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
        font-weight: 500;
        color: #15803d;
        background: #f0fdf4;
        border-left: 4px solid #16a34a;
    }

    /* Khối thẻ chứa nội dung chính (Card) */
    .detail-card {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    }

    /* Cấu trúc hàng thông tin (Metadata) */
    .meta-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .meta-row {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    .meta-label {
        font-size: 0.8rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .meta-value {
        font-size: 1rem;
        color: #0f172a;
        font-weight: 500;
    }

    /* Trạng thái tin nhắn (Badge) */
    .status-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        background: #f1f5f9;
        color: #475569;
        width: fit-content;
    }

    /* Các khối nội dung văn bản dài */
    .content-section {
        margin-bottom: 1.5rem;
    }
    .content-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: #334155;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }
    .message-box {
        background: #f8fafc;
        padding: 1.25rem;
        border-radius: 8px;
        color: #334155;
        line-height: 1.6;
        font-size: 0.95rem;
        border: 1px solid #f1f5f9;
        white-space: pre-line;
    }
    .reply-box {
        background: #f0fdfa;
        padding: 1.25rem;
        border-radius: 8px;
        color: #115e59;
        line-height: 1.6;
        font-size: 0.95rem;
        border: 1px solid #ccfbf1;
        white-space: pre-line;
    }

    /* Nút bấm hành động tương tác form */
    .btn-action-primary {
        padding: 10px 20px;
        background: #2563eb;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 600;
        transition: background-color 0.15s ease;
    }
    .btn-action-primary:hover {
        background: #1d4ed8;
    }
    .btn-action-disabled {
        padding: 10px 20px;
        background: #cbd5e1;
        color: #64748b;
        border: none;
        border-radius: 8px;
        cursor: not-allowed;
        font-size: 0.9rem;
        font-weight: 600;
    }
</style>

<div class="message-detail-container">

    <h1>Contact Message Detail</h1>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="detail-card">
        <!-- Khu vực thông tin Meta Grid -->
        <div class="meta-grid">
            <div class="meta-row">
                <span class="meta-label">Name</span>
                <span class="meta-value">{{ $contactMessage->name }}</span>
            </div>
            <div class="meta-row">
                <span class="meta-label">Email</span>
                <span class="meta-value" style="color: #2563eb;">{{ $contactMessage->email }}</span>
            </div>
            <div class="meta-row">
                <span class="meta-label">User</span>
                <span class="meta-value">
                    {{ $contactMessage->user ? $contactMessage->user->full_name : 'Public user' }}
                </span>
            </div>
            <div class="meta-row">
                <span class="meta-label">Created</span>
                <span class="meta-value">{{ $contactMessage->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="meta-row" style="grid-column: span 2;">
                <span class="meta-label">Status</span>
                <span class="status-badge">
                    {{ strtoupper($contactMessage->status) }}
                </span>
            </div>
        </div>

        <!-- Khối hiển thị Nội dung tin nhắn gửi đến -->
        <div class="content-section">
            <div class="content-title">Message</div>
            <div class="message-box">
                {{ $contactMessage->message }}
            </div>
        </div>

        <!-- Khối hiển thị phản hồi gần nhất nếu có -->
        @if($contactMessage->reply_message)
            <div class="content-section" style="margin-top: 1.75rem;">
                <div class="content-title">Last reply</div>
                <div class="reply-box">
                    {{ $contactMessage->reply_message }}
                </div>
            </div>
        @endif

        <!-- Form xử lý trạng thái tin nhắn gốc -->
        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #f1f5f9;">
            <form method="POST" action="{{ route('host.contact-messages.reply', $contactMessage) }}">
                @csrf

                @if($contactMessage->status !== 'replied')
                    <button type="submit" class="btn-action-primary">
                        Mark as Replied
                    </button>
                @else
                    <button type="button" class="btn-action-disabled" disabled>
                        Already Replied
                    </button>
                @endif
            </form>
        </div>
    </div>

</div>

@endsection