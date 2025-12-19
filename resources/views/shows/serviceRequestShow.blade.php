@extends('layouts.layout')
@section('title', 'Service Request')

@section('content')
@section('head', 'Show Services Request')

    {{-- table --}}
    <div class="cust-h-100">
        <div class="row h-100 p-3">
            
            <div class="col col-12 h-100 overflow-auto">

                {{-- Display error --}}
                @session('promt-f')
                    <div class="row mb-4 cust-error-msg">
                        <div class="col-md-12">
                            <div class="text-danger"><p>{{ $value }}</p></div>
                        </div>
                    </div>
                @endsession


                <div class="row cust-white-bg">
                    <div class="col-md-12 mb-2">
                        <h5 class="cust-sub-title">Client Info:</h5>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Client name</label>
                        <p>{{ $joData->client_name }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Contact number</label>
                        <p>{{ $joData->client_contact_number }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Address</label>
                        <p>{{ $joData->client_address }}</p>
                    </div>
                    <div class="col-md-3">
                        <label for="" class="form-label fw-semibold text-secondary">Payment History</label>
                        <!-- Payment history modal -->
                        <button type="button" class="cust-btn cust-btn-secondary" data-bs-toggle="modal" data-bs-target="#paymentHistory">
                            <i class="bi bi-wallet"></i> View payment history
                        </button>
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
                        <label class="form-label fw-semibold">Contact number</label>
                        <p>{{ $joData->joToSvcReq->veh_id ? $joData->joToSvcReq->svcReqToVeh->driver_contact_number : 'N/A' }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Status</label>
                        <p>{{ $joData->joToSvcReq->svc_status }}</p>
                    </div>
                    
                    <div class="w-100 mb-2"></div>

                    <div class="col-md-12 mb-2">
                        <h5 class="cust-sub-title">Schedule:</h5>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Service date</label>
                        <p>{{ $joData->jo_start_date ? \Carbon\Carbon::parse($joData->jo_start_date)->format('d/M/Y') : 'No Sched.' }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Burial date</label>
                        <p>{{ $joData->jo_burial_date ? \Carbon\Carbon::parse($joData->jo_burial_date)->format('d/M/Y') : 'No Sched.' }}</p>
                    </div> 
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Burial time</label>
                        <p>{{ $joData->jo_burial_time ? \Carbon\Carbon::parse($joData->jo_burial_time)->format('g:i A') : 'No Sched.' }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Embalm time</label>
                        <p>{{ $joData->jo_embalm_time ? \Carbon\Carbon::parse($joData->jo_embalm_time)->format('g:i A') : 'No Sched.' }}</p>
                    </div>

                    @if($joData->joToSvcReq->svc_status != 'Completed')
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Assign Schedule</label>
                            <!-- Button trigger modal for assign schedule -->
                            <button type="button" class="cust-btn cust-btn-primary" data-bs-toggle="modal" data-bs-target="#applySched">
                            Schedule
                            </button>
                        </div>
                    @endif
                    
                    

                    <!-- Modal for schedule -->
                    <div class="modal fade" id="applySched" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="applySchedLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="applySchedLabel">Assign Schedule</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('Service-Request.updateSchedule', $joData->id) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label fw-semibold">Burial Date <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" name="burrDate" value="{{ old('burrDate', $joData->jo_burial_date ?? '') }}">
                                                <input type="date" name="svcDate" value="{{ old('svcDate', $joData->jo_start_date ?? '') }}" hidden>
                                                @error('burrDate')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                    <script>
                                                        document.addEventListener("DOMContentLoaded", function () {
                                                            var modal = new bootstrap.Modal(document.getElementById('applySched'));
                                                            modal.show();
                                                        });
                                                    </script>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-semibold">Burial Time</label>
                                                <input type="time" class="cust-time" name="burialTime" value="{{ old('burialTime', $joData->jo_burial_time ?? '') }}">
                                                @error('burialTime')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-semibold">Embalm Time</label>
                                                <input type="time" class="cust-time" name="embalmTime" value="{{ old('embalmTime', $joData->jo_embalm_time ?? '') }}">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="cust-btn cust-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="cust-btn cust-btn-primary">update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                </div>

                @if(!$joData->jod_id)
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
                            <p>₱{{ number_format($joData->jo_total, 2) }}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Down payment</label>
                            <p>₱{{ number_format($joData->joToSoa->sum('payment'), 2) }}</p>
                        </div>
                        
                        @if($joData->jo_status != 'Paid')
                            <div class="col-md-12 mt-2">
                                <form action="{{ route('Service-Request.payBalance', $joData->svc_id )}}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold">Balance  <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">₱</span>
                                                <input type="text" class="form-input" name="payment" value="{{ old('payment', $joData->jo_total - $joData->joToSoa->sum('payment')) }}">
                                            </div>
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
                                <label class="form-label fw-semibold">Change</label>
                                <p>₱{{ $joData->joToSoa->sum('payment') - $joData->jo_total }}</p>
                            </div>
                        @endif
                        
                    </div>
                @endif

                <!-- Modal for payment history -->
                <div class="modal fade" id="paymentHistory" tabindex="-1" aria-labelledby="paymentHistoryLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="paymentHistoryLabel">Payment History</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mx-3">
                                <div class="col-md-12">
                                    <div class="row cust-table-header cust-table-shadow">
                                        <div class="col-md-4">Payment</div>
                                        <div class="col-md-4">Date</div>
                                        <div class="col-md-4">Employee</div>
                                    </div>
                                </div>
                                <div class="col-md-12 cust-max-200 cust-table-shadow">
                                    @foreach($payHistoryData as $row)
                                        <div class="row cust-table-content">
                                            <div class="col-md-4">
                                                <p>₱{{ $row->payment }}</p>
                                            </div>
                                            <div class="col-md-4">
                                                <p>{{ \Carbon\Carbon::parse($row->payment_date)->format('d/M/Y') }}</p>
                                            </div>
                                            <div class="col-md-4">
                                                <p>{{ $row->soaToEmp->emp_fname }} {{ $row->soaToEmp->emp_lname }}</p>
                                            </div>

                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="cust-btn cust-btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                </div>

                

                
                {{-- Submit --}}
                <div class="row justify-content-end mt-4">
                    <div class="col col-auto">
                        @session('promt-s')
                            <div class="text-success small mt-1">{{ $value }}</div>
                        @endsession
                        @session('promt-f')
                            <div class="text-danger small mt-1">{{ $value }}</div>
                        @endsession
                    </div>
                    <div class="col col-auto">
                        <a href="{{ route('Job-Order.index') }}" class="cust-btn cust-btn-secondary"><i
                            class="bi bi-arrow-left"></i>
                            <span>Back</span>
                        </a>
                    </div>
                    @if($joData->joToSvcReq->svc_status != 'Completed' && !$joData->jod_id)
                        <div class="col col-auto">
                            <form action="{{ route('Service-Request.complete', $joData->svc_id) }}" method="get">
                                <button type="submit" class="cust-btn cust-btn-primary"><span>Complete Service</span></button>
                            </form>
                            
                        </div>
                    @endif
                </div>

            </div>

        </div>

    </div>
@endsection