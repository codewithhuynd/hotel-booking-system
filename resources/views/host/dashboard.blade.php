@extends('host.layouts.app')

@section('title', 'Thống kê khách sạn')

@section('content')
<div style="max-width:1400px;margin:auto">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:20px;flex-wrap:wrap;margin-bottom:24px">
        <div>
            <h1 style="font-size:30px;font-weight:800">Thống kê khách sạn</h1>
            <p style="color:#64748b;margin-top:6px">Tổng quan hoạt động trong khoảng thời gian đã chọn</p>
        </div>
        <form method="GET" action="{{ route('host.dashboard') }}" style="display:flex;gap:12px;align-items:end;flex-wrap:wrap">
            <label style="font-size:13px;color:#475569">Từ ngày<br><input type="date" name="date_from" value="{{ $dateFrom }}" required style="padding:10px;border:1px solid #cbd5e1;border-radius:10px"></label>
            <label style="font-size:13px;color:#475569">Đến ngày<br><input type="date" name="date_to" value="{{ $dateTo }}" required style="padding:10px;border:1px solid #cbd5e1;border-radius:10px"></label>
            <button style="padding:11px 18px;border:0;border-radius:10px;background:#059669;color:white;font-weight:700;cursor:pointer">Lọc thống kê</button>
        </form>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:16px;margin-bottom:22px">
        @foreach ([['Tổng doanh thu', number_format($stats['totalRevenue']).' ₫'], ['Tổng lượt đặt', number_format($stats['bookingCount'])], ['Booking đã hủy', number_format($stats['cancelledCount'])], ['Tiền đã hoàn', number_format($stats['refundTotal']).' ₫'], ['Công suất phòng', $stats['occupancyRate'].'%']] as [$label, $value])
            <div style="background:white;border-radius:18px;padding:22px;box-shadow:0 8px 24px #0f172a0c;border:1px solid #e2e8f0">
                <div style="color:#64748b;font-size:14px">{{ $label }}</div>
                <div style="font-size:26px;font-weight:800;margin-top:10px;color:#0f172a">{{ $value }}</div>
            </div>
        @endforeach
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(340px,1fr));gap:20px;margin-bottom:22px">
        <section style="background:white;border-radius:18px;padding:22px;border:1px solid #e2e8f0">
            <h2 style="font-size:18px;font-weight:750;margin-bottom:18px">Doanh thu theo tháng</h2>
            <canvas id="revenueChart" height="220"></canvas>
        </section>
        <section style="background:white;border-radius:18px;padding:22px;border:1px solid #e2e8f0">
            <h2 style="font-size:18px;font-weight:750;margin-bottom:18px">Booking theo trạng thái</h2>
            <canvas id="statusChart" height="220"></canvas>
        </section>
    </div>

    <section style="background:white;border-radius:18px;padding:22px;border:1px solid #e2e8f0">
        <h2 style="font-size:18px;font-weight:750;margin-bottom:18px">5 phòng được đặt nhiều nhất</h2>
        <div style="overflow-x:auto"><table style="width:100%;border-collapse:collapse;text-align:left">
            <thead><tr style="color:#64748b;border-bottom:1px solid #e2e8f0"><th style="padding:12px">Mã phòng</th><th style="padding:12px">Tên phòng</th><th style="padding:12px">Số lượt đặt</th></tr></thead>
            <tbody>
                @forelse ($stats['topRooms'] as $item)
                    <tr style="border-bottom:1px solid #f1f5f9"><td style="padding:12px">{{ $item['room']?->room_code ?? '—' }}</td><td style="padding:12px">{{ $item['room']?->room_name ?? 'Phòng đã xóa' }}</td><td style="padding:12px">{{ $item['count'] }}</td></tr>
                @empty
                    <tr><td colspan="3" style="padding:18px;color:#64748b">Chưa có lượt đặt trong khoảng thời gian này.</td></tr>
                @endforelse
            </tbody>
        </table></div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const revenue = @json($stats['monthlyRevenue']);
    const statuses = @json($stats['statusCounts']);
    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: { labels: Object.keys(revenue), datasets: [{ label: 'Doanh thu (₫)', data: Object.values(revenue), backgroundColor: '#10b981', borderRadius: 8 }] },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: { labels: Object.keys(statuses), datasets: [{ data: Object.values(statuses), backgroundColor: ['#f59e0b','#3b82f6','#10b981','#8b5cf6','#06b6d4','#64748b','#ef4444'] }] },
        options: { responsive: true }
    });
</script>
@endsection
