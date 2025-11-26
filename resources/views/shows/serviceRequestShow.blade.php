@extends('layouts.layout')
@section('title', 'Service Request')

@section('content')
@section('head', 'Show Services Request')
<link rel="stylesheet" href="{{ asset('CSS/POshow.css') }}">

    <div class="d-flex align-items-center justify-content-end cust-h-heading">

        <a href="{{ route('Job-Order.index') }}" class="cust-btn cust-btn-secondary"><span>Back</span></a>
        
    </div>

    {{-- table --}}
    <div class="cust-h">
        <div class="row h-100">
            
            <div class="col col-12 h-100 overflow-auto">
                <div class="card-custom p-3">

                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Client Info:</h5>
                        </div>
                        <div class="col-md-4">
                            <h4>Name: {{ $joData->client_name }}</h4>
                        </div>
                        <div class="col-md-4">
                            <h4>Vehicle: {{ $joData->client_contact_number }}</h4>
                        </div>
                        
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Services:</h5>
                        </div>
                        <div class="col-md-4">
                            <h4>Name: {{ $joData->joToSvcReq->svc_name }}</h4>
                        </div>
                        <div class="col-md-4">
                            <h4>Vehicle: {{ $joData->joToSvcReq->veh_id ? $joData->joToSvcReq->svcReqToVeh->driver_name : 'N/A' }}</h4>
                        </div>
                        <div class="col-md-4">
                            <h4>Embalmer: {{ $joData->joToSvcReq->prep_id ? $joData->joToSvcReq->svcReqToEmbalm->embalmer_name : 'N/A' }}</h4>
                        </div>
                        
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4">
                            <h4>Vehicle: {{ $joData->jo_start_date }}</h4>
                        </div>
                        <div class="col-md-4">
                            <h4>Start Time: {{ \Carbon\Carbon::parse($joData->jo_start_time)->format('g:i A') }}</h4>
                        </div>
                        <div class="col-md-4">
                            <h4>End Time: {{ \Carbon\Carbon::parse($joData->jo_end_time)->format('g:i A') }}</h4>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Payment:</h5>
                        </div>

                        <div class="col-md-4">
                            <h4>Total: ₱{{ $joData->jo_total }}</h4>
                        </div>
                        <div class="col-md-4">
                            <h4>Down Payment: ₱{{ $joData->jo_dp }}</h4>
                        </div>
                        <div class="col-md-4">
                            <h4>Status: {{ $joData->jo_status }}</h4>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4">
                            <h4>Balance: ₱{{ $joData->jo_total - $joData->jo_dp }}</h4>
                        </div>
                        <div class="col-md-4">
                            <button class="cust-btn cust-btn-primary">Paid</button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection