@if ($soaData->isEmpty())
    <tr>
        <td colspan="5" class="text-center text-secondary py-3">
            No records found.
        </td>
    </tr>
@else
    @foreach ($soaData as $row)
        <tr>
            <td>{{ $row->soaToJo->client_name }}</td>
            <td>
                {{ $row->soaToJo->jod_id
                    ? $row->soaToJo->joToJod->jodToPkg->pkg_name
                    : 'Service' }}
            </td>
            <td>₱{{ number_format($row->payment, 2) }}</td>
            <td>
                {{ $row->payment_date
                    ? \Carbon\Carbon::parse($row->payment_date)->format('d/M/Y')
                    : 'N/A' }}
            </td>
            <td>{{ $row->soaToEmp->emp_fname }} {{ $row->soaToEmp->emp_lname }}</td>
        </tr>
    @endforeach
@endif

<tr>
    <td colspan="5">
        {{-- Custom Pagination --}}
        <div class="d-flex justify-content-center mt-3">
            <nav>
                <ul class="pagination mb-0">
                    <li class="page-item {{ $soaData->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $soaData->previousPageUrl() }}">&laquo;</a>
                    </li>

                    @for ($i = 1; $i <= $soaData->lastPage(); $i++)
                        <li class="page-item {{ $soaData->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link"
                               href="{{ $soaData->appends(request()->query())->url($i) }}">
                                {{ $i }}
                            </a>
                        </li>
                    @endfor

                    <li class="page-item {{ $soaData->currentPage() == $soaData->lastPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $soaData->nextPageUrl() }}">&raquo;</a>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="text-center text-secondary mt-2">
            Showing {{ $soaData->firstItem() ?? 0 }}
            to {{ $soaData->lastItem() ?? 0 }}
            of {{ $soaData->total() }} results
        </div>
    </td>
</tr>
