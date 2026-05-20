
@extends('host.layouts.app')

@section('title', 'Manage Services')

@section('content')

<style>
    /* Tổng thể & Typography */
    .services-container {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        max-width: 1100px;
        margin: 0 auto;
        padding: 20px;
        color: #1e293b;
    }
    
    /* Thanh tiêu đề và nút Thêm mới */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    .page-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }
    .btn-create {
        display: inline-flex;
        align-items: center;
        padding: 10px 16px;
        background: #16a34a;
        color: white !important;
        text-decoration: none;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        transition: background-color 0.15s ease;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }
    .btn-create:hover {
        background: #15803d;
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
    .col-id { width: 80px; font-weight: 600; color: #64748b !important; }
    .col-title { width: 220px; font-weight: 600; color: #0f172a !important; }
    .col-actions { width: 160px; white-space: nowrap; }

    /* Định dạng nhóm nút hành động */
    .action-group {
        display: flex;
        gap: 8px;
        align-items: center;
    }
    .btn-edit {
        padding: 6px 12px;
        background: #2563eb;
        color: white !important;
        text-decoration: none;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: background-color 0.15s ease;
    }
    .btn-edit:hover {
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
</style>

<div class="services-container">

    <div class="page-header">
        <h1>Manage Services</h1>
        <a href="{{ route('host.services.create') }}" class="btn-create">
            Add New
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th class="col-id">ID</th>
                    <th class="col-title">Title</th>
                    <th>Description</th>
                    <th class="col-actions">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    <tr>
                        <td class="col-id">#{{ $service->id }}</td>
                        <td class="col-title">{{ $service->title }}</td>
                        <td style="line-height: 1.5; color: #475569;">
                            {{ Str::limit($service->description, 120, '...') }}
                        </td>
                        <td class="col-actions">
                            <div class="action-group">
                                <a href="{{ route('host.services.edit', $service) }}" class="btn-edit">
                                    Edit
                                </a>

                                <form action="{{ route('host.services.destroy', $service) }}"
                                      method="POST"
                                      style="display:inline-block;"
                                      onsubmit="return confirm('Delete this item?')">
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
                        <td colspan="4" class="empty-row">
                            No services found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection