@extends('layouts.layout')
@section('title', 'Stock out')

@section('content')
@section('head', 'Show Stock out')

    {{-- table --}}
    <div class="cust-add-form">

            
        <div class="h-100">

            <div class="row cust-white-bg">
                <div class="col-md-12 mb-2">
                    <h5 class="cust-sub-title">Stock-out Details:</h5>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Reason</label>
                    <p>{{ $soData->reason }}</p>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Stock-out Date:</label>
                    <p>{{ $soData->so_date }}</p>
                </div>
                @if($soData->status == 'Cancelled')
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Status</label>
                        <p>{{ $soData->status }}</p>
                    </div>
                @endif
                @if(session("empRole") == 'sadmin' || session("empRole") == 'admin')
                    
                    @if($soData->status == 'Cancelled')
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Delete</label>
                            <form action="{{ route('Stock-Out.destroy', $soData->id) }}" method="POST" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                    class="cust-btn cust-btn-danger-secondary btn-md">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Cancel Stock-out</label>
                            <a href="{{ route('Stock-Out.cancel', $soData->id) }}" class="cust-btn cust-btn-danger-secondary btn-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancel">
                                <i class="bi bi-x-circle"></i> Cancel</a>
                            
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Delete</label>
                            <form action="{{ route('Stock-Out.destroy', $soData->id) }}" method="POST" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                    class="cust-btn cust-btn-danger-secondary btn-md">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                    
                @endif
                
                
            </div>

            <div class="row mt-4 cust-white-bg">
                <div class="col-md-12">
                    <h5 class="cust-sub-title">Stock:</h5>
                </div>

                <div class="col-md-12">
                    <div class="row cust-table-header cust-table-shadow">
                        <div class="col-md-4">Item Name</div>
                        <div class="col-md-4">Item Size / Unit </div>
                        <div class="col-md-2">Quantity</div>
                        <div class="col-md-2">Net Contents</div>
                    </div>
                </div>

                <div class="col-md-12 cust-max-300 cust-table-shadow">
                    @if($soStoData->isEmpty())
                        <div class="row cust-table-content py-2">
                            <div class="col-md-12 text-center">No stock-out item.</div>
                        </div>
                    @else
                        @foreach($soStoData as $row)
                            <div class="row cust-table-content py-2">
                                <div class="col-md-4">{{ $row->soiToSto->item_name }}</div>
                                <div class="col-md-4">{{ $row->soiToSto->item_size }}</div>
                                <div class="col-md-2">{{ $row->so_qty }}</div>
                                <div class="col-md-2">{{ $row->soiToSto->item_net_content }}</div>
                            </div>
                        @endforeach
                    @endif
                </div>

            </div>

            <div class="row mt-4 cust-white-bg">
                <div class="col-md-12">
                    <h5 class="cust-sub-title">Equipemnt:</h5>
                </div>

                <div class="col-md-12">
                    <div class="row cust-table-header cust-table-shadow">
                        <div class="col-md-4">Item Name</div>
                        <div class="col-md-4">Item Size / Unit </div>
                        <div class="col-md-2">Quantity</div>
                        <div class="col-md-2">Net Contents</div>
                    </div>
                </div>
                <div class="col-md-12 cust-max-300 cust-table-shadow">
                    @if($soEqData->isEmpty())
                        <div class="row cust-table-content py-2">
                            <div class="col-md-12 text-center">No stock-out equipment.</div>
                        </div>
                    @else
                        @foreach($soEqData as $row)
                            <div class="row cust-table-content py-2">
                                <div class="col-md-4">{{ $row->soeToEq->eq_name }}</div>
                                <div class="col-md-4">{{ $row->soeToEq->eq_size }}</div>
                                <div class="col-md-2">{{ $row->so_qty }}</div>
                                <div class="col-md-2">{{ $row->soeToEq->eq_net_content }}</div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- Submit --}}
            <div class="row justify-content-end mt-4">
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
    </div>
@endsection