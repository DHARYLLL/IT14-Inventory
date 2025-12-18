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
                    <p>₱{{ $joData->joToJod->jodToAddWake ? $joData->jo_total + ($joData->joToJod->jodToAddWake->day * $joData->joToJod->jodToAddWake->fee) : $joData->jo_total }}</p>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Down Payment</label>
                    <p>₱{{ $joData->jo_dp }}</p>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Burial Asst.</label>
                    <p>₱{{ $joData->joToBurAsst->amount }}</p>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">View Burial Assistance</label>
                    <a href="{{ route('Burial-Assistance.show', $joData->ba_id) }}" class="cust-btn cust-btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="View"><i class="fi fi-rr-eye"></i></a>
                </div>
                
                <div class="w-100"></div>

                @if($joData->jo_status == 'Paid')
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Change</label>
                        <p>₱{{ ($joData->ba_id ? ($joData->joToBurAsst->amount + $joData->jo_dp) : $joData->jo_dp) - ($joData->joToJod->jodToAddWake ? $joData->jo_total + ($joData->joToJod->jodToAddWake->day * $joData->joToJod->jodToAddWake->fee) : $joData->jo_total) }}</p>
                    </div>
                @else
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Balance</label>
                        <p>₱{{ ($joData->joToJod->jodToAddWake ? $joData->jo_total + ($joData->joToJod->jodToAddWake->day * $joData->joToJod->jodToAddWake->fee) : $joData->jo_total) - ($joData->ba_id ? ($joData->joToBurAsst->amount + $joData->jo_dp) : $joData->jo_dp) }}</p>
                    </div>
                @endif
                
            @else
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Total Payment</label>
                    <p>₱{{ $joData->joToJod->jodToAddWake ? $joData->jo_total + ($joData->joToJod->jodToAddWake->day * $joData->joToJod->jodToAddWake->fee) : $joData->jo_total }}</p>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Down Payment</label>
                    <p>₱{{ $joData->jo_dp }}</p>
                </div>
                @if($joData->jo_status == 'Paid')
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Change</label>
                        <p>₱{{ ($joData->ba_id ? ($joData->joToBurAsst->amount + $joData->jo_dp) : $joData->jo_dp) - ($joData->joToJod->jodToAddWake ? $joData->jo_total + ($joData->joToJod->jodToAddWake->day * $joData->joToJod->jodToAddWake->fee) : $joData->jo_total) }}</p>
                    </div>
                @else
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Balance</label>
                        <p>₱{{ ($joData->joToJod->jodToAddWake ? $joData->jo_total + ($joData->joToJod->jodToAddWake->day * $joData->joToJod->jodToAddWake->fee) : $joData->jo_total) - ($joData->ba_id ? ($joData->joToBurAsst->amount + $joData->jo_dp) : $joData->jo_dp) }}</p>
                    </div>
                @endif

                
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
                                <input type="text" class="form-control" name="payAmount" 
                                    value="{{ old('payAmount', 
                                            ($joData->joToJod->jodToAddWake ? $joData->jo_total + ($joData->joToJod->jodToAddWake->day * $joData->joToJod->jodToAddWake->fee) : $joData->jo_total) - 
                                            ($joData->ba_id ? ($joData->joToBurAsst->amount + $joData->jo_dp) : $joData->jo_dp)) 
                                        }}">
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


        {{-- Job Order --}}
        <div class="row  mt-4 cust-white-bg">
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
                <label class="form-label fw-semibold">Service Date</label>
                <p>{{ \Carbon\Carbon::parse($joData->jo_start_date)->format('d/M/Y') }}</p>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Days of Wake</label>
                <p>{{ $jodData->jod_days_of_wake }}</p>
            </div>
            

            <div class="w-100 mb-2"></div>

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

            @if($joData->joToJod->jodToAddWake)
                <div class="w-100 mb-2"></div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Add. Wake Days</label>
                    <p>{{ $joData->joToJod->jodToAddWake->day }}</p>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Total Fee</label>
                    <p>₱{{ $joData->joToJod->jodToAddWake->day * $joData->joToJod->jodToAddWake->fee }}</p>
                </div>

            @endif
            
            
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

        {{-- Equipment Status --}}
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
                <p>{{ $jodData->jod_deploy_date ? \Carbon\Carbon::parse($jodData->jod_deploy_date)->format('d/M/Y') : 'N/A'}}</p>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Return Date</label>
                <p>{{ $jodData->jod_return_date ? \Carbon\Carbon::parse($jodData->jod_return_date)->format('d/M/Y') : 'N/A' }}</p>
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