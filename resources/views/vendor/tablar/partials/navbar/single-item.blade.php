<a class="dropdown-item" href="{{ $item['href']??'' }}">
    {{-- {{ $item['text']??'' }} --}}
    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
        @if(isset($item['icon']))
            <i class="{{ $item['icon'] ?? '' }} {{
                isset($item['icon_color']) ? 'text-' . $item['icon_color'] : ''
            }}"></i>
        @else
            <i class="ti ti-brand-tabler"></i>
        @endif
    </span>
    <span class="nav-link-title">
        {{ $item['text']??'' }}
    </span>
</a>
