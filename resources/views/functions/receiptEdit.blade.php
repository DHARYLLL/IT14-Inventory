@extends('layouts.layout')
@section('title', 'Receipt')

@section('content')
@section('head', 'Receipt Edit')
@section('name', 'Staff')

    <div class="cust-h-content-func">
        <div class="card shadow-sm border-0 rounded-4 p-4 bg-white h-100">
            <div class="card-body h-100">
                <form action="{{ route('Receipt.update', $rcptData->id) }}" method="POST" class="h-20">
                    @csrf
                    @method('put')
                    {{-- Check --}}
                    <input type="text" name="check" value="edit" hidden>

                    <div class="row mb-3 h-100">
                        <div class="col-md-3">
                            <p class="fw-semibold text-dark mb-1">Client Name</p>
                            <input type="text" class="form-control" name="clientName" value="{{ $rcptData->client_name }}">
                            @error('clientName')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <p class="fw-semibold text-dark mb-1">Contact Number</p>
                            <input type="text" class="form-control" name="clientConNum" value="{{ $rcptData->client_contact_number }}">
                            @error('clientConNum')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <p class="fw-semibold text-dark mb-1">Status</p>
                            <input type="text" class="form-control" name="status" value="{{ $rcptData->rcpt_status }}" readonly>
                            
                        </div>
                        <div class="col-md-2">
                            <p class="fw-semibold text-dark mb-1">Save Changes</p>
                            <button type="submit" class="cust-btn cust-btn-secondary"><i class="bi bi-floppy px-2"></i>Update</button>
                            @session('promt')
                                <small class="text-success">{{ $value }}</small>
                            @endsession
                        </div>
                    </div>
                </form>

                <div class="row h-60">

                    <div class="col-md-12 h-100 overflow-auto">

                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <p class="cust-sub-title">Package Info:</p>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('Service-Request.show', $rcptData->svc_id) }}" class="cust-btn cust-btn-secondary">Show Package</a>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-12">
                                <p>Package : {{ $rcptData->rcptToSvcReq->svcReqToPac->pkg_name }}</p>
                            </div>
                            <div class="col-md-12">
                                <p>Start Date : {{ $rcptData->rcptToSvcReq->svc_startDate }} </p>
                            </div>
                            <div class="col-md-12">
                                <p>End Date : {{ $rcptData->rcptToSvcReq->svc_endDate }} </p>
                            </div>
                            <div class="col-md-12">
                                <p>Chapel : {{ $rcptData->rcptToSvcReq->chap_id ? $rcptData->rcptToSvcReq->svcReqToChap->chap_name : 'N/A' }} </p>
                            </div>
                            <div class="col-md-12">
                                <p>Chapel Room : {{ $rcptData->rcptToSvcReq->chap_id ? $rcptData->rcptToSvcReq->svcReqToChap->chap_name : 'N/A' }} </p>
                            </div>
                            <div class="col-md-12">
                                <p>Wake Location : {{ $rcptData->rcptToSvcReq->svc_wakeLoc }} </p>
                            </div>
                            <div class="col-md-12">
                                <p>Church Location : {{ $rcptData->rcptToSvcReq->svc_churchLoc }} </p>
                            </div>
                            <div class="col-md-12">
                                <p>Burial Location : {{ $rcptData->rcptToSvcReq->svc_burialLoc }} </p>
                            </div>
                            
                        </div>

                    </div>

                </div>

                <form action="{{ route('Receipt.update', $rcptData->id) }}" method="POST" class="h-20">
                    @csrf
                    @method('put')

                    {{-- Check --}}
                    <input type="text" name="check" value="payment" hidden>

                    <div class="row">
                        <div class="col-md-2">
                            <p class="fw-semibold text-dark mb-1">Total</p>
                            <input type="text" class="form-control" name="total" value="{{ $rcptData->total_payment }}" readonly>
                        </div>
                        <div class="col-md-2">
                            <p class="fw-semibold text-dark mb-1">Paid</p>
                            <input type="text" class="form-control" name="paid" value="{{ $rcptData->paid_amount }}">
                            @error('paid')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row h-10 justify-content-end align-items-center">
                        {{-- Display Error --}}
                        <div class="col col-auto">
                            @session('promt')
                                <div class="text-danger small mt-1">{{ $value }}</div>
                            @endsession
                        </div>
                        <div class="col col-auto">
                            <a href="{{ route('Receipt.index') }}" class="cust-btn cust-btn-secondary">
                                <i class="bi bi-arrow-left"></i>
                                <span>Cancel</span>
                            </a>
                        </div>
                        {{-- Submit Button --}}
                        <div class="col col-auto ">
                    
                            <button type="submit" class="cust-btn cust-btn-primary"><i class="bi bi-send px-2"></i>Pay Payment</button>
                    
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection
