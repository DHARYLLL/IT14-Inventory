@extends('layouts.layout')
@section('title', 'Vehicle')

@section('content')
    @section('head', 'Driver')

    <div class="cust-full-h">

        <div class="card shadow-sm border-0 rounded-3 p-4 bg-white h-100">

            <div class="row cust-h-form justify-content-start align-items-start">
                <div class="col-md-12 h-10">
                    <h3 class="fw-semibold text-success mb-4">Driver Details</h3>
                </div>
                <div class="col-md-12 cust-h">

                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="cust-sub-title">Driver Info:</h4>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Driver Name</label>
                            <input type="text" class="form-control" name="driverName" value="{{ old('driverName', $vehData->driver_name) }}" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Contact Number</label>
                            <input type="text" class="form-control" name="contactNumber" value="{{ old('contactNumber', $vehData->driver_contact_number) }}" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Price</label>
                            <input type="text" class="form-control" name="price" value="{{ old('price', $vehData->veh_price) }}" readonly>
                        </div>
                        
                    </div>

                </div>
                
            </div>

            {{-- Submit --}}
            <div class="row justify-content-end cust-h-submit">

                <div class="col col-auto">
                    <a href="{{ route('Personnel.index') }}" class="cust-btn cust-btn-secondary"><i
                        class="bi bi-arrow-left"></i>
                        <span>Back</span>
                    </a>
                </div>
            </div>
            
        </div>
    </div>

@endsection
