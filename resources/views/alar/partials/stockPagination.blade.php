<div class="d-flex justify-content-center mt-3">
    <nav>
        <ul class="pagination mb-0">
            <li class="page-item {{ $stoData->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $stoData->previousPageUrl() }}">&laquo;</a>
            </li>

            @for ($i = 1; $i <= $stoData->lastPage(); $i++)
                <li class="page-item {{ $stoData->currentPage() == $i ? 'active' : '' }}">
                    <a class="page-link"
                       href="{{ $stoData->appends(request()->query())->url($i) }}">
                        {{ $i }}
                    </a>
                </li>
            @endfor

            <li class="page-item {{ $stoData->currentPage() == $stoData->lastPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $stoData->nextPageUrl() }}">&raquo;</a>
            </li>
        </ul>
    </nav>
</div>

<div class="text-center text-secondary mt-2">
    Showing {{ $stoData->firstItem() ?? 0 }}
    to {{ $stoData->lastItem() ?? 0 }}
    of {{ $stoData->total() }} results
</div>
