@extends('layouts.layout')
@section('title', 'Chapel')

@section('content')
    @section('head', 'Chapel')

    <div class="cust-full-h">

        <div class="card shadow-sm border-0 rounded-3 p-4 bg-white h-100">

            {{-- Show Details --}}
            <div class="row cust-h-form justify-content-start align-items-start">
                <div class="col-md-12 h-10">
                    <h3 class="fw-semibold text-success mb-4">Chapel Details</h3>
                </div>
                <div class="col-md-12 cust-h">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Chapel Name</label>
                            <input type="text" class="form-control" name="chapName" value="{{ old('chapName', $chapData->chap_name) }}" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Chapel Room</label>
                            <input type="text" class="form-control" name="chapRoom" value="{{ old('chapRoom', $chapData->chap_room) }}" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Chapel Price</label>
                            <input type="text" class="form-control" name="chapPrice" value="{{ old('chapPrice', $chapData->chap_price) }}" readonly>
                        </div>
                    </div>
                </div>
                
            </div>

            {{-- Submit --}}
            <div class="row justify-content-end cust-h-submit">
                {{-- Display Error --}}
                <div class="col col-auto">
                        @session('promt-s')
                        <div class="text-success small mt-1">{{ $value }}</div>
                    @endsession
                </div>

                <div class="col col-auto">
                    <a href="{{ route('Chapel.index') }}" class="cust-btn cust-btn-secondary"><i
                        class="bi bi-arrow-left"></i>
                        <span>Back</span>
                    </a>
                </div>
            </div>
            
        </div>
    </div>



@endsection
