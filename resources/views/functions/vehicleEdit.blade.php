@extends('layouts.layout')
@section('title', 'Edit Vehicle')

@section('content')
    @section('head', 'Edit Driver')

    <div class="cust-full-h">

        <div class="card shadow-sm border-0 rounded-3 p-4 bg-white h-100">

            <form action="{{ route('Vehicle.update', $vehData->id) }}" method="POST" class="h-100">
                @csrf
                @method('PUT')
                {{-- Show Details --}}
                <div class="row cust-h-form justify-content-start align-items-start">
                    <div class="col-md-12 h-10">
                        <h3 class="fw-semibold text-success mb-4">Edit Driver Details</h3>
                    </div>
                    <div class="col-md-12 cust-h">

                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="cust-sub-title">Driver Info:</h4>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Driver Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="driverName" value="{{ old('driverName', $vehData->driver_name) }}">
                                @error('driverName')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Contact Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="contactNumber" value="{{ old('contactNumber', $vehData->driver_contact_number) }}">
                                @error('contactNumber')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Price <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control" name="price" value="{{ old('price', $vehData->veh_price) }}">
                                </div>
                                @error('price')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
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
                        <a href="{{ route('Personnel.index') }}" class="cust-btn cust-btn-secondary"><i
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
