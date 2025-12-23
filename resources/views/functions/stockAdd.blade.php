@extends('layouts.layout')
@section('title', 'Stock')

@section('content')

@section('head', 'Stocks')

<div class="cust-h-full h-100">

    <div class="card shadow-sm border-0 rounded-3 p-4 bg-white h-100">

        <form action="{{ route('Stock.store') }}" method="POST" class="h-100">
            @csrf

            <div class="row cust-h-form">
                <div class="col col-12">
                    <h3 class="fw-semibold text-success">Add Stock Details</h3>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Item Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="itemName" value="{{ old('itemName') }}">
                    @error('itemName')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Size/Unit <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="size" value="{{ old('size') }}">
                    @error('size')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Item Type</label>
                    <input type="text" class="form-control" value="Consumable" readonly>
                </div>

                <div class="w-100"></div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Item Quantity <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="itemQty" value="{{ old('itemQty', 0) }}">
                    @error('itemQty')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Net Content <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="itemQtySet" value="{{ old('itemQtySet', 1) }}">
                    @error('itemQtySet')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Low Item Limit Quantity <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="itemLimit" value="{{ old('itemLimit', 10) }}">
                    @error('itemLimit')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Submit --}}
            <div class="row justify-content-end cust-h-submit">
                {{-- Display Error --}}
                <div class="col col-auto">
                    @session('promt')
                        <div class="text-success small mt-1">{{ $value }}</div>
                    @endsession
                    @session('promt-f')
                        <div class="text-danger small mt-1">{{ $value }}</div>
                    @endsession
                </div>

                <div class="col col-auto">
                    <a href="{{ route('Stock.index') }}" class="cust-btn cust-btn-secondary"><i
                        class="bi bi-arrow-left"></i>
                        <span>Cancel</span>
                    </a>
                </div>

                {{-- Submit Button --}}
                <div class="col col-auto ">
                
                    <button type="submit" class="cust-btn cust-btn-primary">
                        <i class="bi bi-plus-lg"></i> Add
                    </button>
                
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
