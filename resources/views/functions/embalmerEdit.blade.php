@extends('layouts.layout')
@section('title', 'Embalmer')

@section('content')
    @section('head', 'Edit Embalmer')

    <div class="cust-h-content-func">
        <div class="card bg-white border-0 rounded-3 h-100">
            <div class="card-body h-100">
                
                <form action="{{ route('Embalmer.update', $leData->id) }}" method="post" class="h-100">
                    @csrf
                    @method('put')

                    <div class="row">

                        <div class="col-md-6">
                            <label for="embalmName" class="form-label">Name:</label>
                            <input type="text" class="form-control" name="embalmName" placeholder="Embalmer name" value="{{ old('embalmName') ? old('embalmName') : $leData->embalmer_name }}">
                            @error('embalmName')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <label for="embalmPrice" class="form-label">Price</label>
                            <input type="text" class="form-control" name="embalmPrice" placeholder="Price" value="{{ old('embalmPrice') ? old('embalmPrice') : $leData->prep_price }}">
                            @error('embalmPrice')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Add or Remove Item/Equipment --}}
                        <div class="col-md-4">
                            <div class="row justify-content-end">
                                <div class="col-auto">
                                    <label for="" class="form-label">Add/Remove</label>
                                    <a href="{{ route('Embalmer.addRemItem', $leData->id) }}" class="cust-btn cust-btn-primary">Add/Remove Equipment</a>
                                </div>
                            </div>
                            
                        </div>

                    </div>

                    <div class="row h-65 mt-2">

                        <div class="col-md-6 h-100 overflow-auto">
                            
                            {{-- Stock --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="cust-sub-title">Items:</h5>
                                </div>
                                <div class="col-md-12">
                                    @if($leStoData->isEmpty())
                                        <div class="row">
                                            <div class="col-md-12 text-center text-secondary">No Items Included.</div>
                                        </div>
                                    @else
                                        @foreach($leStoData as $row)
                                            <div class="row mt-2 cust-white-bg mx-1">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold text-secondary">Name</label>
                                                    <p>{{ $row->pkgStoToSto->item_name }}</p>
                                                    <input type="text" name="stoId[]" value="{{ $row->id }}" hidden>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fw-semibold text-secondary">Size</label>
                                                    <p>{{ $row->pkgStoToSto->item_size }}</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fw-semibold text-secondary">In stock</label>
                                                    <p>{{ $row->pkgStoToSto->item_qty }}</p>
                                                </div>
                                                <div class="col-md-12 mb-1">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-semibold text-secondary">Total Qty.</label>
                                                            <p>{{ $row->stock_used * $row->stock_used_set }}</p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-semibold text-secondary">Qty.</label>
                                                            <input type="number" class="form-control" name="qty[]" value="{{ old('qty.'.$loop->index, $row->stock_used) }}">
                                                            @error('qty.' . $loop->index)
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-semibold text-secondary">Pcs/Kg/L</label>
                                                            <input type="number" class="form-control" name="qtySet[]" value="{{ old('qtySet.'.$loop->index, $row->stock_used_set) }}">
                                                            @error('qtySet.' . $loop->index)
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        @endforeach
                                        
                                    @endif
                                </div>

                            </div>

                        </div>

                        <div class="col-md-6 h-100 overflow-auto">

                            {{-- Equipment --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="cust-sub-title">Equipment:</h5>
                                </div>
                                <div class="col-md-12">
                                    @if($leEqData->isEmpty())
                                        <div class="row">
                                            <div class="col-md-12 text-center text-secondary">No Items Included.</div>
                                        </div>
                                    @else
                                        @foreach($leEqData as $row)
                                            <div class="row mt-2 cust-white-bg mx-1">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold text-secondary">Name</label>
                                                    <p>{{ $row->pkgEqToEq->eq_name }}</p>
                                                    <input type="text" name="eqId[]" value="{{ $row->id }}" hidden>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fw-semibold text-secondary">Size</label>
                                                    <p>{{ $row->pkgEqToEq->eq_size }}</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fw-semibold text-secondary">Available</label>
                                                    <p>{{ $row->pkgEqToEq->eq_available }}</p>
                                                </div>
                                                <div class="col-md-12 mb-1">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-semibold text-secondary">Total Qty.</label>
                                                            <p>{{ $row->eq_used * $row->eq_used_set }}</p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-semibold text-secondary">Qty.</label>
                                                            <input type="number" class="form-control" name="eqQty[]" value="{{ old('eqQty.'.$loop->index, $row->eq_used) }}">
                                                            @error('eqQty.' . $loop->index)
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-semibold text-secondary">Pcs/Kg/L</label>
                                                            <input type="number" class="form-control" name="eqQtySet[]" value="{{ old('eqQtySet.'.$loop->index, $row->eq_used_set) }}">
                                                            @error('eqQtySet.' . $loop->index)
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        @endforeach
                                        
                                    @endif
                                </div>

                            </div>
                        </div>

                    </div>

                    {{-- Submit --}}
                    <div class="row justify-content-end mt-4">
                        {{-- Display Error --}}
                        <div class="col col-auto">
                             @session('promt')
                                <div class="text-success small mt-1">{{ $value }}</div>
                            @endsession
                        </div>

                        <div class="col col-auto">
                            <a href="{{ route('Embalmer.index') }}" class="cust-btn cust-btn-secondary"><i
                                class="bi bi-arrow-left"></i>
                                <span>Cancel</span>
                            </a>
                        </div>

                        {{-- Submit Button --}}
                        <div class="col col-auto ">
                            <button type="submit" class="cust-btn cust-btn-primary"><i class="bi bi-floppy px-2"></i>
                                Save
                            </button>      
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

@endsection
