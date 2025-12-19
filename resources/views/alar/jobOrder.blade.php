@extends('layouts.layout')
@section('title', 'Job Order')

@section('content')
@section('head', 'Job Order')

<div class="d-flex align-items-center justify-content-between p-2 mb-0 cust-h-heading">
    @session('promt')
        <h2 class="fw-semibold bg-danger-subtle">{{ $value }}</h2>
    @endsession
    <div class="input-group cust-searchbar">
        <input type="text" id="searchInput" class="form-control" placeholder="Search"
            style="border-radius: 0; border: none;">
        <div class="cust-fit-w">
            <select class="form-select" id="sortSelect" onchange="applySort()" style="border-radius: 0; border: none;">
                <option value="all">All</option>
                <option value="pending">Pending</option>
                <option value="paid">Paid</option>
                <option value="package">Package</option>
                <option value="service">Service</option>
            </select>
        </div>
        <button class="cust-btn cust-btn-search" id="clearSearch">Clear</button >
        
    </div>
    
    <div class="row">
        <div class="col col-auto">
            <div class="dropdown">
                <button class="cust-btn cust-btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-plus-lg"></i> New Job Order
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('Service-Request.create') }}" class="dropdown-item">
                            <span>New Service</span>
                        </a></li>
                    <li>
                        <a href="{{ route('Job-Order.create') }}" class="dropdown-item">
                            <span>New Package</span>
                        </a>
                    </li>
                </ul>
            </div>
            
        </div>
    </div>
    
</div>

{{-- table --}}
<div class="cust-h-content">
    <table class="table table-hover mb-0">
        <thead>
            <tr class="table-light">
               <th class="fw-semibold">Client</th>
                <th class="fw-semibold">GL</th>
                <th class="fw-semibold">RA</th>
                <th class="fw-semibold">Address</th>
                <th class="fw-semibold">Casket</th>
                <th class="fw-semibold">Amount</th>
                <th class="fw-semibold">Contact #</th>
                <th class="col col-md-2 fw-semibold text-center">Action</th>
            </tr>
        </thead>
    
        <tbody id="tableBody">
    
            @if ($jOData->isEmpty())
                <tr>
                    <td colspan="9" class="text-center text-secondary py-3">
                        No New Job Order.
                    </td>
                </tr>
            @else
                @foreach ($jOData as $row)
                    <tr class="{{ $row->joToSvcReq->svc_status == 'Completed' ? ($row->jo_status != 'Paid' ? 'cust-warning-row' : 'cust-success-row') : '' }}">
                        {{-- Safely display the package name (avoid null errors) --}}
                        <td>{{ $row->client_name ?? '—'  }}</td>
                        <td>{{ $row->ba_id ? '₱'.$row->joToBurAsst->amount : 'N/A' }}</td>
                        <td>                     
                            <form action="{{ route('Job-Order.raUpdate', $row->id) }}" method="POST" class="raForm">
                                @csrf
                                @method('put')
                                <label>
                                    <input type="checkbox" name="status" class="raCheckbox" {{ $row->ra ? 'checked' : '' }} {{ $row->ba_id || $row->jo_status == 'Paid' || !$row->jod_id ? 'disabled' : '' }}>
                                </label>
                            </form>
                        </td>
                        <td>{{ $row->client_address }}</td>
                        <td>{{ $row->jod_id ? $row->joToJod->jodToPkg->pkg_name : 'N/A' }}</td>
                        <td class="{{ $row->jo_status == "Paid" ? 'cust-success-td' : '' }}">{{ $row->jo_status == "Paid" ? $row->jo_status : '₱'.number_format($row->jo_total, 2) }}</td>
                        <td>{{ $row->client_contact_number ?? '—' }}</td>
                        <td class="text-center col col-md-2">
                            
                            <div class="d-inline-flex justify-content-center gap-2">
                                @if($row->jod_id)
                                    @if($row->joToJod->jod_eq_stat == 'Pending')
                                        <a href="{{ route('Job-Order.showDeploy', $row->id) }}"
                                            class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Deploy">
                                            <i class="bi bi-box-arrow-up"></i>
                                        </a>
                                    @endif
                                    @if($row->joToJod->jod_eq_stat == 'Deployed')
                                        <a href="{{ route('Job-Order.showReturn', $row->id) }}"
                                            class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Return">
                                            <i class="bi bi-box-arrow-in-down"></i>
                                        </a>
                                    @endif
                                    @if($row->joToJod->jod_eq_stat == 'Returned')
                                        <a href="{{ route('Job-Order.show', $row->id) }}"
                                            class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <i class="fi fi-rr-eye"></i>
                                        </a>
                                    @endif
                                @endif
                                @if($row->svc_id && !$row->jod_id)
                                    @if($row->joToSvcReq->svc_status == 'Completed')
                                        <a href="{{ route('Service-Request.show', $row->id) }}"
                                            class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <i class="fi fi-rr-eye"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('Service-Request.show', $row->id) }}"
                                            class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Review Service">
                                            <i class="bi bi-list-ul"></i>
                                        </a>
                                    @endif
                                @endif
                            </div>                     
                           
                        </td>
                    </tr>
                @endforeach
                <script>
                    document.querySelectorAll('.raCheckbox').forEach((checkbox) => {
                        checkbox.addEventListener('change', function() {
                            // submit the form that contains this checkbox
                            this.closest('form').submit();
                        });
                    });
                </script>
            @endif
    
        </tbody>
    </table>
    <script>
        // Filter 
        function applySort() {
            const value = document.getElementById('sortSelect').value;
            const rows = document.querySelectorAll('#tableBody tr');

            rows.forEach(row => {
                const amountText = row.cells[5]?.innerText.trim(); // Amount column
                const casketText = row.cells[4]?.innerText.trim(); // Casket column

                const isPaid = amountText === 'Paid';
                const hasCasket = casketText !== 'N/A' && casketText !== '';

                let showRow = true;

                if (value === 'paid') {
                    showRow = isPaid;
                } 
                else if (value === 'pending') {
                    showRow = !isPaid;
                }
                else if (value === 'package') {
                    showRow = hasCasket;
                }
                else if (value === 'service') {
                    showRow = !hasCasket;
                }

                row.style.display = showRow ? '' : 'none';
            });
        }


    </script>
</div>

@endsection
