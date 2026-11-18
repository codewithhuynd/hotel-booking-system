{{--
    Thanh tìm kiếm / lọc dùng chung cho các danh sách quản trị.
    Tham số:
      $action       URL gửi form (GET)
      $placeholder  gợi ý ô tìm kiếm
      $selects      [['name' => 'status', 'label' => 'Trạng thái', 'options' => ['value' => 'Nhãn']], ...]
      $dates        (tuỳ chọn) [['name' => 'from', 'label' => 'Nhận phòng từ'], ...]
--}}
@php
    $fieldStyle = 'padding:10px 12px;border:1px solid #dbe2ea;border-radius:10px;background:#fff;font-size:14px;color:#0f172a;box-sizing:border-box;';
    $hasFilter = collect(request()->except('page'))->filter(fn ($value) => filled($value))->isNotEmpty();
@endphp

<form method="GET" action="{{ $action }}"
    style="display:flex;flex-wrap:wrap;gap:10px;align-items:flex-end;background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:14px;margin-bottom:18px;">

    <div style="flex:1 1 240px;">
        <label style="display:block;font-size:12px;font-weight:700;color:#64748b;margin-bottom:6px;">Tìm kiếm</label>
        <input type="search" name="q" value="{{ request('q') }}" placeholder="{{ $placeholder }}"
            style="{{ $fieldStyle }}width:100%;">
    </div>

    @foreach ($selects ?? [] as $select)
        <div style="flex:0 1 180px;">
            <label style="display:block;font-size:12px;font-weight:700;color:#64748b;margin-bottom:6px;">{{ $select['label'] }}</label>
            <select name="{{ $select['name'] }}" style="{{ $fieldStyle }}width:100%;">
                <option value="">Tất cả</option>
                @foreach ($select['options'] as $value => $label)
                    <option value="{{ $value }}" @selected((string) request($select['name']) === (string) $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    @endforeach

    @foreach ($dates ?? [] as $date)
        <div style="flex:0 1 160px;">
            <label style="display:block;font-size:12px;font-weight:700;color:#64748b;margin-bottom:6px;">{{ $date['label'] }}</label>
            <input type="date" name="{{ $date['name'] }}" value="{{ request($date['name']) }}" style="{{ $fieldStyle }}width:100%;">
        </div>
    @endforeach

    <div style="display:flex;gap:8px;">
        <button type="submit"
            style="border:none;background:#1e293b;color:#fff;padding:10px 18px;border-radius:10px;font-size:14px;font-weight:700;cursor:pointer;">
            Lọc
        </button>

        @if ($hasFilter)
            <a href="{{ $action }}"
                style="display:inline-block;background:#f1f5f9;color:#475569;padding:10px 14px;border-radius:10px;font-size:14px;font-weight:700;text-decoration:none;">
                Xoá lọc
            </a>
        @endif
    </div>
</form>
