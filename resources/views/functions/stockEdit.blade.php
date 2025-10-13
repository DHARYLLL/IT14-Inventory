@extends('layouts.layout')
@section('title', 'Stock Management')

@section('content')
    
    @section('head', 'Stock')
    @section('name', 'Staff')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="fw-semibold">Stocks Edit</h2>
        @session('promt')
            <h2 class="fw-semibold bg-danger-subtle">{{ $value }}</h2>
        @endsession
    </div>

    {{-- table --}}
    <div class="bg-white rounded border overflow-hidden">
        <form action="{{ route('Stock.update', $stockData->id) }}" method="POST">
            @csrf
            @method('put')

            <div class="row bg-success p-2 m-2 border rounded-2">
                <div class="col col-6">
                    <p>Item name</p>
                    <input type="text" class="form-control" name="itemName" value="{{ $stockData->item_name }}">
                </div>
                <div class="col col-6">
                    <p>Item qty</p>
                    <input type="text" class="form-control" name="itemQty" value="{{ $stockData->item_qty }}" readonly>
                </div>
            </div>

            <div class="row bg-success p-2 m-2 border rounded-2">
                <div class="col col-6">
                    <p>Size/Weight</p>
                    <input type="text" class="form-control" name="sizeWeight" value="{{ $stockData->size_weight }}">
                </div>
                <div class="col col-6">
                    <p>Unit Price</p>
                    <input type="text" class="form-control" name="unitPrice" value="{{ $stockData->item_unit_price }}">
                </div>
            </div>

            <div class="row bg-success p-2 m-2 border rounded-2">
                <div class="col col-6">
                    <p>Item type</p>
                    <input type="text" class="form-control" value="{{ $stockData->item_type }}" readonly>
                </div>
                <div class="col col-6">
                    <div class="row align-item-end">
                        <div class="col col-6 p-2">
                            <button type="submit" class="btn btn-primary w-100">Save</button>
                        </div>
                        <div class="col col-6 p-2">
                            <a href="{{ route('Stock.index') }}" class="btn btn-secondary w-100">go back</a>
                        </div>
                    </div>
                </div>
            </div>



        </form>
    </div>
    
@endsection

