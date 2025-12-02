@extends('layouts.layout')
@section('title', 'Service Request')

@section('content')
@section('head', 'Show Services Request')

    {{-- table --}}
    <div class="cust-h">
        <div class="row cust-h-form p-3">
            
            <div class="col col-12 h-100 overflow-auto">


                <div class="row cust-white-bg">
                    <div class="col-md-12 mb-2">
                        <h5 class="cust-sub-title">Client Info:</h5>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Client name</label>
                        <p>{{ $joData->client_name }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Contact number</label>
                        <p>Contact Number: {{ $joData->client_contact_number }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Address</label>
                        <p>address</p>
                    </div>
                    
                </div>

                <div class="row cust-white-bg mt-4">
                    <div class="col-md-12 mb-2">
                        <h5 class="cust-sub-title">Services:</h5>
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Embalmer</label>
                        <p>{{ $joData->joToSvcReq->prep_id ? $joData->joToSvcReq->svcReqToEmbalm->embalmer_name : 'N/A' }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Driver</label>
                        <p>{{ $joData->joToSvcReq->veh_id ? $joData->joToSvcReq->svcReqToVeh->driver_name : 'N/A' }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Vehicle</label>
                        <p>{{ $joData->joToSvcReq->veh_id ? $joData->joToSvcReq->svcReqToVeh->veh_brand : 'N/A' }} |
                            {{ $joData->joToSvcReq->veh_id ? $joData->joToSvcReq->svcReqToVeh->veh_plate_no : 'N/A' }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Contact number</label>
                        <p>{{ $joData->joToSvcReq->veh_id ? $joData->joToSvcReq->svcReqToVeh->driver_contact_number : 'N/A' }}</p>
                    </div>
                    
                    <div class="w-100 mb-2"></div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Start date</label>
                        <p>{{ $joData->jo_start_date }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Start time</label>
                        <p>{{ \Carbon\Carbon::parse($joData->jo_start_time)->format('g:i A') }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">End time</label>
                        <p>{{ \Carbon\Carbon::parse($joData->jo_end_time)->format('g:i A') }}</p>
                    </div>
                    
                    
                </div>

                <div class="row mt-4 cust-white-bg">
                    <div class="col-md-12 mb-2">
                        <h5 class="cust-sub-title">Payment:</h5>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Status</label>
                        <p>{{ $joData->jo_status }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Total</label>
                        <p>₱{{ $joData->jo_total }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Down payment</label>
                        <p>₱{{ $joData->jo_dp }}</p>
                    </div>

                    @if($joData->jo_status != 'Paid')
                        <div class="col-md-12 mt-2">
                            <form action="{{ route('Service-Request.payBalance', $joData->svc_id )}}" method="post">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">Balance</label>
                                        <input type="text" class="form-input" name="payment" value="{{ old('payment', $joData->jo_total - $joData->jo_dp) }}">
                                        @error('payment')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">Pay remaining balance</label>
                                        <button class="cust-btn cust-btn-primary w-100">Pay balance</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Balance</label>
                            <p>₱{{ $joData->jo_total - $joData->jo_dp }}</p>
                        </div>
                    @endif


                    

                    
                </div>

                
            </div>

        </div>

        {{-- Submit --}}
        <div class="row justify-content-end">
            <div class="col col-auto">
                @session('promt-s')
                    <div class="text-success small mt-1">{{ $value }}</div>
                @endsession
            </div>
            <div class="col col-auto">
                <a href="{{ route('Job-Order.index') }}" class="cust-btn cust-btn-secondary"><i
                    class="bi bi-arrow-left"></i>
                    <span>Back</span>
                </a>
            </div>
        </div>
    </div>
@endsection