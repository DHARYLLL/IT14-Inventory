<div class="d-flex justify-content-center mt-3">
    <nav>
        <ul class="pagination mb-0">
            <li class="page-item {{ $eqData->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $eqData->previousPageUrl() }}">&laquo;</a>
            </li>

            @for ($i = 1; $i <= $eqData->lastPage(); $i++)
                <li class="page-item {{ $eqData->currentPage() == $i ? 'active' : '' }}">
                    <a class="page-link"
                       href="{{ $eqData->appends(request()->query())->url($i) }}">
                        {{ $i }}
                    </a>
                </li>
            @endfor

            <li class="page-item {{ $eqData->currentPage() == $eqData->lastPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $eqData->nextPageUrl() }}">&raquo;</a>
            </li>
        </ul>
    </nav>
</div>

<div class="text-center text-secondary mt-2">
    Showing {{ $eqData->firstItem() ?? 0 }}
    to {{ $eqData->lastItem() ?? 0 }}
    of {{ $eqData->total() }} results
</div>
