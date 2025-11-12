@extends('layouts.layout')
@section('title', 'Purchase Order')

@section('head', 'Create Purchase Order')
@section('name', 'Staff')

@section('content')
    

    {{-- Header section --}}
    <div class="d-flex align-items-center justify-content-end p-2 mb-0 cust-h-heading">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('Purchase-Order.index') }}" class="btn btn-green d-flex align-items-center gap-2 px-3">
                <i class="bi bi-arrow-left"></i>
                <span>Cancel</span>
            </a>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="cust-h-content">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('Purchase-Order.store') }}" method="POST" id="form" class="h-100">
                    @csrf
                    <div class="cust-sticky">
                        {{-- Supplier selection + buttons --}}
                        <div class="row align-items-end mb-4">
                            <div class="col-md-6">
                                <label for="supp" class="form-label fw-semibold text-secondary">
                                    Supplier
                                </label>
                                <select class="form-select shadow-sm" name="supp" id="supp">
                                    <option selected disabled>Select supplier</option>
                                    @foreach ($supData as $supp)
                                        <option value="{{ $supp->id }}" {{ old('supp') == $supp->id ? 'selected' : '' }}>
                                            {{ $supp->id }} {{ $supp->fname }} {{ $supp->mname }} {{ $supp->lname }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('supp')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 d-flex justify-content-md-end gap-2 mt-3 mt-md-0">
                                <button class="btn btn-outline-success" type="button" id="add_new">
                                    <i class="bi bi-plus-circle"></i> Add More
                                </button>
                                <button class="btn btn-green text-white px-4" type="submit">
                                    <i class="bi bi-send"></i> Submit
                                </button>
                            </div>
                        </div>
                        {{-- ADD stock and equipment --}}
                        <div class="row">
                            <div class="col col-6">
                                <div class="row">
                                    <div class="col col-8 mb-3">
                                        <div>
                                            <select class="form-select" name="" id="select_stock">
                                                <option value="" selected disabled>Select Item</option>
                                                @foreach ($stoData as $row)
                                                    <option
                                                        value="{{ $row->item_name }},{{ $row->item_unit_price }}:{{ $row->item_size }};{{ $row->item_unit }}">
                                                        {{ $row->item_name }} | Size: {{ $row->item_size }} | Unit: {{ $row->unit }} | {{ $row->item_type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col col-4">
                                        <button class="btn btn-outline-success" type="button" onclick="setStock()">
                                            <i class="bi bi-plus-circle"></i> Add Item
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-6 mb-3">
                                <div class="row">
                                    <div class="col col-8">
                                        <div>
                                            <select class="form-select" name="" id="select_equipment">
                                                <option value="" selected disabled>Select Item</option>
                                                @foreach ($eqData as $row)
                                                    <option
                                                        value="{{ $row->eq_name }},{{ $row->eq_unit_price }}:{{ $row->eq_size }};{{ $row->eq_unit }}">
                                                        {{ $row->eq_name }} | Size: {{ $row->eq_size }} | Unit: {{ $row->eq_unit }} | {{ $row->eq_type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col col-4">
                                        <button class="btn btn-outline-success" type="button" onclick="setEquipment()">
                                            <i class="bi bi-plus-circle"></i> Add Equipment
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Dynamic input fields --}}
                    
                    <div id="pasteHere" class="mt-3">
                        @php
                            $oldItems = old('itemName', ['']);
                            $oldQtys = old('qty', ['']);
                            $oldunitPrices = old('unitPrice', ['']);
                            $oldsize = old('size', ['']);
                            $oldunit = old('unit', ['']);
                            $oldType = old('typeSelect', ['']);
                        @endphp
                        @foreach ($oldItems as $i => $item)
                            <div class="row g-2 mb-2 px-3 py-2 bg-light rounded-3 shadow-sm form-section">
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold text-secondary">Item Name</label>
                                    <input type="text" name="itemName[]" value="{{ $item }}"
                                        class="form-control shadow-sm">
                                    @error("itemName.$i")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-semibold text-secondary">Quantity</label>
                                    <input type="number" name="qty[]" value="{{ $oldQtys[$i] ?? '' }}"
                                        class="form-control shadow-sm">
                                    @error("qty.$i")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-semibold text-secondary">Unit Price</label>
                                    <input type="text" name="unitPrice[]" value="{{ $oldunitPrices[$i] ?? '' }}"
                                        class="form-control shadow-sm">
                                    @error("unitPrice.$i")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold text-secondary">Size</label>
                                    <input type="text" name="size[]" value="{{ $oldsize[$i] ?? '' }}"
                                        class="form-control shadow-sm">
                                    @error("size.$i")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold text-secondary">Unit</label>
                                    <input type="text" name="unit[]" value="{{ $oldunit[$i] ?? '' }}"
                                        class="form-control shadow-sm">
                                    @error("unit.$i")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold text-secondary">Type</label>
                                    <select name="typeSelect[]" class="form-select shadow-sm placeType">
                                        <option value="">Select Type</option>
                                        <option value="Consumable"
                                            {{ ($oldType[$i] ?? '') === 'Consumable' ? 'selected' : '' }}>Consumable
                                        </option>
                                        <option value="Non-Consumable"
                                            {{ ($oldType[$i] ?? '') === 'Non-Consumable' ? 'selected' : '' }}>
                                            Non-Consumable</option>
                                    </select>
                                    @error("typeSelect.$i")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-1 align-items-start">
                                    <label class="form-label fw-semibold text-secondary">Remove</label>
                                    <button type="button"
                                        class="btn btn-outline-danger remove-btn">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                </form>
            </div>
        </div>
    </div>


    
@endsection
