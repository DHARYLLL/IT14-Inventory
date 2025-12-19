@extends('layouts.layout')
@section('title', 'Job Order')

@section('content')
@section('head', 'Show Job Order')

    {{-- table --}}
    <div class="cust-add-form">

        {{-- Display error --}}
        @session('promt-f')
            <div class="row mb-4 cust-error-msg">
                <div class="col-md-12">
                    <div class="text-danger"><p>{{ $value }}</p></div>
                </div>
            </div>
        @endsession

        @if(!$joData->jo_burial_time)
            <div class="row mb-4 cust-warning-msg">
                <div class="col-md-12">
                    <p>No burial time is assigned</p>
                </div>
            </div>
        @endif



        <!-- Client info -->
        <div class="row cust-white-bg">
            <div class="col-md-12">
                <h5 class="cust-sub-title">Client Info:</h5>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Client</label>
                <p>{{ $joData->client_name }}</p>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Contact Number</label>
                <p>{{ $joData->client_contact_number }}</p>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Referal (Ra)</label>
                <form action="{{ route('Job-Order.raUpdate', $joData->id) }}" method="POST" class="raForm">
                    @csrf
                    @method('put')
                    <label>
                        <input type="checkbox" name="status" class="raCheckbox" {{ $joData->ra ? 'checked' : '' }} {{ $joData->ba_id || $joData->jo_status == 'Paid' ? 'disabled' : '' }}>
                    </label>
                </form>
                <script>
                    document.querySelectorAll('.raCheckbox').forEach((checkbox) => {
                        checkbox.addEventListener('change', function() {
                            // submit the form that contains this checkbox
                            this.closest('form').submit();
                        });
                    });
                </script>
            </div>

            <div class="w-100"></div>

            @if($joData->ba_id)
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Total Payment</label>
                    <p>₱{{ number_format(($joData->joToJod->jodToAddWake ? $joData->jo_total + ($joData->joToJod->jodToAddWake->day * $joData->joToJod->jodToAddWake->fee) : $joData->jo_total), 2) }}</p>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Payment</label>
                    <p>₱{{ number_format($joData->joToSoa->sum('payment'), 2) }}</p>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Burial Asst.</label>
                    <p>₱{{ number_format($joData->joToBurAsst->amount, 2) }}</p>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">View Burial Assistance</label>
                    <a href="{{ route('Burial-Assistance.show', $joData->ba_id) }}" class="cust-btn cust-btn-secondary"  data-bs-toggle="tooltip" data-bs-placement="top" title="View"><i class="fi fi-rr-eye"></i></a>
                </div>

                <div class="w-100"></div>

                @if($joData->jo_status == 'Paid')
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Change</label>
                        <p>₱{{ number_format(($joData->ba_id ? ($joData->joToBurAsst->amount + $joData->joToSoa->sum('payment')) : $joData->joToSoa->sum('payment')) - ($joData->joToJod->jodToAddWake ? $joData->jo_total + ($joData->joToJod->jodToAddWake->day * $joData->joToJod->jodToAddWake->fee) : $joData->jo_total), 2) }}</p>
                    </div>
                @else
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Balance</label>
                        <p>₱{{ number_format(($joData->joToJod->jodToAddWake ? $joData->jo_total + ($joData->joToJod->jodToAddWake->day * $joData->joToJod->jodToAddWake->fee) : $joData->jo_total) - ($joData->ba_id ? ($joData->joToBurAsst->amount + $joData->joToSoa->sum('payment')) : $joData->joToSoa->sum('payment')), 2) }}</p>
                    </div>
                @endif
                
            @else
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Total Payment</label>
                    <p>₱{{ number_format(($joData->joToJod->jodToAddWake ? $joData->jo_total + ($joData->joToJod->jodToAddWake->day * $joData->joToJod->jodToAddWake->fee) : $joData->jo_total), 2) }}</p>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Payment</label>
                    <p>₱{{ number_format($joData->joToSoa->sum('payment'), 2) }}</p>
                </div>
                @if($joData->jo_status == 'Paid')
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Change</label>
                        <p>₱{{ number_format(($joData->ba_id ? ($joData->joToBurAsst->amount + $joData->joToSoa->sum('payment')) : $joData->joToSoa->sum('payment')) - ($joData->joToJod->jodToAddWake ? $joData->jo_total + ($joData->joToJod->jodToAddWake->day * $joData->joToJod->jodToAddWake->fee) : $joData->jo_total), 2) }}</p>
                    </div>
                @else
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Balance</label>
                        <p>₱{{ number_format((($joData->joToJod->jodToAddWake ? $joData->jo_total + ($joData->joToJod->jodToAddWake->day * $joData->joToJod->jodToAddWake->fee) : $joData->jo_total) - ($joData->ba_id ? ($joData->joToBurAsst->amount + $joData->joToSoa->sum('payment')) : $joData->joToSoa->sum('payment'))), 2) }}</p>
                    </div>
                    
                @endif
                

                
                @session('promt-s')
                    <div class="col-md-12">
                        <div class="text-success small mt-1">{{ $value }}</div>
                    </div>
                @endsession
                
            @endif
            <div class="col-md-3">
                <label for="" class="form-label fw-semibold text-secondary">Payment History</label>
                <!-- Payment history modal -->
                <button type="button" class="cust-btn cust-btn-secondary" data-bs-toggle="modal" data-bs-target="#paymentHistory">
                    <i class="bi bi-wallet"></i> View payment history
                </button>

            </div>

        </div>

        @if($joData->jo_status != 'Paid')
            <div class="row cust-white-bg mt-4">

                <div class="col-md-12">
                    <h5 class="cust-sub-title">Payment:</h5>
                </div>
    
                <div class="col-md-12">                           
                    <form action="{{ route('Job-Order.pay', $joData->id) }}" method="POST">
                        @csrf
                        @method('put')
                    
                        <div class="row">
                            <div class="col-md-3">
                                <label for="payAmount" class="form-label fw-semibold text-secondary">Amount <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control" name="payAmount"
                                        value="{{ old('payAmount',
                                                ($joData->joToJod->jodToAddWake ? $joData->jo_total + ($joData->joToJod->jodToAddWake->day * $joData->joToJod->jodToAddWake->fee) : $joData->jo_total) -
                                                ($joData->ba_id ? ($joData->joToBurAsst->amount + $joData->joToSoa->sum('payment')) : $joData->joToSoa->sum('payment')))
                                            }}">
                                </div>
                                @error('payAmount')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                <input type="text" name="addWakeId" value="{{ $joData->joTojod->jodToAddWake->id ?? '' }}" hidden>
                            </div>
                            <div class="col-md-3">
                                <label for="" class="form-label fw-semibold text-secondary">Pay Balance</label>
                                <button type="submit" class="cust-btn cust-btn-primary w-100">Pay</button>
                            </div>

                            @if(!$joData->ba_id && $joData->ra)                                               
                                    
                                <div class="col-md-3">
                                    <label for="" class="form-label fw-semibold text-secondary">Apply Burial Assistance</label>
                                    <a href="{{ route('Job-Order.apply', $joData->id) }}" class="cust-btn cust-btn-secondary w-100 text-center">Apply</a>
                                </div>                                                                                                 
                            @endif
                        </div>                                       
                    </form>
                </div>
            </div>
        @endif

        {{-- Job Order Details --}}
        <div class="row mt-4 cust-white-bg">
            <div class="col-md-12">
                <h5 class="cust-sub-title">Job Order Details:</h5>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Package</label>
                <p>{{ $jodData->jodToPkg->pkg_name }}</p>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Chapel</label>
                <p>{{ $jodData->chap_id ? $jodData->jodToChap->chap_name : 'N/A' }}{{ $jodData->chap_id ? ' | '. $jodData->jodToChap->chap_room : '' }}</p>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Days of Wake</label>
                <p>{{ $jodData->jod_days_of_wake }}</p>
            </div>

            @if(!$joData->joToJod->jodToAddWake)
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Add. Wake</label>
                    <!-- Button trigger modal for adding wake days -->
                    <button type="button" class="cust-btn cust-btn-primary" data-bs-toggle="modal" data-bs-target="#wakeDay">
                    Add wake
                    </button>
                </div>
            @endif

            @if($joData->joToJod->jodToAddWake)
                <div class="w-100 mb-2"></div>

                <div class="col-md-12">
                    <h5 class="cust-sub-title">Additional Wake:</h5>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Add. Wake Days</label>
                    <p>{{ $joData->joToJod->jodToAddWake->day }}</p>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Total Fee</label>
                    <p>₱{{ $joData->joToJod->jodToAddWake->day * $joData->joToJod->jodToAddWake->fee }}</p>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Add. Wake</label>

                    <div class="row">
                        <div class="col col-auto">
                            <!-- Button trigger modal for edit wake days -->
                            <button type="button" class="cust-btn cust-btn-secondary" data-bs-toggle="modal" data-bs-target="#wakeDayEdit">
                            <i class="bi bi-pencil-square" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i> 
                            </button>
                        </div>
                        <div class="col col-auto">
                            <!-- Delete button -->
                            <button type="button" class="cust-btn cust-btn-danger-secondary" data-bs-toggle="modal" data-bs-target="#wakeDayDelete">
                            <i class="bi bi-trash" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancel"></i> 
                            </button>
                        </div>
                    </div>
                    
                </div>
            @endif
            

            <div class="w-100 mb-2"></div>

            <div class="col-md-12">
                <h5 class="cust-sub-title">Schedule:</h5>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Service Date</label>
                <p>{{ \Carbon\Carbon::parse($joData->jo_start_date)->format('d/M/Y')}}</p>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Burial Date</label>
                <p>{{ \Carbon\Carbon::parse($joData->jo_burial_date)->format('d/M/Y') }}</p>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Burial Time</label>
                <p>{{ $joData->jo_burial_time ? \Carbon\Carbon::parse($joData->jo_burial_time)->format('g:i A') : 'No sched.' }}</p>
            </div>
            
            <div class="col-md-3">
                <label class="form-label fw-semibold">Embalm Time</label>
                <p>{{ $joData->jo_embalm_time ? \Carbon\Carbon::parse($joData->jo_embalm_time)->format('g:i A') : 'No sched.' }}</p>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Assign Schedule</label>
                <!-- Button trigger modal for assign schedule -->
                <button type="button" class="cust-btn cust-btn-primary" data-bs-toggle="modal" data-bs-target="#applySched">
                Schedule
                </button>
            </div>
            
            
        </div>

        {{-- Service Details --}}
        <div class="row mt-4 cust-white-bg">

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
                <label class="form-label fw-semibold">Edit Personnel</label>
                <!-- Button trigger modal -->
                <button type="button" class="cust-btn cust-btn-secondary" data-bs-toggle="modal" data-bs-target="#personnel">
                    Edit Personnel
                </button>
            </div>

        </div>

        <!-- Modal for perosonnel -->
        <div class="modal fade" id="personnel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="personnelLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="personnelLabel">Edit Personnel</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('Service-Request.update', $joData->svc_id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Embalmer</label>
                                    <select name="embalm" class="form-select ">
                                        @foreach($embalmData as $row)
                                            <option value="{{ $row->id }}" {{ $joData->joToSvcReq->prep_id == $row->id ? 'selected' : '' }}>{{ $row->embalmer_name }}</option>
                                        @endforeach
                                    </select>   
                                    @error('embalm')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Driver</label>
                                    <select name="vehicle" class="form-select ">
                                        @foreach($vehData as $row)
                                            <option value="{{ $row->id }}" {{ $joData->joToSvcReq->veh_id == $row->id ? 'selected' : '' }}>{{ $row->driver_name }}</option>
                                        @endforeach
                                    </select>   
                                    @error('vehicle')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    @session('promt-f-svc')
                                        <div class="text-danger small mt-1">{{ $value }}</div>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function () {
                                                var modal = new bootstrap.Modal(document.getElementById('personnel'));
                                                modal.show();
                                            });
                                        </script>
                                    @endsession
                                </div>
                            </div >
                        </div>
                        <div class="modal-footer">
                            <input type="text" name="burrDate" value="{{ $joData->jo_burial_date }}" hidden>
                            <button type="button" class="cust-btn cust-btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="cust-btn cust-btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for schedule -->
        <div class="modal fade" id="applySched" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="applySchedLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="applySchedLabel">Assign Schedule</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('Job-Order.sched', $joData->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Burial Time <span class="text-danger">*</span></label>
                                    <input type="time" class="cust-time" name="burialTime" value="{{ old('burialTime', $joData->jo_burial_time ?? '') }}">
                                    @error('burialTime')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function () {
                                                var modal = new bootstrap.Modal(document.getElementById('applySched'));
                                                modal.show();
                                            });
                                        </script>
                                    @enderror
                                </div>
                                <div class="col-md-6">
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

        <!-- Modal for wake -->
        <div class="modal fade" id="wakeDay" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="wakeDayLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="wakeDayLabel">Additional Wake</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('Add-Wake.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Additional Days <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="addDays" value="{{ old('addDays', 1) }}">
                                    @error('addDays')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    @session('promt-f-add')
                                        <div class="text-danger small mt-1">{{ $value }}</div>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function () {
                                                var modal = new bootstrap.Modal(document.getElementById('wakeDay'));
                                                modal.show();
                                            });
                                        </script>
                                    @endsession
                                    <input type="text" name="jodId" value="{{ $joData->joToJod->id }}" hidden>
                                    <input type="text" name="joId" value="{{ $joData->id }}" hidden>
                                    <input type="text" name="burDate" value="{{ $joData->jo_burial_date }}" hidden>
                                    <input type="text" name="vehId" value="{{ $joData->joToSvcReq->veh_id }}" hidden>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Fee per Day <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="addFeeDays" value="{{ old('addFeeDays', 1000) }}">
                                    @error('addFeeDays')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    @if($errors->has('addDays') || $errors->has('addFeeDays'))
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function () {
                                                var modal = new bootstrap.Modal(document.getElementById('wakeDay'));
                                                modal.show();
                                            });
                                        </script>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <input type="text" name="burrAsstId" value="{{$joData->ba_id ? $joData->joToBurAsst->id : '' }}" hidden>
                            <button type="button" class="cust-btn cust-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="cust-btn cust-btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for wake Edit -->
        <div class="modal fade" id="wakeDayEdit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="wakeDayEditLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="wakeDayEditLabel">Edit Additional Wake</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ $joData->joToJod->jodToAddWake ? route('Add-Wake.update', $joData->joToJod->jodToAddWake->id) : '' }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Additional Days <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="days" value="{{ $joData->joToJod->jodToAddWake ? old('days', $joData->joToJod->jodToAddWake->day) : '' }}">
                                    @error('days')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    @session('promt-f-edit')
                                        <div class="text-danger small mt-1">{{ $value }}</div>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function () {
                                                var modal = new bootstrap.Modal(document.getElementById('wakeDayEdit'));
                                                modal.show();
                                            });
                                        </script>
                                    @endsession
                                    <input type="text" name="jodId" value="{{ $joData->joToJod->id }}" hidden>
                                    <input type="text" name="joId" value="{{ $joData->id }}" hidden>
                                    <input type="text" name="burrAsstId" value="{{$joData->ba_id ? $joData->joToBurAsst->id : '' }}" hidden>
                                    <input type="text" name="vehId" value="{{ $joData->joToSvcReq->veh_id }}" hidden>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Fee per Day <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="feeDays" value="{{ $joData->joToJod->jodToAddWake ? old('feeDays', $joData->joToJod->jodToAddWake->fee) : '' }}">
                                    @error('feeDays')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    @if($errors->has('days') || $errors->has('feeDays'))
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function () {
                                                var modal = new bootstrap.Modal(document.getElementById('wakeDayEdit'));
                                                modal.show();
                                            });
                                        </script>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="cust-btn cust-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="cust-btn cust-btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for wake Delete -->
        <div class="modal fade" id="wakeDayDelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="wakeDayDeleteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="wakeDayDeleteLabel">Delete</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ $joData->joToJod->jodToAddWake ? route('Add-Wake.destroy', $joData->joToJod->jodToAddWake->id) : '' }}" method="POST">
                        @csrf
                        @method('delete')
                        <div class="modal-body">
                            <p>Are you sure you want to Delete the additional wake?</p>
                            @session('promt-f-delete')
                                <div class="text-danger small mt-1">{{ $value }}</div>
                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        var modal = new bootstrap.Modal(document.getElementById('wakeDayDelete'));
                                        modal.show();
                                    });
                                </script>
                            @endsession

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="cust-btn cust-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="cust-btn cust-btn-danger-primary">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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

        {{-- Deceased Info --}}
        <div class="row mt-4 cust-white-bg">
            <div class="col-md-12">
                <h5 class="cust-sub-title">Deceased Info:</h5>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Deceased Name</label>
                <p>{{ $jodData->dec_name }}</p>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Birth Date</label>
                <p>{{ \Carbon\Carbon::parse($jodData->dec_born_date)->format('d/M/Y') }}</p>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Died Date</label>
                <p>{{ \Carbon\Carbon::parse($jodData->dec_died_date)->format('d/M/Y') }}</p>
            </div>

        </div>

        {{-- Location --}}
        <div class="row mt-4 cust-white-bg">
            <div class="col-md-12">
                <h5 class="cust-sub-title">Location:</h5>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Wake Location</label>
                <p>{{ $joData->client_address ?? 'N/A' }}</p>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Burial Location</label>
                <p>{{ $jodData->jod_burialLoc ?? 'N/A' }}</p>
            </div>
        </div>

        {{-- Equipment --}}
        <div class="row mt-4 cust-white-bg">
            <div class="col-md-12">
                <h5 class="cust-sub-title">Equipment Status:</h5>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Equipment Status</label>
                <p>{{ $jodData->jod_eq_stat }}</p>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Deployed Date</label>
                <p>{{ $jodData->jod_deploy_date ?? 'N/A'}}</p>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Return Date</label>
                <p>{{ $jodData->jod_return_date ?? 'N/A' }}</p>
            </div>
        </div>

        <form action="{{ route('Job-Order.deploy', $jodData->id) }}" method="POST">
            @csrf
            @method('put')

            {{-- Package Items and Equipment --}}
            <div class="row mt-4 cust-white-bg">
                <div class="col-md-12">
                    <h5 class="cust-sub-title">Package Items:</h5>
                </div>

                <div class="col-md-12">
                    {{-- Items --}}
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h4>Item:</h4>
                        </div>
                        <div class="col-md-12">
                            <div class="row cust-table-header cust-table-shadow">
                                <div class="col-md-2">Name</div>
                                <div class="col-md-2">Size</div>
                                <div class="col-md-4">Initial Qty.</div>
                                <div class="col-md-4">Deployed Qty.</div>
                            </div>
                        </div>
                        <div class="col-md-12 cust-max-300 cust-table-shadow">
                            @foreach($pkgStoData as $row)
                                <div class="row cust-table-content">
                                    <div class="col-md-2">
                                        <label class="form-label fw-semibold text-secondary"></label>
                                        <p>{{ $row->pkgStoToSto->item_name }}</p>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label fw-semibold text-secondary"></label>
                                        <p>{{ $row->pkgStoToSto->item_size }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-secondary">Quantity</label>
                                                <p>{{ $row->stock_used }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-secondary">Pcs/Kg/L</label>
                                                <p>{{ $row->stock_used_set }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="stoId[]" value="{{ $row->pkgStoToSto->id }}" hidden>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-secondary">Quantity</label>
                                                <p>{{ $row->stock_used }}</p>
                                                <input type="text" name="stoDepl[]" value="{{ $row->stock_used }}" hidden>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-secondary">Pcs/Kg/L</label>
                                                <p>{{ $row->stock_used_set }}</p>
                                                <input type="text" name="stoDeplSet[]" value="{{ $row->stock_used_set }}" hidden>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    
                    </div>
                </div>                 
            </div>

            <div class="row mt-4 cust-white-bg">

                <div class="col-md-12">
                     <h5 class="cust-sub-title">Package Equipment:</h5>
                </div>
                <div class="col-md-12">
                    {{-- Equipment --}}
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h4>Equipment:</h4>
                        </div>
                        <div class="col-md-12">
                            <div class="row cust-table-header cust-table-shadow">
                                <div class="col-md-2">Name</div>
                                <div class="col-md-2">Size</div>
                                <div class="col-md-4">Initial Qty.</div>
                                <div class="col-md-4">Deploy Qty.</div>
                            </div>
                        </div>
                        <div class="col-md-12 cust-max-300 cust-table-shadow">
                            @foreach($pkgEqData as $row)
                                <div class="row cust-table-content">
                                    <div class="col-md-2">
                                        <label class="form-label fw-semibold text-secondary"></label>
                                        <p>{{ $row->pkgEqToEq->eq_name }}</p>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label fw-semibold text-secondary"></label>
                                        <p>{{ $row->pkgEqToEq->eq_size }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-secondary">Quantity</label>
                                                <p>{{ $row->eq_used }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-secondary">Pcs/Kg/L</label>
                                                <p>{{ $row->eq_used_set }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="eqId[]" value="{{ $row->pkgEqToEq->id }}" hidden>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-secondary">Quantity</label>
                                                <input type="number" class="form-input w-100 mb-1" name="eqDepl[]"
                                                    value="{{ old('eqDepl.' . $loop->index, $row->eq_used) }}">
                                                @error("eqDepl." . $loop->index)
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-secondary">Pcs/Kg/L</label>
                                                <input type="number" class="form-input w-100 mb-1" name="eqDeplSet[]"
                                                    value="{{ old('eqDeplSet.' . $loop->index, $row->eq_used_set) }}">
                                                @error("eqDeplSet." . $loop->index)
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>

            {{-- Submit --}}
            <div class="row justify-content-end mt-4">
                {{-- Display Error --}}
                <div class="col col-auto">
                    @session('promt-f')
                        <div class="text-danger small mt-1">{{ $value }}</div>
                    @endsession
                    @session('promt-s')
                        <div class="text-success small mt-1">{{ $value }}</div>
                    @endsession
                </div>
                <div class="col col-auto">
                    <a href="{{ route('Job-Order.index') }}" class="cust-btn cust-btn-secondary"><i
                        class="bi bi-arrow-left"></i>
                        <span>Cancel</span>
                    </a>
                </div>
                {{-- Submit Button --}}
                <div class="col col-auto ">
            
                    <button type="submit" class="cust-btn cust-btn-primary"><i class="bi bi-send"></i>
                        Deploy Equipment
                    </button>
            
                </div>
            </div>
        </form>


 
    </div>
@endsection