@extends('layouts.layout')
@section('title', 'Equipments')

@section('content')
    @section('head', 'Add Services Request')
    @section('name', 'Staff')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="fw-semibold mb-0">Add Service Request</h2>
        <a href="{{ route('Service-Request.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i>
            <span>Back</span>
        </a>
    </div>

    {{-- form container --}}
    <div class="bg-white rounded border shadow-sm p-4">
        <form action="{{ route('Service-Request.store') }}" method="post" class="row g-3">
            @csrf

            {{-- Package --}}
            <div class="col-md-6">
                <label for="package" class="form-label fw-semibold">Package</label>
                <select name="package" id="package" class="form-select">
                    <option disabled selected>Select Package</option>
                    @foreach ($pkgData as $data)
                        <option value="{{ $data->id }}" {{ old('package') == $data->id ? 'selected' : '' }}>{{ $data->pkg_name }}</option>
                    @endforeach
                </select>
                @error('package')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Client name --}}
            <div class="col-md-6">
                <label for="clientName" class="form-label fw-semibold">Client Name</label>
                <input type="text" name="clientName" id="clientName" class="form-control" value="{{ old('clientName') }}">
                @error('clientName')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Contact Number --}}
            <div class="col-md-6">
                <label for="clientConNum" class="form-label fw-semibold">Contact Number</label>
                <input type="text" name="clientConNum" id="clientConNum" class="form-control" value="{{ old('clientConNum') }}">
                @error('clientConNum')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Start Date --}}
            <div class="col-md-6">
                <label for="startDate" class="form-label fw-semibold">Start Date</label>
                <input type="date" name="startDate" id="startDate" class="form-control" value="{{ old('startDate') }}">
                @error('startDate')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- End Date --}}
            <div class="col-md-6">
                <label for="endDate" class="form-label fw-semibold">End Date</label>
                <input type="date" name="endDate" id="endDate" class="form-control" value="{{ old('endDate') }}">
                @error('endDate')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Wake Location --}}
            <div class="col-md-6">
                <label for="wakeLoc" class="form-label fw-semibold">Wake Location</label>
                <input type="text" name="wakeLoc" id="wakeLoc" class="form-control" value="{{ old('wakeLoc') }}">
                @error('wakeLoc')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Church Location --}}
            <div class="col-md-6">
                <label for="churhcLoc" class="form-label fw-semibold">Church Location</label>
                <input type="text" name="churhcLoc" id="churhcLoc" class="form-control" value="{{ old('churhcLoc') }}">
                @error('churhcLoc')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Burial Location --}}
            <div class="col-md-6">
                <label for="burialLoc" class="form-label fw-semibold">Burial Location</label>
                <input type="text" name="burialLoc" id="burialLoc" class="form-control" value="{{ old('burialLoc') }}">
                @error('burialLoc')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Equipment --}}
            <div class="col-12">
                <label for="equipment" class="form-label fw-semibold">Equipment</label>
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
                    <button type="button" id="add_eq" onclick="checkInputEq()" class="btn btn-outline-success">
                        Add Equipment
                    </button>
                </div>
            </div>

            <div id="addEquipment" class="col-12 mt-2">
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
            <div class="col-12 mt-3">
                <label for="stock" class="form-label fw-semibold">Stock</label>
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
                    <button type="button" id="add_sto" onclick="checkInputSto()" class="btn btn-outline-success">
                        Add Stock
                    </button>
                </div>
            </div>

            <div id="addStock" class="col-12 mt-2">
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

            {{-- Submit Button --}}
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-success submit-btn">
                    Submit Request
                </button>
            </div>

        </form>
    </div>
@endsection
