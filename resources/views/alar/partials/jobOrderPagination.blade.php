<div class="d-flex justify-content-center mt-3">
    <nav>
        <ul class="pagination mb-0">
            <li class="page-item {{ $jOData->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $jOData->previousPageUrl() }}">&laquo;</a>
            </li>

            @for ($i = 1; $i <= $jOData->lastPage(); $i++)
                <li class="page-item {{ $jOData->currentPage() == $i ? 'active' : '' }}">
                    <a class="page-link"
                       href="{{ $jOData->appends(request()->query())->url($i) }}">
                        {{ $i }}
                    </a>
                </li>
            @endfor

            <li class="page-item {{ $jOData->currentPage() == $jOData->lastPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $jOData->nextPageUrl() }}">&raquo;</a>
            </li>
        </ul>
    </nav>
</div>

<div class="text-center text-secondary mt-2">
    Showing {{ $jOData->firstItem() ?? 0 }}
    to {{ $jOData->lastItem() ?? 0 }}
    of {{ $jOData->total() }} results
</div>
