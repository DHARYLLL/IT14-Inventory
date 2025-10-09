@extends('layouts.layout')
@section('title', 'Purchase Order')

@section('head', 'Create Purchase Order')
@section('name', 'Staff')

@section('content')
    <div class="purchase-order-container">

        {{-- Header section --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('Purchase-Order.index') }}" class="text-decoration-none">
                    <h4 class="text-dark mb-0 fw-semibold">Purchase Order</h4>
                </a>
                <span class="text-muted">></span>
                <p class="mb-0 text-secondary fw-medium">Create Purchase Order</p>
            </div>

            <button class="btn btn-success d-flex align-items-center gap-2 shadow-sm" type="button" data-bs-toggle="modal"
                data-bs-target="#NewSupplierModal">
                <i class="bi bi-plus-lg"></i>
                <span>Add Supplier</span>
            </button>
        </div>

        {{-- Main Card --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('Purchase-Order.store') }}" method="POST" id="form">
                    @csrf

                    {{-- Supplier selection + buttons --}}
                    <div class="row align-items-end mb-4">
                        <div class="col-md-6">
                            <label for="supp" class="form-label fw-semibold text-secondary">
                                Supplier
                            </label>
                            <select class="form-select shadow-sm" name="supp" id="supp">
                                <option selected disabled>Select supplier</option>
                                @foreach ($supData as $supp)
                                    <option value="{{ $supp->id }}">
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
                            <button class="btn btn-success text-white px-4" type="submit">
                                <i class="bi bi-send"></i> Submit
                            </button>
                        </div>
                    </div>

                    {{-- Dynamic input fields --}}
                    <div id="pasteHere">
                        @php
                            $oldItems = old('itemName', ['']);
                            $oldQtys = old('qty', ['']);
                            $oldunitPrices = old('unitPrice', ['']);
                            $oldsizeWeigth = old('sizeWeigth', ['']);
                        @endphp

                        @foreach ($oldItems as $i => $item)
                            <div class="row g-2 mb-2 px-3 py-2 bg-light rounded-3 shadow-sm form-section">

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold text-secondary">
                                        <i class="bi bi-receipt text-success"></i> Item Name
                                    </label>
                                    <input type="text" name="itemName[]" value="{{ $item }}"
                                        class="form-control shadow-sm">
                                    @error("itemName.$i")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label fw-semibold text-secondary">
                                        <i class="bi bi-box text-success"></i> Quantity
                                    </label>
                                    <input type="number" name="qty[]" value="{{ $oldQtys[$i] ?? '' }}"
                                        class="form-control shadow-sm">
                                    @error("qty.$i")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label fw-semibold text-secondary">
                                        <i class="bi bi-tag text-success"></i> Unit Price
                                    </label>
                                    <input type="text" name="unitPrice[]" value="{{ $oldunitPrices[$i] ?? '' }}"
                                        class="form-control shadow-sm">
                                    @error("unitPrice.$i")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label fw-semibold text-secondary">
                                        <i class="bi bi-weight text-success"></i> Size/Weight
                                    </label>
                                    <input type="text" name="sizeWeigth[]" value="{{ $oldsizeWeigth[$i] ?? '' }}"
                                        class="form-control shadow-sm">
                                    @error("sizeWeigth.$i")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button"
                                        class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center gap-2 remove-btn">
                                        <i class="bi bi-x-circle"></i> Remove
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
