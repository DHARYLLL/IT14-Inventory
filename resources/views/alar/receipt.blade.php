@extends('layouts.layout')
@section('title', 'Receipt')

@section('content')
@section('head', 'Receipt')
@section('name', 'Staff')

<div class="d-flex align-items-center justify-content-between p-2 mb-0 cust-h-heading">
    @session('promt')
        <h2 class="fw-semibold bg-danger-subtle">{{ $value }}</h2>
    @endsession
    <div class="input-group" style="max-width: 600px; border-radius: 10px; overflow: hidden;">
        <input type="text" id="searchInput" class="form-control" placeholder="Search"
            style="border-radius: 0; border: none;">
        <button class="btn" id="clearSearch"
            style="background-color: #b3e6cc; color: black; border: none;">Clear</button>
    </div>
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
                <th class="fw-semibold">Total</th>
                <th class="fw-semibold">Paid</th>
                <th class="fw-semibold">Employee</th>
                <th class="fw-semibold">Action</th>
            </tr>
        </thead>
    
        <tbody id="tableBody">
    
            @if ($rcptData->isEmpty())
                <tr>
                    <td colspan="9" class="text-center text-secondary py-3">
                        No New Service Request.
                    </td>
                </tr>
            @else
                @foreach ($rcptData as $row)
                    <tr>
                        {{-- Safely display the package name (avoid null errors) --}}
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->client_name ?? '—' }}</td>
                        <td>{{ $row->client_contact_number ?? '—' }}</td>
                        <td>{{ $row->rcpt_status }}</td>
                        <td>{{ $row->total_payment }}</td>
                        <td>{{ $row->paid_amount }}</td>
                        <td>{{ $row->rcptToEmp->emp_fname }} {{ $row->rcptToEmp->emp_lname }}</td>
                        <td class="text-center align-middle">
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <a href="{{ route('Receipt.show', $row->id) }}"
                                    class="btn btn-outline-success btn-md" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="View">
                                    <i class="fi fi-rr-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
    
            @endif
    
    
    
        </tbody>
    </table>
</div>

@endsection
