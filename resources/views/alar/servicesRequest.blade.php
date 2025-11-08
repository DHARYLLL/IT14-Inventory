@extends('layouts.layout')
@section('title', 'Service Request')

@section('content')
@section('head', 'Service Requests')
@section('name', 'Staff')

<div class="d-flex align-items-center justify-content-between p-2 mb-0 cust-h-heading">
    @session('promt')
        <h2 class="fw-semibold bg-danger-subtle">{{ $value }}</h2>
    @endsession
    <div class="input-group" style="max-width: 600px; border-radius: 10px; overflow: hidden;">
        <input type="text" id="searchInput" class="form-control" placeholder="Search Service Request"
            style="border-radius: 0; border: none;">
        <button class="btn" id="clearSearch"
            style="background-color: #b3e6cc; color: black; border: none;">Clear</button>
    </div>

    <a href="{{ route('Service-Request.create') }}" class="btn btn-custom d-flex align-items-center gap-2"><i
            class="bi bi-plus-lg"></i><span>Create Services</span></a>
</div>

{{-- table --}}
<div class="cust-h-content">
    <table class="table table-hover mb-0">
        <thead>
            <tr class="table-light">
                <th class="fw-semibold">Package</th>
                <th class="fw-semibold">Client</th>
                <th class="fw-semibold">Contact #</th>
                <th class="fw-semibold">Start Date</th>
                <th class="fw-semibold">End Date</th>
                <th class="fw-semibold">Wake Loc.</th>
    
                <th class="fw-semibold">Burial Loc.</th>
                <th class="fw-semibold">Equipment</th>
                <th class="fw-semibold">Action</th>
            </tr>
        </thead>
    
        <tbody id="tableBody">
    
            @if ($svcReqData->isEmpty())
                <tr>
                    <td colspan="9" class="text-center text-secondary py-3">
                        No New Service Request.
                    </td>
                </tr>
            @else
                @foreach ($svcReqData as $row)
                    <tr>
                        {{-- Safely display the package name (avoid null errors) --}}
                        <td>{{ $row->svcReqToPac->pkg_name ?? '—' }}</td>
                        <td>{{ $row->svcReqToRcpt->client_name ?? '—' }}</td>
                        <td>{{ $row->svcReqToRcpt->client_contact_number ?? '—' }}</td>
                        <td>{{ $row->svc_startDate }}</td>
                        <td>{{ $row->svc_endDate }}</td>
                        <td>{{ $row->svc_wakeLoc }}</td>
    
                        <td>{{ $row->svc_burialLoc }}</td>
                        <td>{{ $row->svc_equipment_status }}</td>
                        <td class="text-center align-middle">
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <a href="{{ route('Service-Request.show', $row->id) }}"
                                    class="btn btn-outline-success btn-md" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="View">
                                    <i class="fi fi-rr-eye"></i>
                                </a>
    
                                @if ($row->svc_equipment_status == 'Pending')
                                    <form action="{{ route('Service-Request.destroy', $row->id) }}" method="POST"
                                        class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-md"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
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
