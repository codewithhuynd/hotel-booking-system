@extends('host.layouts.app')

@section('title', 'Payment Methods')

@section('content')

<style>
    /* Tổng thể & Typography */
    .payment-container {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        color: #1e293b;
    }
    
    /* Cấu trúc Header phân tách nút tạo mới */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    .page-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    /* Nút tạo mới phương thức thanh toán */
    .btn-create {
        padding: 10px 18px;
        background: #16a34a;
        color: white !important;
        text-decoration: none;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        transition: background-color 0.15s ease;
        display: inline-flex;
        align-items: center;
    }
    .btn-create:hover {
        background: #15803d;
    }

    /* Thiết kế bảng quản trị hiện đại */
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

    /* Định dạng cột dữ liệu */
    .col-id { width: 70px; font-weight: 600; color: #64748b !important; }
    .col-name { font-weight: 600; color: #0f172a !important; }
    .col-type { font-weight: 500; color: #475569; }
    .col-qr { width: 120px; text-align: center; }
    .col-status { width: 130px; }
    .col-actions { width: 160px; white-space: nowrap; }

    /* Định dạng ảnh QR */
    .qr-preview {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        display: block;
        margin: 0 auto;
        background: #f8fafc;
    }
    .no-qr {
        font-size: 0.85rem;
        color: #94a3b8;
        font-style: italic;
    }

    /* Badge trạng thái Active / Inactive */
    .badge {
        display: inline-flex;
        padding: 4px 10px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.02em;
    }
    .badge-active {
        background: #dcfce7;
        color: #15803d;
    }
    .badge-inactive {
        background: #fee2e2;
        color: #b91c1c;
    }

    /* Nhóm nút hành động */
    .action-group {
        display: flex;
        gap: 8px;
        align-items: center;
    }
    .btn-edit {
        padding: 6px 14px;
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
        padding: 6px 14px;
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
</style>

<div class="payment-container">

    <div class="page-header">
        <h1>Payment Methods</h1>
        <a href="{{ route('host.payment-methods.create') }}" class="btn-create">
            Create Payment Method
        </a>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th class="col-id">ID</th>
                    <th class="col-name">Name</th>
                    <th>Type</th>
                    <th class="col-qr" style="text-align: center;">QR</th>
                    <th class="col-status">Status</th>
                    <th class="col-actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paymentMethods as $method)
                    <tr>
                        <td class="col-id">#{{ $method->id }}</td>
                        <td class="col-name">{{ $method->name }}</td>
                        <td class="col-type">{{ $method->type }}</td>
                        <td class="col-qr">
                            @if($method->qr_image)
                                <img 
                                    src="{{ asset('storage/' . $method->qr_image) }}" 
                                    class="qr-preview"
                                    alt="QR Code"
                                >
                            @else
                                <span class="no-qr">No QR</span>
                            @endif
                        </td>
                        <td class="col-status">
                            @if($method->is_active)
                                <span class="badge badge-active">Active</span>
                            @else
                                <span class="badge badge-inactive">Inactive</span>
                            @endif
                        </td>
                        <td class="col-actions">
                            <div class="action-group">
                                <a href="{{ route('host.payment-methods.edit', $method) }}" class="btn-edit">
                                    Edit
                                </a>

                                <form 
                                    method="POST" 
                                    action="{{ route('host.payment-methods.destroy', $method) }}"
                                    style="display:inline;"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button 
                                        type="submit" 
                                        class="btn-delete"
                                        onclick="return confirm('Delete?')"
                                    >
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection