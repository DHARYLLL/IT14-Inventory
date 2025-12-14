@extends('layouts.layout')
@section('title', 'Equipments')

@section('content')
@section('head', 'Edit Equipment')



<div class="cust-h-full h-100">

    <div class="card shadow-sm border-0 rounded-3 p-4 bg-white h-100">

        <form action="{{ route('Equipment.update', $eqData->id) }}" method="POST" class="h-100">
            @csrf
            @method('PUT')
            {{-- Show Details --}}
            <div class="row cust-h-form">
                <div class="col-md-12">
                    <h3 class="fw-semibold text-success mb-4">Edit Equipment Details</h3>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Item Name</label>
                    <input type="text" class="form-control" name="eqName" value="{{ old('eqName', $eqData->eq_name) }}">
                    @error('eqName')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Available</label>
                    <input type="text" class="form-control" value="{{ $eqData->eq_available }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Size/Unit</label>
                    <input type="text" class="form-control" name="size" value="{{ old('size', $eqData->eq_size) }}">
                    @error('size')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Item Type</label>
                    <input type="text" class="form-control" value="{{ $eqData->eq_type }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Equipment Item Limit</label>
                    <input type="number" class="form-control" name="eqLimit" value="{{ $eqData->eq_low_limit }}">
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
                    <a href="{{ route('Equipment.index') }}" class="cust-btn cust-btn-secondary"><i
                        class="bi bi-arrow-left"></i>
                        <span>Cancel</span>
                    </a>
                </div>

                {{-- Submit Button --}}
                <div class="col col-auto ">
                
                    <button type="submit" class="cust-btn cust-btn-primary"><i class="bi bi-send"></i>
                        Save Changes
                    </button>
                
                </div>
            </div>
        </form>
    </div>
</div>




@endsection
