@extends('layouts.layout')
@section('title', 'Job Order')

@section('content')
@section('head', 'Edit Job Order')

    <div class="d-flex align-items-center justify-content-end cust-h-heading gap-2">

        <a href="{{ route('Job-Order.index') }}" class="cust-btn cust-btn-secondary"><span>Back</span></a>
        
    </div>

    {{-- table --}}
    <div class="cust-h">
        <div class="row h-100">
            
            <div class="col col-12 h-100 overflow-auto">
                <div class="card-custom p-3">

                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Package and Services</h5>
                        </div>
                        <div class="col-md-12">
                            <h4>Package: {{ $jodData->jodToPkg->pkg_name }}</h4>
                        </div>
                        <div class="col-md-12">
                            <h4>Chapel: {{ $jodData->chap_id ? $jodData->jodToChap->chap_name : 'N/A' }}</h4>
                        </div>
                    </div>


                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Client Info:</h5>
                        </div>

                        <div class="col-md-6">
                            <h4>Client: {{ $joData->client_name }}</h4>
                        </div>
                        <div class="col-md-6">
                            <h4>Contact Number: {{ $joData->client_contact_number }}</h4>
                        </div>

                    </div>


                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Payments:</h5>
                        </div>

                        <div class="col-md-6">
                            <h4>Initial Payment: ₱{{ $joData->jo_dp }}</h4>
                        </div>
                        <div class="col-md-6">
                            <h4>Total Payment: ₱{{ $joData->jo_total }}</h4>
                        </div>

                        <div class="col-md-6">
                            <a href="" class="cust-btn cust-btn-primary">Fully Paid</a>
                        </div>
                        <div class="col-md-6">
                            <a href="" class="cust-btn cust-btn-secondary">Burial Assistance (MOA)</a>
                        </div>
                    </div>


                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Job Order Details:</h5>
                        </div>

                        <div class="col-md-6">
                            <h4>Status: {{ $joData->jo_status }}</h4>
                        </div>
                        <div class="col-md-6">
                            <h4>Start Date: {{ $joData->jo_start_date }}</h4>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Deceased Info:</h5>
                        </div>

                        <div class="col-md-6">
                            <h4>Deceased Name: {{ $jodData->dec_name }}</h4>
                        </div>

                        <div class="col-md-3">
                            <h4>Birth Date: {{ $jodData->dec_born_date }}</h4>
                        </div>
                        <div class="col-md-3">
                            <h4>Died Date: {{ $jodData->dec_died_date }}</h4>
                        </div>

                        <div class="col-md-6">
                            <h4>Casue of Death: {{ $jodData->dec_cause_of_death }}</h4>
                        </div>

                    </div>


                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Location:</h5>
                        </div>

                        <div class="col-md-6">
                            <h4>Wake Location: {{ $jodData->jod_wakeLoc }}</h4>
                        </div>
                        <div class="col-md-6">
                            <h4>Burial Location: {{ $jodData->jod_burialLoc }}</h4>
                        </div>

                    </div>

                    
                    

                </div>
            </div>
            
        </div>
    </div>
@endsection