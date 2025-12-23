@extends('layouts.layout')
@section('title', 'Package')

@section('content')
    @section('head', 'Package')

    <div class="cust-add-form">
        
        <form action="{{ route('Package.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col col-auto">
                    <h4 class="form-title">Add New Package</h4>
                </div>
            </div>

            <div class="row mt-4 cust-white-bg">
                <div class="col-md-12">
                    <h5 class="cust-sub-title">Package details:</h5>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold text-dark">Package Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter package name" name="pkg_name"
                        value="{{ old('pkg_name') }}">
                    @error('pkg_name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-dark">Package Price <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">₱</span>
                        <input type="text" class="form-control" placeholder="Package Price" name="pkgPrice"
                            value="{{ old('pkgPrice') }}">
                    </div>
                    @error('pkgPrice')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row mt-4 cust-white-bg">
                <div class="col-md-12">
                    <h5 class="cust-sub-title">Assign Stock:</h5>
                </div>
                {{-- Stock --}}
                <div class="col-md-12 mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <div class="d-flex gap-2 align-items-center">
                        <select name="" id="stock" class="form-select w-50" onchange="getQtySto()">
                            <option value="">Select Stock</option>
                            @foreach ($stoData as $data)
                                <option value="{{ $data->id }},{{ $data->item_name }}:{{ $data->item_size }};{{ $data->item_qty }}">
                                    {{ $data->item_name }} | {{ $data->item_size }}
                                </option>
                            @endforeach
                        </select>
                        <input type="text" id="sto" class="form-control w-25" readonly placeholder="Available" hidden>
                
                        <button type="button" id="add_sto" onclick="checkInputSto()" class="cust-btn cust-btn-primary"><i
                                class="bi bi-plus-circle"></i>
                            Add Stock
                        </button>
                    </div>
                </div>
                

                <div id="addStock" class="col-md-12 cust-max-300">
                        
                    @php
                        $oldItems = old('itemName', ['']);
                        $oldQtys = old('stockQty', ['']);
                        $oldStock = old('stock', ['']);
                        $oldStoSize = old('stoSize', ['']);
                        $oldStoAvail = old('stoAvail', ['']);
                    @endphp
                    @if(!empty(array_filter($oldItems)))
                        @foreach($oldItems as $i => $item)
                            <div class="row bg-light rounded-3 shadow-sm mb-4 added-item">
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold text-secondary">Stock</label>
                                    <input type="text" class="form-control" name="itemName[]" value="{{ $item }}" readonly>
                                    <input type="text" name="stock[]" value="{{ $oldStock[$i] ?? '' }}" hidden>
                                    @error("itemName.$i")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold text-secondary">Size</label>
                                    <input type="text" class="form-control" name="stoSize[]" value="{{ $oldStoSize[$i] ?? '' }}" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold text-secondary">In Stock</label>
                                    <input type="text" class="form-control" name="stoAvail[]" value="{{ $oldStoAvail[$i] ?? '' }}" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold text-secondary">Assigned Qty. <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="stockQty[]" value="{{ $oldQtys[$i] ?? '' }}">
                                    @error("stockQty.$i")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold text-secondary">Remove</label>
                                    <button type="button" class="btn btn-outline-danger w-100 remove-sto"><i class="bi bi-x-circle"></i> </button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="row mt-4 cust-white-bg">
                <div class="col-md-12">
                    <h5 class="cust-sub-title">Assign Equipment:</h5>
                </div>

                {{-- Equipment --}}
                <div class="col-md-12 mb-3">
                    <label for="equipment" class="form-label">Equipment</label>
                    <div class="d-flex gap-2 align-items-center">
                        <select name="" id="equipment" class="form-select w-50" onchange="getQty()">
                            <option value="">Select Equipment</option>
                            @foreach ($eqData as $data)
                                <option value="{{ $data->id }},{{ $data->eq_name }}:{{ $data->eq_size }};{{ $data->eq_available }}">
                                    {{ $data->eq_name }} | {{ $data->eq_size }}
                                </option>
                            @endforeach
                        </select>
                        <input type="text" id="avail" class="form-control w-25" readonly placeholder="Available" hidden>
                        <button type="button" id="add_eq" onclick="checkInputEq()" class="cust-btn cust-btn-primary"><i
                                class="bi bi-plus-circle"></i>
                            Add Equipment
                        </button>
                    </div>
                </div>

                <div id="addEquipment" class="col-md-12 cust-max-300">
                    @php
                        $oldEq = old('eqName', ['']);
                        $oldEqQtys = old('eqQty', ['']);
                        $oldEqId = old('equipment', ['']);
                        $oldEqSize = old('eqSize', ['']);
                        $oldEqAvail = old('eqAvail', ['']);
                    @endphp
                    @if(!empty(array_filter($oldEq)))
                        @foreach($oldEq as $i => $item)
                            <div class="row bg-light rounded-3 shadow-sm mb-4 added-item">
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold text-secondary">Equipment</label>
                                    <input type="text" class="form-control" name="eqName[]" value="{{ $item }}" readonly>
                                    <input type="text" name="equipment[]" value="{{ $oldEqId[$i] ?? '' }}" hidden>
                                    @error("eqName.$i")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold text-secondary">Size</label>
                                    <input type="text" class="form-control" name="eqSize[]" value="{{ $oldEqSize[$i] ?? '' }}" readonly>
                                    @error("eqSize.$i")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold text-secondary">In Stock</label>
                                    <input type="text" class="form-control" name="eqAvail[]" value="{{ $oldEqAvail[$i] ?? '' }}" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold text-secondary">Assigned Qty. <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="eqQty[]" value="{{ $oldEqQtys[$i] ?? '' }}">
                                    @error("eqQty.$i")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold text-secondary">Remove</label>
                                    <button type="button" class="btn btn-outline-danger w-100 remove-eq"><i class="bi bi-x-circle"></i></button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

            </div>

            <div class="row h-10 justify-content-end align-items-center mt-4">
                {{-- Display Error --}}
                <div class="col col-auto">
                        @session('emptyEq')
                            <div class="text-danger small mt-1">{{ $value }}</div>
                    @endsession
                </div>

                <div class="col col-auto">
                    <a href="{{ route('Package.index') }}" class="cust-btn cust-btn-secondary d-flex align-items-center gap-2">
                        <i class="bi bi-arrow-left"></i> <span>Cancel</span>
                    </a>
                </div>

                {{-- Submit Button --}}
                <div class="col col-auto ">
                
                    <button type="submit" class="cust-btn cust-btn-primary"><i class="bi bi-send px-2"></i>Add Package</button>
                
                </div>
            </div>
        </form>

    </div>
@endsection
