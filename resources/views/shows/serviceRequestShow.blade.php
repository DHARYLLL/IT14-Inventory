@extends('layouts.layout')
@section('title', 'Equipments')

@section('content')
@section('head', 'Show Services Request')
@section('name', 'Staff')
<link rel="stylesheet" href="{{ asset('CSS/POshow.css') }}">

    <div class="d-flex align-items-center justify-content-end cust-h-heading gap-2">

        <a href="{{ route('Service-Request.index') }}" class="cust-btn cust-btn-secondary"><span>Back</span></a>

        @if($svcReqData->svc_equipment_status == "Pending")
            <div class="row">
                <div class="col col-12">
                    <form action="{{ route('Service-Request.update', $svcReqData->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <input type="text" name="status" value="{{ $svcReqData->svc_equipment_status }}" hidden>
                        <input type="text" value="{{ $svcReqData->id }}" hidden>
                        <button type="" class="cust-btn cust-btn-primary">Deploy Equipment</button>
                        @session('promt')
                            <small class="text-danger">{{ $value }}</small>
                        @endsession
                        
                    </form>
                </div>
            </div>
        @elseif($svcReqData->svc_equipment_status == "Deployed")
            <div class="row">
                <div class="col col-12">
                    <form action="{{ route('Service-Request.update', $svcReqData->id ) }}" method="post">
                        @csrf
                        @method('put')
                        <input type="text" name="status" value="{{ $svcReqData->svc_equipment_status }}" hidden>
                        <input type="text" value="{{ $svcReqData->id }}" hidden>
                        <button class="cust-btn cust-btn-primary">Retun Equipment</button>
                    </form>
                </div>
            </div>
        @endif
        
    </div>

    {{-- table --}}
    <div class="cust-h">
        <div class="row h-100">
            
            <div class="col col-4 h-100 overflow-auto">
                <div class="card-custom p-3">

                    <div class="row mb-2">
                        <div class="col-md-12">
                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex align-items-center">
                                    <label class="col-4 form-label">Package</label>
                                    <span class="mx-2">:</span>
                                    <input type="text" class="form-control col" value="{{ $svcReqData->svcReqToPac->pkg_name }}" readonly>
                                </div>

                                <div class="d-flex align-items-center">
                                    <label class="col-4 form-label">Client Name</label>
                                    <span class="mx-2">:</span>
                                    <input type="text" class="form-control col" value="{{ $svcReqData->svcReqToRcpt->client_name }}" readonly>
                                </div>

                                <div class="d-flex align-items-center">
                                    <label class="col-4 form-label">Contact Number</label>
                                    <span class="mx-2">:</span>
                                    <input type="text" class="form-control col" value="{{ $svcReqData->svcReqToRcpt->client_contact_number }}" readonly>
                                </div>

                                <div class="d-flex align-items-center">
                                    <label class="col-4 form-label">Start date</label>
                                    <span class="mx-2">:</span>
                                    <input type="text" class="form-control col" value="{{ $svcReqData->svc_startDate }}" readonly>
                                </div>

                                <div class="d-flex align-items-center">
                                    <label class="col-4 form-label">End date</label>
                                    <span class="mx-2">:</span>
                                    <input type="text" class="form-control col" value="{{ $svcReqData->svc_endDate }}" readonly>
                                </div>

                                <div class="d-flex align-items-center">
                                    <label class="col-4 form-label">Wake</label>
                                    <span class="mx-2">:</span>
                                    <input type="text" class="form-control col" value="{{ $svcReqData->svc_wakeLoc }}" readonly>
                                </div>

                                <div class="d-flex align-items-center">
                                    <label class="col-4 form-label">Church</label>
                                    <span class="mx-2">:</span>
                                    <input type="text" class="form-control col" value="{{ $svcReqData->svc_churchLoc }}" readonly>
                                </div>

                                <div class="d-flex align-items-center">
                                    <label class="col-4 form-label">Burial</label>
                                    <span class="mx-2">:</span>
                                    <input type="text" class="form-control col" value="{{ $svcReqData->svc_burialLoc }}" readonly>
                                </div>

                                <div class="d-flex align-items-center">
                                    <label class="col-4 form-label">Equipment status</label>
                                    <span class="mx-2">:</span>
                                    <input type="text" class="form-control col" value="{{ $svcReqData->svc_equipment_status }}" readonly>
                                </div>

                                <div class="d-flex align-items-center">
                                    <label class="col-4 form-label">Deployed Date</label>
                                    <span class="mx-2">:</span>
                                    <input type="text" class="form-control col" value="{{ $svcReqData->svc_deploy_date }}" readonly>
                                </div>

                                <div class="d-flex align-items-center">
                                    <label class="col-4 form-label">Return Date</label>
                                    <span class="mx-2">:</span>
                                    <input type="text" class="form-control col" value="{{ $svcReqData->svc_return_date }}" readonly>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
            {{-- Stock and Equipment tables --}}
            <div class="col col-8 h-100 overflow-auto" >
                <div class="row" style="height: 45%;">
                    <div class="col">
                        <table class="table modern-table table-hover" style="height: 10%;">
                            <thead>
                                <tr class="table-light">
                                    <th class="fw-semibold">Item name</th>
                                    <th class="fw-semibold">Size</th>
                                    <th class="fw-semibold">Unit</th>
                                    <th class="fw-semibold">Qty</th>
                                </tr>
                            </thead>
                        </table>

                        <div class="overflow-auto" style="height: 80%;">
                            <table class="table modern-table border-black table-hover mb-0">
                                <tbody>
                                    @if ($pkgStoData->isEmpty())
                                        <tr>
                                            <td colspan="3" class="text-center text-secondary py-3">
                                                No Equipment available.
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($pkgStoData as $row)
                                            <tr>
                                                <td>{{ $row->pkgStoToSto->item_name }}</td>
                                                <td>{{ $row->pkgStoToSto->size_weight }}</td>
                                                <td>{{ $row->stock_used }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>

                <div class="row" style="height: 45%;">
                    <div class="col">
                        <table class="table modern-table table-hover px-3" style="height: 10%;">
                            <thead>
                                <tr class="table-light">
                                    <th class="fw-semibold">Equipment</th>
                                    <th class="col col-md-3 fw-semibold">Borrowed Qty</th>
                                </tr>
                            </thead>
                        </table>
                        <div class="overflow-auto" style="height: 80%;">
                            <table class="table modern-table border-black table-hover mb-0">
                                <tbody>
                                    @if ($pkgEqData->isEmpty())
                                        <tr>
                                            <td colspan="2" class="text-center text-secondary py-3">
                                                No Equipment available.
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($pkgEqData as $row)
                                            <tr>
                                                <td>{{ $row->pkgEqToEq->eq_name }}</td>
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
    </div>
@endsection