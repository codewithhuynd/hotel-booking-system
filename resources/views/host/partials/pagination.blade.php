{{-- Phân trang cho trang quản trị host (layout host không dùng Tailwind). --}}
@if ($paginator->hasPages())
    <nav style="display:flex;justify-content:center;align-items:center;gap:6px;flex-wrap:wrap;margin-top:20px;font-family:inherit;" aria-label="Phân trang">

        @php
            $base = 'display:inline-block;min-width:36px;padding:8px 12px;border-radius:8px;font-size:13px;font-weight:700;text-align:center;text-decoration:none;border:1px solid #e2e8f0;';
            $normal = $base.'background:#fff;color:#334155;';
            $active = $base.'background:#1e293b;color:#fff;border-color:#1e293b;';
            $disabled = $base.'background:#f8fafc;color:#cbd5e1;';
        @endphp

        @if ($paginator->onFirstPage())
            <span style="{{ $disabled }}">‹</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" style="{{ $normal }}">‹</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span style="{{ $disabled }}">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span style="{{ $active }}" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="{{ $normal }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" style="{{ $normal }}">›</a>
        @else
            <span style="{{ $disabled }}">›</span>
        @endif

        <span style="width:100%;text-align:center;font-size:12px;color:#94a3b8;margin-top:4px;">
            Hiển thị {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} / {{ $paginator->total() }} kết quả
        </span>
    </nav>
@endif
