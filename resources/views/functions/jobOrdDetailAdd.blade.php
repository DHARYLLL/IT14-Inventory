@extends('layouts.layout')
@section('title', 'Create Job Order')

@section('content')
@section('head', 'Create Job Order')

{{-- Card Form Container --}}
    <div class="cust-h-content-func">
        <div class="card bg-white border-0 rounded-3">
            <div class="card-body">
                
                <h4 class="form-title mb-4">Service Request Form</h4>
                
                <form action="{{ route('Job-Order.store') }}" method="post">
                    @csrf


                    {{-- Package --}}
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Packages and Payment:</h5>
                        </div>

                        <div class="col-md-4">
                            <label for="package" class="form-label">Package <span class="text-danger">*</span></label>
                            <select name="package" id="package" class="form-select" onchange="PricePkg()">
                                <option value="">Select Package</option>
                                @foreach ($pkgData as $data)
                                    <option value="{{ $data->id }},{{ $data->pkg_price }}" {{ old('package') == $data->id.','.$data->pkg_price ? 'selected' : '' }}>
                                        {{ $data->pkg_name }} | Price: ₱{{ $data->pkg_price }}
                                    </option>
                                @endforeach
                            </select>
                            @error('package')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="vehicle" class="form-label">Vehicle <span class="text-danger">*</span></label>
                            <select name="vehicle" id="vehicle" class="form-select" >
                                <option value="">None</option>

                                @foreach ($vehData as $data)
                                    <option value="{{ $data->id }}" {{ old('vehicle') == $data->id ? 'selected' : '' }}>
                                        {{ $data->driver_name }} | {{ $data->driver_contact_number }}
                                    </option>
                                @endforeach
                        
                            </select>
                            @error('vehicle')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        
                        </div>
                        <div class="col-md-4">
                            <label for="embalm" class="form-label">Embalmer <span class="text-danger">*</span></label>
                            <select name="embalm" id="embalm" class="form-select" >
                                <option value="">None</option>

                                @foreach ($embalmData as $data)
                                    <option value="{{ $data->id }}" {{ old('embalm') == $data->id ? 'selected' : '' }}>
                                        {{ $data->embalmer_name }}
                                    </option>
                                @endforeach
                        
                            </select>
                            @error('embalm')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        
                        </div>

                        <div class="col-md-4">
                            <label for="chapel" class="form-label">Chapel</label>
                            <select name="chapel" id="chapel" class="form-select" onchange="PriceChap()">
                                <option value="">None</option>

                                @foreach ($chapData as $data)
                                    <option value="{{ $data->id }},{{ $data->chap_price }}" {{ old('chapel') == $data->id.','.$data->chap_price ? 'selected' : '' }}>
                                        {{ $data->chap_name }} - Room {{ $data->chap_room }} | Price: ₱{{ $data->chap_price }}
                                    </option>
                                @endforeach
                        
                            </select>
                            
                        
                        </div>


                        <div class="w-100 mb-2"></div>

                        <div class="col-md-4">
                            <label for="payment" class="form-label">Total Payment</label>
                            <input type="text" class="form-control" id="totalPayment" readonly name="total" value="{{ old('total') }}">

                            <input type="text" id="setPricePkg" name="setPricePkg" readonly value="{{ old('setPricePkg') }}" hidden>
                            <input type="text" id="setPriceChap" name="setPriceChap" readonly value="{{ old('setPriceChap') }}" hidden>

                            <input type="text" id="setIdPkg" readonly name="pkgId" value="{{ old('pkgId') }}" hidden>
                            <input type="text" id="setIdChap" readonly name="chapId" value="{{ old('chapId') }}" hidden>
                        </div>
                        <div class="col-md-4">
                            <label for="payment" class="form-label">Payment <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="payment" value="{{ old('payment', 0) }}">
                            @error('payment')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    {{-- Custom Script for Payment --}}
                    <script>
                        function PricePkg(){
                            var getPkg = document.getElementById('package');

                            var getChap = document.getElementById('setPriceChap').value;                    

                            var pkgData = getPkg.options[getPkg.selectedIndex].value;
                            let forId = pkgData.slice(0, pkgData.indexOf(","));
                            let forPrice = pkgData.slice(pkgData.indexOf(",") + 1);

                            document.getElementById('setPricePkg').value = forPrice;
                            document.getElementById('setIdPkg').value = forId;
                            document.getElementById('totalPayment').value = Number(forPrice) + Number(getChap);
                        }

                        function PriceChap() {
                            var getChap = document.getElementById('chapel');

                            var getPkg = document.getElementById('setPricePkg').value;

                            var chapData = getChap.options[getChap.selectedIndex].value;
                            let forId = chapData.slice(0, chapData.indexOf(","));
                            let forPrice = chapData.slice(chapData.indexOf(",") + 1);

                            document.getElementById('setPriceChap').value = forPrice;
                            document.getElementById('setIdChap').value = forId;
                            document.getElementById('totalPayment').value = Number(forPrice) + Number(getPkg);
                        }

                    </script>



                    {{-- Client Info --}}
                    <div class="row mt-4">
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


                    {{-- Deceased Info --}}
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Deceased Info:</h5>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="decName" placeholder="Deceased Full Name" class="form-control" value="{{ old('decName') }}">
                                    @error('decName')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="form-label">Born <span class="text-danger">*</span></label>
                                    <input type="date" name="decBorn" class="form-control" value="{{ old('decBorn') }}">
                                    @error('decBorn')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="form-label">Died <span class="text-danger">*</span></label>
                                    <input type="date" name="decDied" class="form-control" value="{{ old('decDied') }}">
                                    @error('decDied')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                
                            </div>
                        </div>

                    </div>


                    {{-- Dates --}}
                    <div class="row mt-4">

                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Date:</h5>
                        </div>
                        <div class="col-md-4">
                            <label for="svcDate" class="form-label">Service Date <span class="text-danger">*</span></label>
                            <input type="date" name="svcDate" class="form-control"
                                value="{{ old('svcDate') }}">
                            @error('svcDate')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="w-100 mb-2"></div>

                        <div class="col-md-4">
                            <label for="wakeDay" class="form-label">Days of Wake <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="wakeDay" value="{{ old('wakeDay', '9') }}">
                            @error('wakeDay')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="burialTime" class="form-label">Burial Time</label>
                            <input type="time" class="cust-time" name="burialTime" value="{{ old('burialTime') }}">
                            @error('burialTime')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="embalmTime" class="form-label">Embalm Time</label>
                            <input type="time" class="cust-time" name="embalmTime" value="{{ old('embalmTime') }}">
                            @error('embalmTime')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            @session('promt-f-date')
                                <div class="text-danger small mt-1">{{ $value }}</div>
                            @endsession
                        </div>          

                    </div>


                    {{-- Locations --}}
                    <div class="row mt-4">

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

                    {{-- Submit --}}
                    <div class="row justify-content-end mt-4">
                        {{-- Display Error --}}
                        <div class="col col-auto">
                            @session('promt-f')
                                <div class="text-danger small mt-1">{{ $value }}</div>
                            @endsession
                             @session('promt-s')
                                <div class="text-success small mt-1">{{ $value }}</div>
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
            </div>
        </div>
    </div>

@endsection

{{-- Inline styling for this file  
        SAGDAI SA NI IDELETE RA KUNG NA BALHIN NA NINYO HAHAHAH --}}
<style>
.card-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.card-form {
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid #e9ecef;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    padding: 40px;
    width: 100%;
    max-width: 1000px;
}

.form-title {
    font-size: 1.6rem;
    font-weight: 700;
    color: #333;
    border-bottom: 3px solid #60BF4F;
    display: inline-block;
    padding-bottom: 6px;
}

.btn-custom {
    background-color: #60BF4F;
    color: white;
    font-weight: 600;
    border-radius: 10px;
    padding: 10px 20px;
    border: none;
    transition: 0.2s ease;
}

.btn-custom:hover {
    background-color: #4ca63d;
    box-shadow: 0 4px 10px rgba(96, 191, 79, 0.3);
}

.btn-custom-outline {
    border: 1px solid #60BF4F;
    color: #60BF4F;
    border-radius: 10px;
    padding: 8px 18px;
    font-weight: 600;
    background-color: transparent;
    transition: 0.2s ease;
}

.btn-custom-outline:hover {
    background-color: #60BF4F;
    color: white;
}

.form-label {
    font-weight: 600;
    color: #333;
}

.form-control,
.form-select {
    border-radius: 10px;
    border: 1px solid #dee2e6;
    box-shadow: none;
}

.added-item {
    background: #f8fdf8;
    border: 1px solid #d9f3d9;
    padding: 12px 15px;
    border-radius: 10px;
}
</style>
