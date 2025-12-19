{{-- Custom Pagination --}}
<div class="d-flex justify-content-center mt-3">
    <nav aria-label="Page navigation">
        <ul class="pagination mb-0">

            {{-- Previous --}}
            <li class="page-item {{ $data->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $data->previousPageUrl() ?? '#' }}">
                    &laquo;
                </a>
            </li>

            {{-- Page numbers --}}
            @for ($i = 1; $i <= $data->lastPage(); $i++)
                <li class="page-item {{ $data->currentPage() == $i ? 'active' : '' }}">
                    <a class="page-link"
                       href="{{ $data->appends(request()->query())->url($i) }}">
                        {{ $i }}
                    </a>
                </li>
            @endfor

            {{-- Next --}}
            <li class="page-item {{ $data->currentPage() == $data->lastPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $data->nextPageUrl() ?? '#' }}">
                    &raquo;
                </a>
            </li>

        </ul>
    </nav>
</div>

{{-- Showing results --}}
<div class="text-center text-secondary mt-2">
    Showing {{ $data->firstItem() ?? 0 }}
    to {{ $data->lastItem() ?? 0 }}
    of {{ $data->total() ?? 0 }} results
</div>
