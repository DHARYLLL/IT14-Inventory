@extends('layouts.layout')
@section('title', 'Packages')

@section('content')
    @section('head', 'Packages')


    <div class="cust-add-form">
        
        <form action="{{ route('Package.update', $pkgData->id) }}" method="POST" class="h-100">
            @csrf
            @method('put')

            <div class="row">
                <div class="col col-auto">
                    <h4 class="form-title">Edit Package</h4>
                </div>
            </div>

            <div class="row mt-4 cust-white-bg">
                <div class="col-md-12">
                    <h5 class="cust-sub-title">Package details:</h5>
                </div>

                <div class="col-md-5">
                    <label class="fw-semibold text-dark mb-1">Package Name <span class="text-danger">*</span></label>
                    <input type="text" name="pkgName" class="form-control" value="{{ old('pkgName', $pkgData->pkg_name) }}">
                    @error('pkgName')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="fw-semibold text-dark mb-1">Price <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">₱</span>
                        <input type="text" name="pkgPrice" class="form-control" value="{{ old('pkgPrice', $pkgData->pkg_price) }}">
                    </div>
                    @error('pkgPrice')
                        <p class="text-danger small mt-1">{{ $message }}</p>
                    @enderror
                </div>
                {{-- Add or Remove Item/Equipment --}}
                <div class="col-md-4">
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <label for="" class="form-label">Add / Remove</label>
                            <a href="{{ route('Package.addRemItem', $pkgData->id) }}" class="cust-btn cust-btn-primary">Add / Remove Inclusion</a>
                        </div>
                    </div>
                    
                </div>
            </div>

            {{-- Assigned stock --}}
            <div class="row mt-4 cust-white-bg">
                <div class="col-md-12">
                    <h5 class="cust-sub-title">Assigned Stock:</h5>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="row cust-table-header cust-table-shadow">
                        <div class="col-md-6">Name</div>
                        <div class="col-md-2">Size</div>
                        <div class="col-md-2">In Stock</div>
                        <div class="col-md-2">Assigned Qty.</div>
                    </div>
                </div>

                <div class="col-md-12 cust-max-300 cust-table-shadow">

                    @if($pkgStoData->isEmpty())
                        <div class="row cust-table-content py-2">
                            <div class="col-md-12 text-center text-secondary">No Items Included.</div>
                        </div>
                    @else
                        @foreach($pkgStoData as $row)
                            <div class="row cust-table-content py-2">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-secondary">Name</label>
                                    <p>{{ $row->pkgStoToSto->item_name }}</p>
                                    <input type="text" name="stoId[]" value="{{ $row->id }}" hidden>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold text-secondary">Size/Unit</label>
                                    <p>{{ $row->pkgStoToSto->item_size }}</p>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold text-secondary">In stock</label>
                                    <p>{{ $row->pkgStoToSto->item_qty }}</p>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold text-secondary">Qty. <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="qty[]" value="{{ old('qty.'.$loop->index, $row->stock_used) }}">
                                    @error('qty.' . $loop->index)
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                        
                    @endif

                </div>

            </div>

            {{-- Assigned Equipment --}}
            <div class="row mt-4 cust-white-bg">
                <div class="col-md-12">
                    <h5 class="cust-sub-title">Assigned Equipment:</h5>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="row cust-table-header cust-table-shadow">
                        <div class="col-md-6">Name</div>
                        <div class="col-md-2">Size</div>
                        <div class="col-md-2">Available</div>
                        <div class="col-md-2">Assigned Qty.</div>
                    </div>
                </div>

                <div class="col-md-12 cust-max-300 cust-table-shadow">

                    @if($pkgEqData->isEmpty())
                        <div class="row cust-table-header cust-table-shadow py-2">
                            <div class="col-md-12 text-center text-secondary">No Items Included.</div>
                        </div>
                    @else
                        @foreach($pkgEqData as $row)
                            <div class="row cust-table-content py-2">
                                <div class="col-md-6">
                                    <p>{{ $row->pkgEqToEq->eq_name }}</p>
                                    <input type="text" name="eqId[]" value="{{ $row->id }}" hidden>
                                </div>
                                <div class="col-md-2">
                                    <p>{{ $row->pkgEqToEq->eq_size }}</p>
                                </div>
                                <div class="col-md-2">
                                    <p>{{ $row->pkgEqToEq->eq_available }}</p>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="eqQty[]" value="{{ old('eqQty.'.$loop->index, $row->eq_used) }}">
                                    @error('eqQty.' . $loop->index)
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>                               
                            </div>
                        @endforeach
                        
                    @endif

                </div>

            </div>

            <div class="row justify-content-end mt-4">

                <div class="col col-auto">
                        @session('promt-s')
                        <div class="text-success small mt-1">{{ $value }}</div>
                    @endsession
                </div>
                
                <div class="col col-auto">
                    
                    <a href="{{ route('Package.index') }}" class="cust-btn cust-btn-secondary d-flex align-items-center gap-2 px-3">
                        <i class="bi bi-arrow-left"></i> <span>Back</span>
                    </a>
                </div>
                <div class="col col-auto">
                    <button class="cust-btn cust-btn-primary"><i class="bi bi-floppy px-2"></i>Save</button>
                </div>
                
            </div>
        </form>

    </div>

@endsection
