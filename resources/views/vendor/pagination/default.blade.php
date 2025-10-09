@if ($paginator->hasPages())
    <nav aria-label="Pagination" style="text-align: center; margin-top: 20px;">
        <ul style="list-style: none; display: inline-flex; padding: 0; gap: 8px;">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li style="opacity: 0.5;">&laquo;</li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" style="text-decoration: none;">&laquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li>{{ $element }}</li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li style="font-weight: bold; color: #28a745;">{{ $page }}</li>
                        @else
                            <li><a href="{{ $url }}" style="text-decoration: none;">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" style="text-decoration: none;">&raquo;</a>
                </li>
            @else
                <li style="opacity: 0.5;">&raquo;</li>
            @endif
        </ul>

        {{-- Results Summary --}}
        <div style="margin-top: 10px; font-size: 14px; color: #555;">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </div>
    </nav>
@endif
