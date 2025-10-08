@extends('layouts.layout')
@section('title', 'Equipments')

@section('content')
    @section('head', 'Services Request')
    @section('name', 'Staff')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="fw-semibold">Services Request</h2>
        <a href="{{ route('Service-Request.create') }}" class="btn btn-custom d-flex align-items-center gap-2"><i class="bi bi-plus-lg"></i><span>Create Services</span></a>
    </div>

    {{-- table --}}
    <div class="bg-white rounded border overflow-hidden">
        <table class="table table-hover mb-0">
            <thead>
                <tr class="table-light">
                    <th class="fw-semibold">Package</th>
                    <th class="fw-semibold">Start Date</th>
                    <th class="fw-semibold">End Date</th>
                    <th class="fw-semibold">Wake Loc.</th>
                    <th class="fw-semibold">Church Loc.</th>
                    <th class="fw-semibold">Burial Loc.</th>
                    <th class="fw-semibold">Status</th>
                    <th class="fw-semibold">Action</th>
                </tr>
            </thead>

            <tbody>

                @if ($svcReqData->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center text-secondary py-3">
                            No New Service Request.
                        </td>
                    </tr>    
                @else
                    @foreach($svcReqData as $row)
                        <tr>
                            <td>{{ $row->svcReqToPac->pkg_name }}</td>
                            <td>{{ $row->svc_startDate }}</td>
                            <td>{{ $row->svc_endDate }}</td>
                            <td>{{ $row->svc_wakeLoc }}</td>
                            <td>{{ $row->svc_churchLoc }}</td>
                            <td>{{ $row->svc_burialLoc }}</td>
                            <td>{{ $row->svc_status }}</td>
                            <td>
                                <a href="{{ route('Service-Request.show', $row->id) }}">View</a>
                            </td>
                        </tr>
                    @endforeach
                @endif

                

            </tbody>
        </table>
    </div>
@endsection