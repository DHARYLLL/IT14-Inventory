@extends('layouts.layout')
@section('title', 'Add Service Request')

@section('content')
@section('head', 'Add Services Request')
@section('name', 'Staff')

<div class="d-flex align-items-center justify-content-end p-2 cust-h-heading">
    <a href="{{ route('Service-Request.index') }}" class="btn btn-custom d-flex align-items-center gap-2"><i
            class="bi bi-arrow-left"></i>
        <span>Back</span>
    </a>
</div>

{{-- Card Form Container --}}
    <div class="cust-h-content">
        <div class="card-container">
            <div class="card-form">
                <h4 class="form-title mb-4">Service Request Form</h4>
                <form action="{{ route('Service-Request.store') }}" method="post" class="row g-3">
                    @csrf
                    {{-- Package --}}
                    <div class="col-md-12">
                        <label for="package" class="form-label">Package</label>
                        <select name="package" id="package" class="form-select">
                            <option disabled selected>Select Package</option>
                            @foreach ($pkgData as $data)
                                <option value="{{ $data->id }}" {{ old('package') == $data->id ? 'selected' : '' }}>
                                    {{ $data->pkg_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('package')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Client Info --}}
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
                    {{-- Dates --}}
                    <div class="col-md-6">
                        <label for="startDate" class="form-label">Start Date</label>
                        <input type="date" name="startDate" id="startDate" class="form-control"
                            value="{{ old('startDate') }}">
                        @error('startDate')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="endDate" class="form-label">End Date</label>
                        <input type="date" name="endDate" id="endDate" class="form-control" value="{{ old('endDate') }}">
                        @error('endDate')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Locations --}}
                    <div class="col-md-4">
                        <label for="wakeLoc" class="form-label">Wake Location</label>
                        <input type="text" name="wakeLoc" id="wakeLoc" class="form-control" value="{{ old('wakeLoc') }}">
                        @error('wakeLoc')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="churhcLoc" class="form-label">Church Location</label>
                        <input type="text" name="churhcLoc" id="churhcLoc" class="form-control"
                            value="{{ old('churhcLoc') }}">
                        @error('churhcLoc')
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
                            @session('emptyEq')
                                    <div class="text-danger small mt-1">{{ $value }}</div>
                            @endsession
                            <button type="button" id="add_eq" onclick="checkInputEq()" class="btn btn-green"><i
                                    class="bi bi-plus-circle"></i>
                                Add Equipment
                            </button>
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

                                <div class="row g-2 align-items-end mb-2 added-item">

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
                                        <button type="button" class="btn btn-outline-danger w-100 remove-eq mt-4">
                                            <i class="bi bi-x-circle"></i> Remove
                                        </button>
                                    </div>

                                </div>


                            @endforeach

                        @endif


                    </div>
                    {{-- Stock --}}
                    <div class="col-12 mt-4">
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
                            
                            <button type="button" id="add_sto" onclick="checkInputSto()" class="btn btn-green"><i
                                    class="bi bi-plus-circle"></i>
                                Add Stock
                            </button>
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

                                <div class="row g-2 align-items-end mb-2 added-item">
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
                                        <button type="button" class="btn btn-outline-danger w-100 remove-sto mt-4">
                                            <i class="bi bi-x-circle"></i> Remove
                                        </button>
                                    </div>
                                </div>


                            @endforeach

                        @endif

                    </div>

                    {{-- Submit --}}
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-custom"><i class="bi bi-send"></i>
                            Submit Request
                        </button>
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
