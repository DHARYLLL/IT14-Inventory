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
        <button class="cust-btn cust-btn-search" id="clearSearch">Clear</button>
    </div>
    <div class="row">
        <div class="col col-auto">
            <a href="{{ route('Service-Request.create') }}" class="cust-btn cust-btn-primary"><i
                class="bi bi-plus-lg"></i> <span>Service</span></a>
        </div>
        <div class="col col-auto">
            <a href="{{ route('Job-Order.create') }}" class="cust-btn cust-btn-primary"><i
                class="bi bi-plus-lg"></i> <span>Package</span></a>
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
                <th class="fw-semibold">Action</th>
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
                    <tr>
                        {{-- Safely display the package name (avoid null errors) --}}
                        <td>{{ $row->client_name ?? '—'  }}</td>
                        <td>{{ $row->ba_id ? '₱'.$row->joToBurrAsst->amount : 'N/A' }}</td>
                        <td>                     
                            <form action="{{ route('Job-Order.raUpdate', $row->id) }}" method="POST" class="raForm">
                                @csrf
                                @method('put')
                                <label>
                                    <input type="checkbox" name="status" class="raCheckbox" {{ $row->ra ? 'checked' : '' }}>
                                </label>
                            </form>
                        </td>
                        <td>{{ $row->client_address }}</td>
                        <td>{{ $row->jod_id ? $row->joToJod->jodToPkg->pkg_name : 'N/A' }}</td>
                        <td>{{ $row->jo_status == "Paid" ? $row->jo_status :$row->jo_total }}</td>
                        <td>{{ $row->client_contact_number ?? '—' }}</td>
                        <td>
                            
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
                            @if($row->svc_id)
                                @if($row->jo_status == 'Paid')
                                    <a href="{{ route('Service-Request.show', $row->id) }}"
                                        class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                        <i class="fi fi-rr-eye"></i>
                                    </a>
                                @else
                                    <a href="{{ route('Service-Request.show', $row->id) }}"
                                        class="cust-btn cust-btn-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Review">
                                        <i class="bi bi-list-ul"></i>
                                    </a>
                                @endif                                  
                            @endif                      
                           
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
</div>

@endsection
