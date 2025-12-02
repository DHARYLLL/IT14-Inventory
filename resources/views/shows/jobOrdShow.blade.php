@extends('layouts.layout')
@section('title', 'Job Order')

@section('content')
@section('head', 'Show Job Order')

    {{-- table --}}
    <div class="cust-h-100">
        <div class="row h-100 p-3">
            
            <div class="col col-12 h-100 overflow-auto">
                {{-- Info Table --}}
                <div class="row">
                    {{-- Left --}}
                    <div class="col-md-6">

                        <div class="row cust-white-bg mx-1">
                            <div class="col-md-12">
                                <h5 class="cust-sub-title">Package and Services</h5>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Package</label>
                                <p>{{ $jodData->jodToPkg->pkg_name }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Chapel</label>
                                <p>{{ $jodData->chap_id ? $jodData->jodToChap->chap_name : 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="row mt-4 cust-white-bg mx-1">
                            <div class="col-md-12">
                                <h5 class="cust-sub-title">Client Info:</h5>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Client</label>
                                <p>{{ $joData->client_name }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Contact Number</label>
                                <p>{{ $joData->client_contact_number }}</p>
                            </div>

                            <div class="w-100"></div>

                            @if($joData->joToBurrAsst)
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Total Payment</label>
                                    <p>₱{{ $joData->jo_total }}</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Burial Asst.</label>
                                    <p>₱{{ $joData->joToBurrAsst->amount }}</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">View</label>
                                    <a href="{{ route('Burial-Assistance.show', $joData->joToBurrAsst->id) }}" class="cust-btn cust-btn-secondary"><i class="fi fi-rr-eye"></i></a>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Down Payment</label>
                                    <p>₱{{ $joData->jo_dp }}</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Balance</label>
                                    <p>₱{{ $joData->jo_total - ($joData->joToBurrAsst ? ($joData->joToBurrAsst->amount + $joData->jo_dp) : $joData->jo_dp) }}</p>
                                </div>
                                
                            @else
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Total Payment</label>
                                    <p>₱{{ $joData->jo_total }}</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Down Payment</label>
                                    <p>₱{{ $joData->jo_dp }}</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Balance</label>
                                    <p>₱{{ $joData->jo_total - ($joData->joToBurrAsst ? ($joData->joToBurrAsst->amount + $joData->jo_dp) : $joData->jo_dp) }}</p>
                                </div>
                                @session('promt-s')
                                    <div class="col-md-12">
                                        <div class="text-success small mt-1">{{ $value }}</div>
                                    </div>
                                @endsession
                                
                            @endif
                        </div>

                        <div class="row mt-4 cust-white-bg mx-1">
                            <div class="col-md-12">
                                <h5 class="cust-sub-title">Deceased Info:</h5>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Deceased Name</label>
                                <p>{{ $jodData->dec_name }}</p>
                            </div>
                            <div class="w-100"></div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Birth Date</label>
                                <p>{{ $jodData->dec_born_date }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Died Date</label>
                                <p>{{ $jodData->dec_died_date }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Casue of Death</label>
                                <p>{{ $jodData->dec_cause_of_death }}</p>
                            </div>

                        </div>


                    </div>

                    {{-- Right --}}
                    <div class="col-md-6">

                        <div class="row cust-white-bg mx-1">
                            <div class="col-md-12">
                                <h5 class="cust-sub-title">Job Order Details:</h5>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Start Date</label>
                                <p>{{ $joData->jo_start_date }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Start Time</label>
                                <p>{{ $joData->jo_start_time }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">End Time</label>
                                <p>{{ $joData->jo_end_time }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Days of Wake</label>
                                <p>{{ $jodData->jod_days_of_wake }}</p>
                            </div>
                        </div>

                        @if($joData->jo_status != 'Paid')
                            <div class="row cust-white-bg mx-1 mt-4">

                                <div class="col-md-12">
                                    <h5 class="cust-sub-title">Payment:</h5>
                                </div>
                    
                                <div class="col-md-12">                           
                                    <form action="{{ route('Burial-Assistance.update', $joData->id) }}" method="POST">
                                        @csrf
                                        @method('put')
                                    
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="payAmount" class="form-label fw-semibold text-secondary">Amount</label>
                                                <input type="text" name="burAssistAmount" value="{{ $joData->joToBurrAsst ? ($joData->joToBurrAsst->amount) : 0 }}" hidden>
                                                <input type="text" class="form-control" name="payAmount" 
                                                    value="{{ old('payAmount') ? old('payAmount') : $joData->jo_total - 
                                                    ($joData->joToBurrAsst ? ($joData->joToBurrAsst->amount + $joData->jo_dp) : $joData->jo_dp) }}">
                                                @error('payAmount')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                                
                                            </div>
                                            <div class="col-md-4">
                                                <label for="" class="form-label fw-semibold text-secondary">Pay Balance</label>
                                                <button type="submit" class="cust-btn cust-btn-primary w-100">Pay</button>
                                            </div>

                                            @if(!$joData->joToBurrAsst)                                               
                                                    
                                                <div class="col-md-5">
                                                    <label for="" class="form-label fw-semibold text-secondary">Apply Burial Assistance</label>
                                                    <a href="{{ route('Job-Order.apply', $joData->id) }}" class="cust-btn cust-btn-secondary w-100 text-center">Apply</a>
                                                </div>                                                                                                 
                                            @endif
                                        </div>                                       
                                    </form>
                                </div>
                            </div>
                        @endif



                        <div class="row mt-4 cust-white-bg mx-1">
                            <div class="col-md-12">
                                <h5 class="cust-sub-title">Location:</h5>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Wake Location</label>
                                <p>{{ $jodData->jod_wakeLoc }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Burial Location</label>
                                <p>{{ $jodData->jod_burialLoc }}</p>
                            </div>
                        </div>

                        <div class="row mt-4 cust-white-bg mx-1">
                            <div class="col-md-12">
                                <h5 class="cust-sub-title">Equipment Status:</h5>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Equipment Status</label>
                                <p>{{ $jodData->jod_eq_stat }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Deployed Date</label>
                                <p>{{ $jodData->jod_deploy_date ?? 'N/A'}}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Return Date</label>
                                <p>{{ $jodData->jod_return_date ?? 'N/A' }}</p>
                            </div>
                        </div>



                    </div>


                </div>
               

                <form action="{{ route('Job-Order.deploy', $jodData->id) }}" method="POST" >
                    @csrf
                    @method('put')

                    {{-- Additional Items and Equipment --}}
                    <div class="row mt-4 cust-white-bg">
                        <div class="col-auto">
                            <h5 class="cust-sub-title">Additional Items and Equipment:</h5>
                        </div>
                        <div class="w-100"></div>

                        <div class="col-md-6">
                            <h4>Additional Item:</h4>
                            <div class="row cust-underline">
                                <div class="col col-3">Name</div>
                                <div class="col col-3">Size</div>
                                <div class="col col-3">Add. Fee</div>
                                <div class="col col-3">Qty. Used</div>
                            </div>

                            @if($addStoData->isEmpty())
                                <div class="row mt-1 justify-content-center">
                                    <div class="col col-auto">No additional item.</div>
                                </div>
                            @else
                                 @foreach($addStoData as $row)
                                    <div class="row mt-1 cust-underline-secondary">
                                        <div class="col col-3">{{ $row->addStoToSto->item_name }}</div>
                                        <div class="col col-3">{{ $row->addStoToSto->item_size }}</div>
                                        <div class="col col-3">Add. Fee</div>
                                        <div class="col col-3">
                                            {{ $row->stock_dpl }}
                                            <input type="text" name="addStoId[]" value="{{ $row->addStoToSto->id }}" hidden>
                                            <input type="text" name="addStoDepl[]" value="{{ $row->stock_dpl }}" hidden>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                           
                        </div>

                        <div class="col-md-6">
                    
                            <h4>Additional Equipment:</h4>
                            <div class="row cust-underline">
                                <div class="col col-3">Name</div>
                                <div class="col col-3">Size</div>
                                <div class="col col-3">Add. Fee</div>
                                <div class="col col-3">Qty. Used</div>
                            </div>
                            @if($addEqData->isEmpty())
                                <div class="row mt-1 justify-content-center">
                                    <div class="col col-auto">No additional equipment.</div>
                                </div>
                            @else
                                @foreach($addEqData as $row)
                                    <div class="row mt-1 cust-underline-secondary">
                                        <div class="col col-3">{{ $row->addEqToEq->eq_name }}</div>
                                        <div class="col col-3">{{ $row->addEqToEq->eq_size }}</div>
                                        <div class="col col-3">Add. Fee</div>
                                        <div class="col col-3">
                                            {{ $row->eq_dpl }}
                                            <input type="text" name="addEqId[]" value="{{ $row->addEqToEq->id }}" hidden>
                                            <input type="text" name="addEqDepl[]" value="{{ $row->eq_dpl }}" hidden>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            
                        </div>
                    </div>


                    {{-- Package Items and Equipment --}}
                    <div class="row mt-4 cust-white-bg">
                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Package Items and Equipment:</h5>
                        </div>
                        <div class="col-md-6">
                            <h4>Item:</h4>
                            <div class="row cust-underline">
                                <div class="col col-3">Name</div>
                                <div class="col col-3">Size</div>
                                <div class="col col-3">Qty. Used</div>
                                <div class="col col-3">Qty. Depl.</div>
                            </div>
                            @php
                                $oldStoDepl = old('stoDepl', ['']);
                            @endphp
                            @foreach($pkgStoData as $row)
                                <div class="row mt-1 cust-underline-secondary">
                                    <div class="col col-3">{{ $row->pkgStoToSto->item_name }}</div>
                                    <div class="col col-3">{{ $row->pkgStoToSto->item_size }}</div>
                                    <div class="col col-3">{{ $row->stock_used }}</div>
                                    <div class="col col-3">{{ $row->pkgStoToSto->id }}</div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-6">
                    
                            <h4>Equipment:</h4>
                            <div class="row cust-underline">
                                <div class="col col-3">Name</div>
                                <div class="col col-3">Size</div>
                                <div class="col col-3">Qty. Used</div>
                                <div class="col col-3">Qty. Depl.</div>
                            </div>
                            @foreach($tempEqData as $row)
                                <div class="row mt-1 cust-underline-secondary">
                                    <div class="col col-3">{{ $row->tempEqToPkgEq->pkgEqToEq->eq_name }}</div>
                                    <div class="col col-3">{{ $row->tempEqToPkgEq->pkgEqToEq->eq_size }}</div>
                                    <div class="col col-3">{{ $row->tempEqToPkgEq->eq_used }}</div>
                                    <div class="col col-3">{{ $row->eq_dpl_qty }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    
                </form>
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
            
        </div>
        
    </div>
@endsection