@extends('layouts.layout')
@section('title', 'Stock Management')

@section('content')

@section('head', 'Stocks')
@section('name', 'Staff')

<div class="stock-edit-container p-3">

    @session('promt')
        <div class="alert alert-danger fw-semibold text-center">
            {{ $value }}
        </div>
    @endsession

    <div class="card shadow-sm border-0 rounded-3 p-4 bg-white">
        <h3 class="fw-semibold text-success mb-4">Edit Stock Details</h3>

        <form action="{{ route('Stock.update', $stockData->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Item Name</label>
                    <input type="text" class="form-control" name="itemName" value="{{ $stockData->item_name }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Item Quantity</label>
                    <input type="text" class="form-control" name="itemQty" value="{{ $stockData->item_qty }}"
                        readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Size / Weight</label>
                    <input type="text" class="form-control" name="sizeWeight" value="{{ $stockData->size_weight }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Unit Price</label>
                    <input type="text" class="form-control" name="unitPrice"
                        value="{{ $stockData->item_unit_price }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Item Type</label>
                    <input type="text" class="form-control" value="{{ $stockData->item_type }}" readonly>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-3 mt-4">
                <button type="submit" class="btn btn-green px-4">Save Changes</button>
                <a href="{{ route('Stock.index') }}" class="btn btn-outline-success">Go Back</a>
            </div>
        </form>
    </div>
</div>

@endsection
