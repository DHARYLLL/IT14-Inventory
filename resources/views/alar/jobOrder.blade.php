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
        <button class="btn" id="clearSearch"
            style="background-color: #b3e6cc; color: black; border: none;">Clear</button>
    </div>
    <a href="{{ route('Service-Request.create') }}" class="cust-btn cust-btn-primary"><i
            class="bi bi-plus-lg"></i> <span>Service</span></a>
    <a href="{{ route('Job-Order.create') }}" class="cust-btn cust-btn-primary"><i
            class="bi bi-plus-lg"></i> <span>Package</span></a>
</div>

{{-- table --}}
<div class="cust-h-content">
    <table class="table table-hover mb-0">
        <thead>
            <tr class="table-light">
                <th class="fw-semibold">ID</th>
                <th class="fw-semibold">Client</th>
                <th class="fw-semibold">Contact #</th>
                <th class="fw-semibold">Status</th>
                <th class="fw-semibold">Start Date</th>
                <th class="fw-semibold">Employee</th>
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
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->client_name ?? '—' }}</td>
                        <td>{{ $row->client_contact_number ?? '—' }}</td>
                        <td>{{ $row->jo_status }}</td>
                        <td>{{ $row->jo_start_date }}</td>
                        <td>{{ $row->joToEmp->emp_fname }} {{ $row->joToEmp->emp_lname }}</td>
                        <td class="text-center align-middle">
                            <div class="d-flex justify-content-center align-items-center gap-2">

                                @if($row->jod_id)
                                    @if($row->joToJod->jod_eq_stat == 'Pending')
                                        <a href="{{ route('Job-Order.showDeploy', $row->id) }}"
                                            class="btn btn-outline-success btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Deploy">
                                            <i class="bi bi-box-arrow-up"></i>
                                        </a>
                                    @endif 
                                    @if($row->joToJod->jod_eq_stat == 'Deployed')
                                        <a href="{{ route('Job-Order.showReturn', $row->id) }}"
                                            class="btn btn-outline-success btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Return">
                                            <i class="bi bi-box-arrow-in-down"></i>
                                        </a>
                                    @endif 
                                @endif
                                @if($row->svc_id)
                                    <a href="{{ route('Service-Request.show', $row->id) }}"
                                        class="btn btn-outline-success btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Review">
                                        <i class="bi bi-list-ul"></i>
                                    </a>
                                @endif


                                
                            </div>
                        </td>
                    </tr>
                @endforeach
    
            @endif
    
    
    
        </tbody>
    </table>
</div>

@endsection
