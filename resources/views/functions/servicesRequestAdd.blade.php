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
                <option value="">Select Package</option>
                @foreach ($pkgData as $data)
                    <option value="{{ $data->id }}">{{ $data->pkg_name }}</option>
                @endforeach
            </select>
            @error('package')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Start Date --}}
        <div class="col-md-6">
            <label for="startDate" class="form-label fw-semibold">Start Date</label>
            <input type="date" name="startDate" id="startDate" class="form-control">
            @error('startDate')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- End Date --}}
        <div class="col-md-6">
            <label for="endDate" class="form-label fw-semibold">End Date</label>
            <input type="date" name="endDate" id="endDate" class="form-control">
            @error('endDate')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Wake Location --}}
        <div class="col-md-6">
            <label for="wakeLoc" class="form-label fw-semibold">Wake Location</label>
            <input type="text" name="wakeLoc" id="wakeLoc" class="form-control">
            @error('wakeLoc')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Church Location --}}
        <div class="col-md-6">
            <label for="churhcLoc" class="form-label fw-semibold">Church Location</label>
            <input type="text" name="churhcLoc" id="churhcLoc" class="form-control">
            @error('churhcLoc')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Burial Location --}}
        <div class="col-md-6">
            <label for="burialLoc" class="form-label fw-semibold">Burial Location</label>
            <input type="text" name="burialLoc" id="burialLoc" class="form-control">
            @error('burialLoc')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Equipment --}}
        <div class="col-12">
            <label for="equipment" class="form-label fw-semibold">Equipment</label>
            <div class="d-flex gap-2 align-items-center">
                <select name="equipment" id="equipment" class="form-select w-50" onchange="getQty()">
                    <option value="">Select Equipment</option>
                    @foreach ($eqData as $data)
                        <option value="{{ $data->id }},{{ $data->eq_available }}">
                            {{ $data->id }} — {{ $data->eq_name }}
                        </option>
                    @endforeach
                </select>
                <input type="text" id="avail" class="form-control w-25" readonly placeholder="Available">
                <button type="button" id="add_eq" onclick="checkInputEq()" class="btn btn-outline-success">
                    Add Equipment
                </button>
            </div>
        </div>

        <div id="addEquipment" class="col-12 mt-2"></div>

        {{-- Stock --}}
        <div class="col-12 mt-3">
            <label for="stock" class="form-label fw-semibold">Stock</label>
            <div class="d-flex gap-2 align-items-center">
                <select name="stock" id="stock" class="form-select w-50" onchange="getQtySto()">
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

        <div id="addStock" class="col-12 mt-2"></div>

        {{-- Submit Button --}}
        <div class="text-end mt-4">
            <button type="submit" class="btn btn-success submit-btn">
                Submit Request
            </button>
        </div>

    </form>
</div>
@endsection
