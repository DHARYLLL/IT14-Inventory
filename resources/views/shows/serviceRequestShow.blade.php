@extends('layouts.layout')
@section('title', 'Equipments')

@section('content')
@section('head', 'Show Services Request')
@section('name', 'Staff')
<link rel="stylesheet" href="{{ asset('CSS/POshow.css') }}">

    <div class="d-flex align-items-center justify-content-end cust-h-heading">
        <a href="{{ route('Service-Request.index') }}" class="btn btn-custom d-flex align-items-center gap-2"><span>Back</span></a>
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
                                    <input type="text" class="form-control col" value="{{ $svcReqData->client_name }}" readonly>
                                </div>

                                <div class="d-flex align-items-center">
                                    <label class="col-4 form-label">Contact Number</label>
                                    <span class="mx-2">:</span>
                                    <input type="text" class="form-control col" value="{{ $svcReqData->client_contact_number }}" readonly>
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

                    @if($svcReqData->svc_equipment_status == "Pending")
                        <div class="row">
                            <div class="col col-12">
                                <form action="{{ route('Service-Request.update', $svcReqData->id) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <input type="text" name="status" value="{{ $svcReqData->svc_equipment_status }}" hidden>
                                    <input type="text" value="{{ $svcReqData->id }}" hidden>
                                    <button type="" class="btn btn-secondary w-100">Deploy Equipment</button>
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
                                    <button class="btn btn-secondary w-100">Retun Equipment</button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="col col-8 h-100 overflow-auto" >
                <div class="row" style="height: 45%;">
                    <div class="col">
                        <table class="table modern-table table-hover" style="height: 10%;">
                            <thead>
                                <tr class="table-light">
                                    <th class="fw-semibold">Item name</th>
                                    <th class="fw-semibold">Size/Weight</th>
                                    <th class="fw-semibold">Qty</th>
                                </tr>
                            </thead>
                        </table>

                        <div class="overflow-auto" style="height: 80%;">
                            <table class="table modern-table border-black table-hover mb-0">
                                <tbody>
                                    @if ($svcStoData->isEmpty())
                                        <tr>
                                            <td colspan="3" class="text-center text-secondary py-3">
                                                No Equipment available.
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($svcStoData as $row)
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
                                    @if ($svcEqData->isEmpty())
                                        <tr>
                                            <td colspan="2" class="text-center text-secondary py-3">
                                                No Equipment available.
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($svcEqData as $row)
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
    </div>
@endsection