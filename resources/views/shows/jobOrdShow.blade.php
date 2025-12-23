@extends('layouts.layout')
@section('title', 'Job Order')

@section('content')
@section('head', 'Show Job Order')

    {{-- table --}}
    <div class="cust-add-form">

        <!-- Client info -->
        <div class="row cust-white-bg">
            <div class="col-md-12">
                <h5 class="cust-sub-title">Client Info:</h5>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">First name</label>
                <p>{{ $joData->client_fname }}</p>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Middle name / initial</label>
                <p>{{ $joData->client_mname }}</p>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Last name</label>
                <p>{{ $joData->client_lname }}</p>
            </div>

            <div class="w-100 mb-2"></div>

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
                    <p>₱{{ $joData->joToJod->jodToAddWake ? $joData->jo_total + number_format(($joData->joToJod->jodToAddWake->day * $joData->joToJod->jodToAddWake->fee), 2) : $joData->jo_total }}</p>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Payment</label>
                    <p>₱{{ number_format($joData->joToSoa->sum('payment'), 2) }}</p>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Burial Asst.</label>
                    <p>₱{{ $joData->joToBurAsst->amount }}</p>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">View Burial Assistance</label>
                    <a href="{{ route('Burial-Assistance.show', $joData->ba_id) }}" class="cust-btn cust-btn-secondary"  data-bs-toggle="tooltip" data-bs-placement="top" title="View"><i class="fi fi-rr-eye"></i></a>
                </div>

                <div class="w-100"></div>

                @if($joData->jo_status == 'Paid')
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Change</label>
                        <p>₱{{ ($joData->ba_id ? number_format(($joData->joToBurAsst->amount + $joData->joToSoa->sum('payment')), 2) : $joData->joToSoa->sum('payment')) - ($joData->joToJod->jodToAddWake ? $joData->jo_total + ($joData->joToJod->jodToAddWake->day * $joData->joToJod->jodToAddWake->fee) : $joData->jo_total) }}</p>
                    </div>
                @else
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Balance</label>
                        <p>₱{{ number_format(($joData->joToJod->jodToAddWake ? $joData->jo_total + ($joData->joToJod->jodToAddWake->day * $joData->joToJod->jodToAddWake->fee) : $joData->jo_total) - ($joData->ba_id ? $joData->joToBurAsst->amount + $joData->joToSoa->sum('payment') : $joData->joToSoa->sum('payment')), 2) }}</p>
                    </div>
                @endif
                
            @else
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Total Payment</label>
                    <p>₱{{ $joData->joToJod->jodToAddWake ? number_format($joData->jo_total + ($joData->joToJod->jodToAddWake->day * $joData->joToJod->jodToAddWake->fee), 2) : number_format($joData->jo_total, 2) }}</p>
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
                        <p>₱{{ number_format(($joData->joToJod->jodToAddWake ? $joData->jo_total + ($joData->joToJod->jodToAddWake->day * $joData->joToJod->jodToAddWake->fee) : $joData->jo_total) - ($joData->ba_id ? ($joData->joToBurAsst->amount + $joData->joToSoa->sum('payment')) : $joData->joToSoa->sum('payment')), 2) }}</p>
                    </div>
                    
                @endif
                <div class="col-md-3">
                    <label for="" class="form-label fw-semibold text-secondary">Payment History</label>
                   <!-- Payment history modal -->
                    <button type="button" class="cust-btn cust-btn-secondary" data-bs-toggle="modal" data-bs-target="#paymentHistory">
                        <i class="bi bi-wallet"></i> View payment history
                    </button>

                </div>

                
                @session('promt-s')
                    <div class="col-md-12">
                        <div class="text-success small mt-1">{{ $value }}</div>
                    </div>
                @endsession
                
            @endif

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
                                        <p>₱{{ number_format($row->payment, 2) }}</p>
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
                <label class="form-label fw-semibold">First name</label>
                <p>{{ $jodData->dec_fname }}</p>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Middle name / initial</label>
                <p>{{ $jodData->dec_mname }}</p>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Last name</label>
                <p>{{ $jodData->dec_lname }}</p>
            </div>

            <div class="w-100 mb-2"></div>

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
                <p>{{ \Carbon\Carbon::parse($jodData->jod_deploy_date)->format('d/M/Y') ?? 'N/A'}}</p>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Return Date</label>
                <p>{{ \Carbon\Carbon::parse($jodData->jod_return_date)->format('d/M/Y') ?? 'N/A' }}</p>
            </div>
        </div>


        {{-- Package Items --}}
        <div class="row mt-4 cust-white-bg">

            <div class="col-md-12">

                {{-- Items --}}
                <div class="row">
                    <div class="col-md-12">
                        <h4>Item:</h4>
                    </div>
                    <div class="col-md-12">
                        <div class="row cust-table-header cust-table-shadow">
                            <div class="col-md-3">Name</div>
                            <div class="col-md-3">Size</div>
                            <div class="col-md-6">Deployed Qty.</div>
                        </div>
                    </div>
                    <div class="col-md-12 cust-max-300 cust-table-shadow">
                        @foreach($pkgStoData as $row)
                            <div class="row cust-table-content">
                                <div class="col col-3">
                                    <label class="form-label fw-semibold text-secondary">Name</label>
                                    <p>{{ $row->pkgStoToSto->item_name }}</p>
                                </div>
                                <div class="col col-3">
                                    <label class="form-label fw-semibold text-secondary">Size</label>
                                    <p>{{ $row->pkgStoToSto->item_size }}</p>
                                </div>
                                <div class="col col-6">
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
                                
                            </div>
                        @endforeach

                    </div>
                </div>


                
            </div>

        </div>

        {{-- Package Equipment --}}
        <div class="row cust-white-bg mt-4">
            <div class="col-md-12">
                <h4>Equipment:</h4>
            </div>
            <div class="col-md-12">
                <div class="row cust-table-header cust-table-shadow">
                    <div class="col-md-3">Name</div>
                    <div class="col-md-3">Size</div>
                    <div class="col-md-6">Deployed Qty.</div>
                </div>
            </div>
            <div class="col-md-12 cust-max-300 cust-table-shadow">
                @foreach($tempEqData as $row)
                    <div class="row cust-table-content">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-secondary">Name</label>
                            <p>{{ $row->tempEqToPkgEq->pkgEqToEq->eq_name }}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-secondary">Size</label>
                            <p>{{ $row->tempEqToPkgEq->pkgEqToEq->eq_size }}</p>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="eqId[]" value="{{ $row->tempEqToPkgEq->eq_id }}" hidden>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-secondary">Quantity</label>
                                    <p>{{ $row->eq_dpl_qty }}</p>
                                    <input type="text" name="eqDepl[]" value="{{ $row->eq_dpl_qty }}" hidden>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-secondary">Pcs/Kg/L</label>
                                    <p>{{ $row->eq_dpl_qty_set }}</p>
                                    <input type="text" name="eqDeplSet[]" value="{{ $row->eq_dpl_qty_set }}" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Submit --}}
        <div class="row justify-content-end mt-4">
            {{-- Display Error --}}
            <div class="col col-auto">
                @session('promt')
                    <div class="text-danger small mt-1">{{ $value }}</div>
                @endsession
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