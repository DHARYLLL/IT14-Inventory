@extends('layouts.layout')
@section('title', 'Receipt')

@section('content')
@section('head', 'Receipt View')
@section('name', 'Staff')

    <div class="cust-h-content-func">
        <div class="card shadow-sm border-0 rounded-4 p-4 bg-white h-100">
            <div class="card-body h-100">
                

                <div class="row mb-3">
                    <div class="col-md-3">
                        <p class="fw-semibold text-dark mb-1">Client Name</p>
                        <input type="text" class="form-control" name="clientName" value="{{ $rcptData->client_name }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <p class="fw-semibold text-dark mb-1">Contact Number</p>
                        <input type="text" class="form-control" name="clientConNum" value="{{ $rcptData->client_contact_number }}" readonly>
                    </div>
                    <div class="col-md-2">
                        <p class="fw-semibold text-dark mb-1">Status</p>
                        <input type="text" class="form-control" name="status" value="{{ $rcptData->rcpt_status }}" readonly>
                        
                    </div>
                </div>
                

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

                <div class="row">
                    <div class="col-md-2">
                        <p class="fw-semibold text-dark mb-1">Total</p>
                        <input type="text" class="form-control" name="total" value="{{ $rcptData->total_payment }}" readonly>
                    </div>
                    <div class="col-md-2">
                        <p class="fw-semibold text-dark mb-1">Paid</p>
                        <input type="text" class="form-control" name="paid" value="{{ $rcptData->paid_amount }}" readonly>
                    </div>
                </div>

                <div class="row h-10 justify-content-end align-items-center">
                    <div class="col col-auto">
                        <a href="{{ route('Receipt.index') }}" class="cust-btn cust-btn-secondary">
                            <i class="bi bi-arrow-left"></i>
                            <span>Back</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
