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

                        <div class="col-md-6">
                            <label for="package" class="form-label">Package</label>
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
                        <div class="col-md-6">
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

                        <div class="col-md-6">
                            <label for="vehicle" class="form-label">Vehicle:</label>
                            <select name="vehicle" id="vehicle" class="form-select">
                                <option value="">None</option>

                                @foreach ($vehData as $data)
                                    <option value="{{ $data->id }}" {{ old('vehicle') == $data->id ? 'selected' : '' }}>
                                        {{ $data->driver_name }} | Model: {{ $data->veh_brand }}
                                    </option>
                                @endforeach
                        
                            </select>
                            @error('vehicle')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        
                        </div>


                        <div class="col-md-3">
                            <label for="payment" class="form-label">Total Payment</label>
                            <input type="text" class="form-control" id="totalPayment" readonly name="total" value="{{ old('total') }}">

                            <input type="text" id="setPricePkg" name="setPricePkg" readonly value="{{ old('setPricePkg') }}" hidden>
                            <input type="text" id="setPriceChap" name="setPriceChap" readonly value="{{ old('setPriceChap') }}" hidden>

                            <input type="text" id="setIdPkg" readonly name="pkgId" value="{{ old('pkgId') }}" hidden>
                            <input type="text" id="setIdChap" readonly name="chapId" value="{{ old('chapId') }}" hidden>
                        </div>
                        <div class="col-md-3">
                            <label for="payment" class="form-label">Payment</label>
                            <input type="text" class="form-control" name="payment" value="{{ old('payment') }}">
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
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Client Info:</h5>
                        </div>

                        <div class="col-md-6">
                            <label for="clientName" class="form-label">Client Name</label>
                            <input type="text" name="clientName" id="clientName" class="form-control"
                                placeholder="Enter Full Name" value="{{ old('clientName') }}">
                            @error('clientName')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="clientConNum" class="form-label">Contact Number</label>
                            <input type="text" name="clientConNum" id="clientConNum" class="form-control" placeholder="09..."
                                value="{{ old('clientConNum') }}">
                            @error('clientConNum')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>


                    {{-- Deceased Info --}}
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Deceased Info:</h5>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="" class="form-label">Name</label>
                                    <input type="text" name="decName" placeholder="Deceased Full Name" class="form-control" value="{{ old('decName') }}">
                                    @error('decName')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="form-label">Born</label>
                                    <input type="date" name="decBorn" class="form-control" value="{{ old('decBorn') }}">
                                    @error('decBorn')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="form-label">Died</label>
                                    <input type="date" name="decDied" class="form-control" value="{{ old('decDied') }}">
                                    @error('decDied')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="" class="form-label">Cause of Death</label>
                                    <input type="text" name="decCOD" class="form-control" placeholder="Deceasd Cause of Death" value="{{ old('decCOD') }}">
                                    @error('decCOD')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>


                    {{-- Dates --}}
                    <div class="row mt-3">

                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Date:</h5>
                        </div>
                        <div class="col-md-4">
                            <label for="svcDate" class="form-label">Service Date</label>
                            <input type="date" name="svcDate" class="form-control"
                                value="{{ old('svcDate') }}">
                            @error('svcDate')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <label for="timeStart" class="form-label">Start Time</label>
                            <input type="time" class="cust-time" name="timeStart" value="{{ old('timeStart') }}">
                            @error('timeStart')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            @session('promt-f-date')
                                <div class="text-danger small mt-1">{{ $value }}</div>
                            @endsession
                        </div>
                        <div class="col-md-2">
                            <label for="timeEnd" class="form-label">End Time</label>
                            <input type="time" class="cust-time" name="timeEnd" value="{{ old('timeEnd') }}">
                            @error('timeEnd')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <label for="wakeDay" class="form-label">Days of Wake</label>
                            <input type="number" class="cust-time" name="wakeDay" value="{{ old('wakeDay') }}">
                            @error('wakeDay')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    {{-- Locations --}}
                    <div class="row mt-4">

                        <div class="col-md-12">
                            <h5 class="cust-sub-title">Location:</h5>
                        </div>

                        <div class="col-md-4">
                            <label for="wakeLoc" class="form-label">Wake Location</label>
                            <input type="text" name="wakeLoc" id="wakeLoc" class="form-control" value="{{ old('wakeLoc') }}">
                            @error('wakeLoc')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
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

                    {{-- Add additional new item and equipment --}}
                    <div class="row" style="height: 500px;">

                        <div class="col-md-6 h-100 overflow-auto">
                            {{-- Stock --}}
                            <div class="col-12">
                                <label for="stock" class="form-label">Stock</label>
                                <div class="d-flex gap-2 align-items-center">
                                    <select name="" id="stock" class="form-select w-50" onchange="getQtySto()">
                                        <option value="">Select Stock</option>
                                        @foreach ($stoData as $data)
                                            <option value="{{ $data->id }},{{ $data->item_qty }}">
                                                {{ $data->id }} — {{ $data->item_name }} {{ $data->size_weight }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="text" id="sto" class="form-control w-25" readonly placeholder="Available">
                                    
                                    <button type="button" id="add_sto" onclick="checkInputSto()" class="cust-btn cust-btn-primary">Add Stock</button>
                                </div>
                            </div>

                            <div id="addStock" class="col-12 mt-3">
                            
                                @php
                                    $oldItems = old('itemName', ['']);
                                    $oldQtys = old('stockQty', ['']);
                                    $oldStock = old('stock', ['']);
                                @endphp

                                @if(!empty(array_filter($oldItems)))

                                    @foreach($oldItems as $i => $item)

                                        <div class="row g-2 align-items-start mb-2 added-item">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-secondary">Stock</label>
                                                <input type="text" class="form-control" name="itemName[]" value="{{ $item }}" readonly>
                                                <input type="text" name="stock[]" value="{{ $oldStock[$i] ?? '' }}" hidden>
                                                @error("itemName.$i")
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror 
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label fw-semibold text-secondary">Stock Qty</label>
                                                <input type="number" class="form-control" name="stockQty[]" placeholder="Stock Qty" value="{{ $oldQtys[$i] ?? '' }}">
                                                @error("stockQty.$i")
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label fw-semibold text-secondary">Remove</label>
                                                <button type="button" class="btn btn-outline-danger w-100 remove-sto">
                                                    <i class="bi bi-x-circle"></i> Remove
                                                </button>
                                            </div>
                                        </div>


                                    @endforeach

                                @endif

                            </div>

                        </div>

                        <div class="col-md-6 h-100 overflow-auto">

                            {{-- Equipment --}}
                            <div class="col-12">
                                <label for="equipment" class="form-label">Equipment</label>
                                <div class="d-flex gap-2 align-items-center">
                                    <select name="" id="equipment" class="form-select w-50" onchange="getQty()">
                                        <option value="">Select Equipment</option>
                                        @foreach ($eqData as $data)
                                            <option value="{{ $data->id }},{{ $data->eq_available }}">
                                                {{ $data->id }} — {{ $data->eq_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="text" id="avail" class="form-control w-25" readonly placeholder="Available">
                                    <button type="button" id="add_eq" onclick="checkInputEq()" class="cust-btn cust-btn-primary">Add Equipment</button>
                                </div>
                            </div>
                            <div id="addEquipment" class="col-12 mt-3">

                                @php
                                    $oldEq = old('eqName', ['']);
                                    $oldEqQtys = old('eqQty', ['']);
                                    $oldEqId = old('equipment', ['']);
                                @endphp

                                @if(!empty(array_filter($oldEq)))

                                    @foreach($oldEq as $i => $item)

                                        <div class="row g-2 align-items-start mb-2 added-item">

                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-secondary">Equipment</label>
                                                <input type="text" class="form-control" name="eqName[]" value="{{ $item }}" readonly>
                                                <input type="text" name="equipment[]" value="{{ $oldEqId[$i] ?? '' }}" hidden>
                                                @error("eqName.$i")
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label fw-semibold text-secondary">Qty</label>
                                                <input type="number" class="form-control" name="eqQty[]" placeholder="Qty" value="{{ $oldEqQtys[$i] ?? '' }}">     
                                                @error("eqQty.$i")
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label fw-semibold text-secondary">Remove</label>
                                                <button type="button" class="btn btn-outline-danger w-100 remove-eq">
                                                    <i class="bi bi-x-circle"></i> Remove
                                                </button>
                                            </div>

                                        </div>


                                    @endforeach

                                @endif


                            </div>

                        </div>

                    </div>

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
