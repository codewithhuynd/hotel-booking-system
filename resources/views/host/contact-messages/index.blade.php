@extends('host.layouts.app')

@section('title', 'Contact Messages')

@section('content')

<style>
    /* Tổng thể & Typography */
    .messages-container {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        color: #1e293b;
    }
    
    /* Thanh tiêu đề chính */
    .page-header {
        margin-bottom: 1.5rem;
    }
    .page-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
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

    /* Thiết kế Bảng quản trị hiện đại */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
        background: white;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        margin-bottom: 1.5rem;
    }
    .admin-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 0.95rem;
    }
    .admin-table th {
        background: #1e293b;
        color: white;
        padding: 14px 16px;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .admin-table td {
        padding: 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
    }
    .admin-table tr:last-child td {
        border-bottom: none;
    }
    .admin-table tr:hover td {
        background-color: #f8fafc;
    }

    /* Cố định kích thước các cột chức năng */
    .col-id { width: 70px; font-weight: 600; color: #64748b !important; }
    .col-name { font-weight: 600; color: #0f172a !important; }
    .col-status { width: 120px; }
    .col-created { width: 160px; color: #64748b; font-size: 0.9rem; }
    .col-actions { width: 160px; white-space: nowrap; }

    /* Cách điệu nhẹ cho tag trạng thái */
    .status-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        background: #f1f5f9;
        color: #475569;
    }

    /* Định dạng nhóm nút hành động */
    .action-group {
        display: flex;
        gap: 8px;
        align-items: center;
    }
    .btn-view {
        padding: 6px 12px;
        background: #2563eb;
        color: white !important;
        text-decoration: none;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: background-color 0.15s ease;
    }
    .btn-view:hover {
        background: #1d4ed8;
    }
    .btn-delete {
        padding: 6px 12px;
        background: #dc2626;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.15s ease;
    }
    .btn-delete:hover {
        background: #b91c1c;
    }

    /* Trạng thái dữ liệu trống */
    .empty-row {
        text-align: center !important;
        padding: 3rem !important;
        color: #94a3b8 !important;
        font-style: italic;
    }

    /* Hộp bọc pagination gọn gàng */
    .pagination-wrapper {
        margin-top: 1rem;
    }
</style>

<div class="messages-container">

    <div class="page-header">
        <h1>Contact Messages</h1>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th class="col-id">ID</th>
                    <th class="col-name">Name</th>
                    <th>Email</th>
                    <th>User</th>
                    <th class="col-status">Status</th>
                    <th class="col-created">Created</th>
                    <th class="col-actions">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $message)
                    <tr>
                        <td class="col-id">#{{ $message->id }}</td>
                        <td class="col-name">{{ $message->name }}</td>
                        <td>{{ $message->email }}</td>
                        <td style="color: #475569;">
                            {{ $message->user ? $message->user->full_name : 'Public user' }}
                        </td>
                        <td class="col-status">
                            <span class="status-badge">
                                {{ strtoupper($message->status) }}
                            </span>
                        </td>
                        <td class="col-created">
                            {{ $message->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="col-actions">
                            <div class="action-group">
                                <a href="{{ route('host.contact-messages.show', $message) }}" class="btn-view">
                                    View
                                </a>

                                <form method="POST" 
                                      action="{{ route('host.contact-messages.destroy', $message) }}" 
                                      style="display:inline;"
                                      onsubmit="return confirm('Delete this message?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-delete">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-row">
                            No messages.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $messages->links() }}
    </div>

</div>

@endsection