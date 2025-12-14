@extends('layouts.layout')
@section('title', 'Add or Remove Items')

@section('content')
    @section('head', 'Add or Remove Items')

    <div class="cust-h-content-func">
        <div class="card bg-white border-0 rounded-3 h-100">
            <div class="card-body h-100">
                
                <div class="row h-90">

                    <div class="col-md-6 h-100">
                        {{-- Stock --}}
                        <div class="row h-100">
                            <div class="col-md-12 h-25 overflow-auto">
                                <form action="{{ route('Embalmer.addItem') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="stoAdd" class="form-label">Add New Item</label>
                                            <select name="stoAdd" id="stoAdd" class="form-select" >
                                                <option value="">Select Item</option>
                                                @foreach ($stoData as $data)
                                                    <option value="{{ $data->id }}" {{ old('stoAdd') == $data->id ? 'selected' : '' }}>
                                                        {{ $data->item_name }} | size: {{ $data->item_size }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('stoAdd')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <label for="qty" class="form-label">Qty.</label>
                                            <input type="number" class="form-control" name="qty" value="{{ old('qty') }}">
                                            <input type="text" name="embId" value="{{ $embId }}" hidden>
                                            @error('qty')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <label for="qtySet" class="form-label">Pcs/Kg/L</label>
                                            <input type="number" class="form-control" name="qtySet" value="{{ old('qtySet', 1) }}">
                                            @error('qtySet')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <label for="" class="form-label">Add</label>
                                            <button type="submit" class="cust-btn cust-btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Item"><i class="bi bi-plus-lg"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-12 h-75 overflow-auto">
                                @if($leStoData->isEmpty())
                                    <div class="row mt-2 cust-white-bg mx-1">
                                        <div class="col-md-12 text-center text-secondary">No Items Included.</div>
                                    </div>
                                @else
                                    @foreach($leStoData as $row)
                                        <div class="row mt-2 cust-white-bg mx-1">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-secondary">Name</label>
                                                <p>{{ $row->pkgStoToSto->item_name }}</p>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label fw-semibold text-secondary">Size/Unit</label>
                                                <p>{{ $row->pkgStoToSto->item_size }}</p>
                                            </div>
                                           <div class="col-md-2">
                                                <label class="form-label fw-semibold text-secondary">Qty.</label>
                                                <p>{{ $row->stock_used * $row->stock_used_set }}</p>
                                            </div>
                                            <div class="col-md-2">
                                                <form action="{{ route('Embalmer.removeItem', $row->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="cust-btn cust-btn-danger-secondary mt-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 h-100">

                        {{-- Equipment --}}
                        <div class="row h-100">
                            <div class="col-md-12 h-25 overflow-auto">
                                <form action="{{ route('Embalmer.addEq') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="eqAdd" class="form-label">Add New Equipment</label>
                                            <select name="eqAdd" id="eqAdd" class="form-select" >
                                                <option value="">Select Equipment</option>
                                                @foreach ($eqData as $data)
                                                    <option value="{{ $data->id }}" {{ old('eqAdd') == $data->id ? 'selected' : '' }}>
                                                        {{ $data->eq_name }} | size: {{ $data->eq_size }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('eqAdd')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <label for="eqQty" class="form-label">Qty.</label>
                                            <input type="number" class="form-control" name="eqQty" value="{{ old('eqQty') }}">
                                            <input type="text" name="embId" value="{{ $embId }}" hidden>
                                            @error('eqQty')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <label for="eqQtySet" class="form-label">Pcs/Kg/L</label>
                                            <input type="number" class="form-control" name="eqQtySet" value="{{ old('eqQtySet', 1) }}">
                                            @error('eqQtySet')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <label for="" class="form-label">Add</label>
                                            <button type="submit" class="cust-btn cust-btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Equipment"><i class="bi bi-plus-lg"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-12 h-75 overflow-auto">
                                @if($leEqData->isEmpty())
                                    <div class="row mt-2 cust-white-bg mx-1">
                                        <div class="col-md-12 text-center text-secondary">No Items Included.</div>
                                    </div>
                                @else
                                    @foreach($leEqData as $row)
                                        <div class="row mt-2 cust-white-bg mx-1">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-secondary">Name</label>
                                                <p>{{ $row->pkgEqToEq->eq_name }}</p>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label fw-semibold text-secondary">Size/Unit</label>
                                                <p>{{ $row->pkgEqToEq->eq_size }}</p>
                                            </div>
                                           <div class="col-md-2">
                                                <label class="form-label fw-semibold text-secondary">Qty.</label>
                                                <p>{{ $row->eq_used * $row->eq_used_set }}</p>
                                            </div>
                                            <div class="col-md-2">
                                                <form action="{{ route('Embalmer.removeEq', $row->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="cust-btn cust-btn-danger-secondary mt-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Submit --}}
                <div class="row justify-content-end mt-4 ">
                    {{-- Display Error --}}
                    <div class="col col-auto">
                            @session('promt')
                            <div class="text-success small mt-1">{{ $value }}</div>
                        @endsession
                    </div>

                    <div class="col col-auto">
                        <a href="{{ route('Embalmer.edit', $embId) }}" class="cust-btn cust-btn-secondary"><i
                            class="bi bi-arrow-left"></i>
                            <span>Back</span>
                        </a>
                    </div>
                </div>
                    
                
            </div>
        </div>
    </div>

@endsection
