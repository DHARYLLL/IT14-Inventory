@extends('layouts.layout')
@section('title', 'Create Service Request')

@section('content')
@section('head', 'Create Services Request')

{{-- Card Form Container --}}
    <div class="cust-add-form">

        <form action="{{ route('Service-Request.store') }}" method="post">
            @csrf
            {{-- Display error --}}
            @session('promt')
                <div class="row mb-4 cust-error-msg">
                    <div class="col-md-12">
                        <div class="text-danger"><p>{{ $value }}</p></div>
                    </div>
                </div>
            @endsession

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
                    <label for="cliFname" class="form-label">First name <span class="text-danger">*</span></label>
                    <input type="text" name="cliFname" id="cliFname" class="form-control"
                        placeholder="Enter Full Name" value="{{ old('cliFname') }}">
                    @error('cliFname')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="cliMname" class="form-label">Middle name / initial <span class="text-danger">*</span></label>
                    <input type="text" name="cliMname" id="cliMname" class="form-control"
                        placeholder="Enter Full Name" value="{{ old('cliMname') }}">
                    @error('cliMname')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="cliLname" class="form-label">Last name <span class="text-danger">*</span></label>
                    <input type="text" name="cliLname" id="cliLname" class="form-control"
                        placeholder="Enter Full Name" value="{{ old('cliLname') }}">
                    @error('cliLname')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="w-100 mb-2"></div>

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
                    <label for="svcDate" class="form-label" id="lbSvcDate">Service Date</label>
                    <input type="date" name="svcDate" class="form-control" id="view-svcDate" disabled
                        value="{{ old('svcDate') }}">
                    @error('svcDate')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-3">
                    <label for="burrDate" class="form-label" id="lbBurDate">Burial Date <span class="text-danger">*</span></label>
                    <input type="date" name="burrDate" class="form-control" id="view-burDate" disabled
                        value="{{ old('burrDate') }}">
                    @error('burrDate')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-3">
                    <label for="burialTime" class="form-label" id="lbBurTime">Burial Time</label>
                    <input type="time" class="cust-time" name="burialTime" value="{{ old('burialTime') }}" id="view-burTime" disabled>
                    @error('burialTime')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
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
                    <div class="input-group">
                        <span class="input-group-text">₱</span>
                        <input type="text" class="form-control" id="totalPayment" name="total" value="{{ old('total') }}" readonly>
                    </div>
                    @error('total')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
        
                    <input type="text" id="setEmbalmPrice" name="setEmbalmPrice" readonly value="{{ old('setEmbalmPrice') }}" hidden>
                    <input type="text" id="setVehPrice" name="setVehPrice" readonly value="{{ old('setVehPrice') }}" hidden>
                    <input type="text" id="setEmbalmId" readonly name="setEmbalmId" value="{{ old('setEmbalmId') }}" hidden>
                    <input type="text" id="setVehId" readonly name="setVehId" value="{{ old('setVehId') }}" hidden>
                </div>
                <div class="col-md-3">
                    <label for="payment" class="form-label">Down Payment <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">₱</span>
                        <input type="text" class="form-control" name="payment" value="{{ old('payment', 1000) }}">
                        @error('payment')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            {{-- Custom Script for Payment --}}
            <script>
                var getEmbalm = document.getElementById('embalm');
                var pkgData = getEmbalm.options[getEmbalm.selectedIndex].value;
                const showSvcDate = document.getElementById('view-svcDate');
                const addReqSvcDate = document.getElementById('lbSvcDate');
                if (pkgData) {
                    showSvcDate.disabled = false;
                    addReqSvcDate.innerHTML = 'Service Date <span class="text-danger">*</span>';
                } else {
                    showSvcDate.disabled = true;
                    addReqSvcDate.innerHTML = 'Service Date';
                }
                var getVeh = document.getElementById('vehicle');
                var chapData = getVeh.options[getVeh.selectedIndex].value;
                const showBurDate = document.getElementById('view-burDate');
                const showBurTime = document.getElementById('view-burTime');
                const addReqBurDate = document.getElementById('lbBurDate');
                const addReqBurTime = document.getElementById('lbBurTime');
                if (chapData) {
                    showBurDate.disabled = false;
                    addReqBurDate.innerHTML = 'Burial Date <span class="text-danger">*</span>';
                    showBurTime.disabled = false;
                    addReqBurTime.innerHTML = 'Burial Time <span class="text-danger">*</span>';
                } else {
                    showBurDate.disabled = true;
                    addReqBurDate.innerHTML = 'Burial Date';
                    showBurTime.disabled = true;
                    addReqBurTime.innerHTML = 'Burial Time';
                }
                function PriceEmbalm(){
                    var getEmbalm = document.getElementById('embalm');
                    var getVeh = document.getElementById('setVehPrice').value;
                    var pkgData = getEmbalm.options[getEmbalm.selectedIndex].value;
                    const showSvcDate = document.getElementById('view-svcDate');
                    const addReqSvcDate = document.getElementById('lbSvcDate');
                    let forId = pkgData.slice(0, pkgData.indexOf(","));
                    let forPrice = pkgData.slice(pkgData.indexOf(",") + 1);

                    document.getElementById('setEmbalmPrice').value = forPrice;
                    document.getElementById('setEmbalmId').value = forId;
                    document.getElementById('totalPayment').value = Number(forPrice) + Number(getVeh);
                    
                    if (pkgData) {
                        showSvcDate.disabled = false;
                        addReqSvcDate.innerHTML = 'Service Date <span class="text-danger">*</span>';
                    } else {
                        showSvcDate.disabled = true;
                        addReqSvcDate.innerHTML = 'Service Date';
                    }

                    
                }
                function PriceVeh() {
                    var getVeh = document.getElementById('vehicle');
                    var getPkg = document.getElementById('setEmbalmPrice').value;
                    var chapData = getVeh.options[getVeh.selectedIndex].value;

                    const showBurDate = document.getElementById('view-burDate');
                    const showBurTime = document.getElementById('view-burTime');
                    const addReqBurDate = document.getElementById('lbBurDate');
                    const addReqBurTime = document.getElementById('lbBurTime');
                    let forId = chapData.slice(0, chapData.indexOf(","));
                    let forPrice = chapData.slice(chapData.indexOf(",") + 1);

                    document.getElementById('setVehPrice').value = forPrice;
                    document.getElementById('setVehId').value = forId;
                    document.getElementById('totalPayment').value = Number(forPrice) + Number(getPkg);

                    if (chapData) {
                        showBurDate.disabled = false;
                        addReqBurDate.innerHTML = 'Burial Date <span class="text-danger">*</span>';
                        showBurTime.disabled = false;
                        addReqBurTime.innerHTML = 'Burial Time <span class="text-danger">*</span>';
                    } else {
                        showBurDate.disabled = true;
                        addReqBurDate.innerHTML = 'Burial Date';
                        showBurTime.disabled = true;
                        addReqBurTime.innerHTML = 'Burial Time';
                    }

                    
                }
            </script>
        
            {{-- Submit --}}
            <div class="row justify-content-end mt-4">
                
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
                
    </div>

@endsection