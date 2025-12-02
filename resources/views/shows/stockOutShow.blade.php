@extends('layouts.layout')
@section('title', 'Service Request')

@section('content')
@section('head', 'Show Services Request')

    {{-- table --}}
    <div class="cust-h">
        <div class="row cust-h-100 p-3">
            
            <div class="col col-12 h-100 overflow-auto">


                <div class="row cust-white-bg">
                    <div class="col-md-12 mb-2">
                        <h5 class="cust-sub-title">Stock-out Details:</h5>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Reason</label>
                        <p>{{ $soData->reason }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Stock-out Date:</label>
                        <p>{{ $soData->so_date }}</p>
                    </div>
                    
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="col-md-12 cust-white-bg mx-1">

                                    <div class="row cust-underline mx-0">
                                        <div class="col-md-5">Item Name</div>
                                        <div class="col-md-5">Item Size </div>
                                        <div class="col-md-2">Qty.</div>
                                    </div>

                                    @if($soStoData->isEmpty())
                                        <div class="row mt-1 mx-0">
                                            <div class="col-md-12">No stock-out item.</div>
                                        </div>
                                    @else
                                        @foreach($soStoData as $row)
                                            <div class="row mt-1 mx-0 cust-underline-secondary">
                                                <div class="col-md-5">{{ $row->soiToSto->item_name }}</div>
                                                <div class="col-md-5">{{ $row->soiToSto->item_size }}</div>
                                                <div class="col-md-2">{{ $row->so_qty }}</div>
                                            </div>
                                        @endforeach
                                    @endif


                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="col-md-12 cust-white-bg mx-1">

                                    <div class="row cust-underline mx-0">
                                        <div class="col-md-5">Equipment Name</div>
                                        <div class="col-md-5">Equipment Size </div>
                                        <div class="col-md-2">Qty.</div>
                                    </div>

                                    @if($soEqData->isEmpty())
                                        <div class="row mt-1 mx-0">
                                            <div class="col-md-12">No stock-out equipment.</div>
                                        </div>
                                    @else
                                        @foreach($soEqData as $row)
                                            <div class="row mt-1 mx-0 cust-underline-secondary">
                                                <div class="col-md-5">{{ $row->soeToEq->eq_name }}</div>
                                                <div class="col-md-5">{{ $row->soeToEq->eq_size }}</div>
                                                <div class="col-md-2">{{ $row->so_qty }}</div>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                            
                        </div>
                    </div>

                    

                    

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
                <a href="{{ route('Stock-Out.index') }}" class="cust-btn cust-btn-secondary"><i
                    class="bi bi-arrow-left"></i>
                    <span>Back</span>
                </a>
            </div>
        </div>
    </div>
@endsection