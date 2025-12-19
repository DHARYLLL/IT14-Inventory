@forelse($jOData as $row)
<tr class="{{ $row->joToSvcReq->svc_status == 'Completed' ? ($row->jo_status != 'Paid' ? 'cust-warning-row' : 'cust-success-row') : '' }}">
    <td>{{ $row->client_name ?? '—' }}</td>
    <td>{{ $row->ba_id ? '₱'.number_format($row->joToBurAsst->amount, 2) : 'N/A' }}</td>
    <td>
        <form action="{{ route('Job-Order.raUpdate', $row->id) }}" method="POST">
            @csrf
            @method('put')
            <input type="checkbox" name="status" class="raCheckbox" {{ $row->ra ? 'checked' : '' }} {{ $row->ba_id || $row->jo_status == 'Paid' || !$row->jod_id ? 'disabled' : '' }}>
        </form>
    </td>
    <td>{{ $row->client_address }}</td>
    <td>{{ $row->jod_id ? $row->joToJod->jodToPkg->pkg_name : 'N/A' }}</td>
    <td class="{{ $row->jo_status == 'Paid' ? 'cust-success-td' : '' }}">
        {{ $row->jo_status == 'Paid' ? 'Paid' : '₱'.number_format($row->jo_total, 2) }}
    </td>
    <td>{{ $row->client_contact_number ?? '—' }}</td>
    <td class="text-center col-md-2">
        <div class="d-inline-flex justify-content-center gap-2">
            @if($row->jod_id)
                @if($row->joToJod->jod_eq_stat == 'Pending')
                    <a href="{{ route('Job-Order.showDeploy', $row->id) }}" class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Deploy">
                        <i class="bi bi-box-arrow-up"></i>
                    </a>
                @endif
                @if($row->joToJod->jod_eq_stat == 'Deployed')
                    <a href="{{ route('Job-Order.showReturn', $row->id) }}" class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Return">
                        <i class="bi bi-box-arrow-in-down"></i>
                    </a>
                @endif
                @if($row->joToJod->jod_eq_stat == 'Returned')
                    <a href="{{ route('Job-Order.show', $row->id) }}" class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                        <i class="fi fi-rr-eye"></i>
                    </a>
                @endif
            @endif

            @if($row->svc_id && !$row->jod_id)
                @if($row->joToSvcReq->svc_status == 'Completed')
                    <a href="{{ route('Service-Request.show', $row->id) }}" class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                        <i class="fi fi-rr-eye"></i>
                    </a>
                @else
                    <a href="{{ route('Service-Request.show', $row->id) }}" class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Review Service">
                        <i class="bi bi-list-ul"></i>
                    </a>
                @endif
            @endif
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="9" class="text-center text-secondary py-3">No New Job Order.</td>
</tr>
@endforelse
