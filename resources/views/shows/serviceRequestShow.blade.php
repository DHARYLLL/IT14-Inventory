@extends('layouts.layout')
@section('title', 'Equipments')

@section('content')
@section('head', 'Show Services Request')
@section('name', 'Staff')

<div class="d-flex align-items-center justify-content-end m-1">
    <a href="{{ route('Service-Request.index') }}" class="btn btn-custom d-flex align-items-center gap-2">
        <i class="bi bi-arrow-left"></i><span>Back</span>
    </a>
</div>

<div class="bg-white rounded border overflow-hidden p-3">

    <div class="row">
        {{-- LEFT COLUMN — Package Info Table --}}
        <div class="col col-5">
            <div class="table-container mb-3">
                <table class="table custom-info-table align-middle mb-0">
                    <tbody>
                        <tr>
                            <th>Package</th>
                            <td>{{ $svcReqData->svcReqToPac->pkg_name }}</td>
                        </tr>
                        <tr>
                            <th>Client Name</th>
                            <td>{{ $svcReqData->client_name }}</td>
                        </tr>
                        <tr>
                            <th>Contact Number</th>
                            <td>{{ $svcReqData->client_contact_number }}</td>
                        </tr>
                        <tr>
                            <th>Start Date</th>
                            <td>{{ $svcReqData->svc_startDate }}</td>
                        </tr>
                        <tr>
                            <th>End Date</th>
                            <td>{{ $svcReqData->svc_endDate }}</td>
                        </tr>
                        <tr>
                            <th>Wake</th>
                            <td>{{ $svcReqData->svc_wakeLoc }}</td>
                        </tr>
                        <tr>
                            <th>Church</th>
                            <td>{{ $svcReqData->svc_churchLoc }}</td>
                        </tr>
                        <tr>
                            <th>Burial</th>
                            <td>{{ $svcReqData->svc_burialLoc }}</td>
                        </tr>
                        <tr>
                            <th>Equipment Status</th>
                            <td>{{ $svcReqData->svc_equipment_status }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Action Buttons --}}
            @if ($svcReqData->svc_equipment_status == 'Pending')
                <form action="{{ route('Service-Request.update', $svcReqData->id) }}" method="POST">
                    @csrf
                    @method('put')
                    <input type="hidden" name="status" value="{{ $svcReqData->svc_equipment_status }}">
                    <input type="hidden" value="{{ $svcReqData->id }}">
                    <button type="submit" class="btn btn-green w-100">Deploy Equipment</button>
                </form>
            @elseif($svcReqData->svc_equipment_status == 'Deployed')
                <form action="{{ route('Service-Request.update', $svcReqData->id) }}" method="post">
                    @csrf
                    @method('put')
                    <input type="hidden" name="status" value="{{ $svcReqData->svc_equipment_status }}">
                    <input type="hidden" value="{{ $svcReqData->id }}">
                    <button class="btn btn-secondary w-100">Return Equipment</button>
                </form>
            @endif
        </div>

        {{-- RIGHT COLUMN --}}
        <div class="col col-7">

            {{-- STOCKS TABLE --}}
            <div class="mb-3">
                <h6 class="fw-semibold mb-2 text-success">Stocks Used</h6>
                <div class="table-container">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="table-light border-success border-bottom">
                                <th class="fw-semibold">Item Name</th>
                                <th class="fw-semibold">Size/Weight</th>
                                <th class="fw-semibold">Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($svcStoData->isEmpty())
                                <tr>
                                    <td colspan="3" class="text-center text-secondary py-3">No Equipment available.
                                    </td>
                                </tr>
                            @else
                                @foreach ($svcStoData as $row)
                                    <tr>
                                        <td>{{ $row->svcStoToSto->item_name }}</td>
                                        <td>{{ $row->svcStoToSto->size_weight }}</td>
                                        <td>{{ $row->stock_used }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- EQUIPMENT TABLE --}}
            <div>
                <h6 class="fw-semibold mb-2 text-success">Equipments Borrowed</h6>
                <div class="table-container">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="table-light border-success border-bottom">
                                <th class="fw-semibold">Equipment</th>
                                <th class="fw-semibold">Borrowed Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($svcEqData->isEmpty())
                                <tr>
                                    <td colspan="3" class="text-center text-secondary py-3">No Equipment available.
                                    </td>
                                </tr>
                            @else
                                @foreach ($svcEqData as $row)
                                    <tr>
                                        <td>{{ $row->svcEqToEq->eq_name }}</td>
                                        <td>{{ $row->eq_used }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
