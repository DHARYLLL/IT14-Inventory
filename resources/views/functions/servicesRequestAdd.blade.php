@extends('layouts.layout')
@section('title', 'Create Service Request')

@section('content')
@section('head', 'Create Services Request')

{{-- Card Form Container --}}
    <div class="cust-add-form">
        {{--
        <div class="card bg-white border-0 rounded-3">
            <div class="card-body">
                --}}

                
                    <form action="{{ route('Service-Request.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col col-auto">
                                <h4 class="cust-sub-title mb-4">Service Request Form</h4>
                            </div>
                        </div>
                        {{-- Client Info --}}
                        <div class="row mt-4 cust-white-bg">
                            <div class="col-md-12">
                                <h5 class="cust-sub-title">Client Info:</h5>
                            </div>
                            <div class="col-md-4">
                                <label for="clientName" class="form-label">Client Name <span class="text-danger">*</span></label>
                                <input type="text" name="clientName" id="clientName" class="form-control"
                                    placeholder="Enter Full Name" value="{{ old('clientName') }}">
                                @error('clientName')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                <input type="text" name="address" class="form-control"
                                    value="{{ old('address') }}">
                                @error('address')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="clientConNum" class="form-label">Contact Number <span class="text-danger">*</span></label>
                                <input type="text" name="clientConNum" id="clientConNum" class="form-control" placeholder="09..."
                                    value="{{ old('clientConNum') }}">
                                @error('clientConNum')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Services --}}
                        <div class="row mt-4 cust-white-bg">
                            <div class="col-md-12">
                                <h5 class="cust-sub-title">Services: <span class="text-danger">*</span></h5>
                            </div>
                            <div class="col-md-5">
                                <label for="embalm" class="form-label">Embalm</label>
                                <select name="embalm" id="embalm" class="form-select" onchange="PriceEmbalm()">
                                    <option value="">Select Embalmer</option>
                                    @foreach ($embalmData as $data)
                                        <option value="{{ $data->id }},{{ $data->prep_price }}" {{ old('embalm') == $data->id.','. $data->prep_price ? 'selected' : '' }}>
                                            {{ $data->embalmer_name }} | Price: ₱{{ $data->prep_price }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('embalm')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-5">
                                <label for="vehicle" class="form-label">Vehicle:</label>
                                <select name="vehicle" id="vehicle" class="form-select" onchange="PriceVeh()">
                                    @if($vehData->isEmpty())
                                        <option value="">No Driver Available</option>
                                    @else
                                        <option value="">None</option>
                                        @foreach ($vehData as $data)
                                            <option value="{{ $data->id }},{{ $data->veh_price }}" {{ old('vehicle') == $data->id.','.$data->veh_price ? 'selected' : '' }}>
                                                {{ $data->driver_name }} | Price: ₱{{ $data->veh_price }}
                                            </option>
                                        @endforeach
                                    @endif
                    
                                </select>
                                @error('vehicle')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                    
                            </div>
                        </div>
                        {{-- Dates --}}
                        <div class="row mt-4 cust-white-bg">
                            <div class="col-md-12">
                                <h5 class="cust-sub-title">Date:</h5>
                            </div>
                            <div class="col-md-3">
                                <label for="svcDate" class="form-label">Service Date <span class="text-danger">*</span></label>
                                <input type="date" name="svcDate" class="form-control"
                                    value="{{ old('svcDate') }}">
                                @error('svcDate')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            {{--
                            <div class="col-md-3">
                                <label for="burrDate" class="form-label">Burial Date</label>
                                <input type="date" name="burrDate" class="form-control"
                                    value="{{ old('burrDate') }}">
                                @error('burrDate')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-3">
                                <label for="burialTime" class="form-label">Burial Time</label>
                                <input type="time" class="cust-time" name="burialTime" value="{{ old('burialTime') }}">
                                @error('burialTime')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            --}}
                            <div class="col-md-3">
                                <label for="embalmTime" class="form-label">Embalm Time</label>
                                <input type="time" class="cust-time" name="embalmTime" value="{{ old('embalmTime') }}">
                                @error('embalmTime')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Locations --}}
                        <div class="row mt-4 cust-white-bg">
                            <div class="col-md-12">
                                <h5 class="cust-sub-title">Location:</h5>
                            </div>
                            <div class="col-md-4">
                                <label for="burialLoc" class="form-label">Burial Location</label>
                                <input type="text" name="burialLoc" id="burialLoc" class="form-control"
                                    value="{{ old('burialLoc') }}">
                                @error('burialLoc')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Payment --}}
                        <div class="row mt-4 cust-white-bg">
                            <div class="col-md-12">
                                <h5 class="cust-sub-title">Payment:</h5>
                            </div>
                            <div class="col-md-3">
                                <label for="payment" class="form-label">Total</label>
                                <input type="text" class="form-control" id="totalPayment" name="total" value="{{ old('total') }}">
                                @error('total')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                    
                                <input type="text" id="setEmbalmPrice" name="setEmbalmPrice" readonly value="{{ old('setEmbalmPrice') }}" hidden>
                                <input type="text" id="setVehPrice" name="setVehPrice" readonly value="{{ old('setVehPrice') }}" hidden>
                                <input type="text" id="setEmbalmId" readonly name="setEmbalmId" value="{{ old('setEmbalmId') }}" hidden>
                                <input type="text" id="setVehId" readonly name="setVehId" value="{{ old('setVehId') }}" hidden>
                            </div>
                            <div class="col-md-3">
                                <label for="payment" class="form-label">Down Payment</label>
                                <input type="text" class="form-control" name="payment" value="{{ old('payment', 0) }}">
                                @error('payment')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Custom Script for Payment --}}
                        <script>
                            function PriceEmbalm(){
                                var getEmbalm = document.getElementById('embalm');
                                var getChap = document.getElementById('setVehPrice').value;
                                var pkgData = getEmbalm.options[getEmbalm.selectedIndex].value;
                                let forId = pkgData.slice(0, pkgData.indexOf(","));
                                let forPrice = pkgData.slice(pkgData.indexOf(",") + 1);
                                document.getElementById('setEmbalmPrice').value = forPrice;
                                document.getElementById('setEmbalmId').value = forId;
                                document.getElementById('totalPayment').value = Number(forPrice) + Number(getChap);
                            }
                            function PriceVeh() {
                                var getVeh = document.getElementById('vehicle');
                                var getPkg = document.getElementById('setEmbalmPrice').value;
                                var chapData = getVeh.options[getVeh.selectedIndex].value;
                                let forId = chapData.slice(0, chapData.indexOf(","));
                                let forPrice = chapData.slice(chapData.indexOf(",") + 1);
                                document.getElementById('setVehPrice').value = forPrice;
                                document.getElementById('setVehId').value = forId;
                                document.getElementById('totalPayment').value = Number(forPrice) + Number(getPkg);
                            }
                        </script>
                    
                        {{-- Submit --}}
                        <div class="row justify-content-end mt-4">
                            {{-- Display Error --}}
                            <div class="col col-auto">
                                @session('promt')
                                    <div class="text-danger small mt-1">{{ $value }}</div>
                                @endsession
                            </div>
                            <div class="col col-auto">
                                <a href="{{ route('Job-Order.index') }}" class="cust-btn cust-btn-secondary"><i
                                    class="bi bi-arrow-left"></i>
                                    <span>Cancel</span>
                                </a>
                            </div>
                            {{-- Submit Button --}}
                            <div class="col col-auto ">
                    
                                <button type="submit" class="cust-btn cust-btn-primary"><i class="bi bi-send"></i>
                                    Submit Request
                                </button>
                    
                            </div>
                        </div>
                    
                    </form>
                
            {{--
            </div>
        </div>
        --}}
    </div>

@endsection