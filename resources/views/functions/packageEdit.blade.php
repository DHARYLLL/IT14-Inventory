@extends('layouts.layout')
@section('title', 'Packages')

@section('content')
    @section('head', 'Edit Packages')
    @section('name', 'Staff')


    <div class="cust-h-content-func">
        <div class="card h-100">
            <div class="card-body h-100">

                <form action="{{ route('Package.update', $pkgData->id) }}" method="POST" class="h-100">
                    @csrf
                    @method('put')
                    <div class="row justify-content-between align-items-start">
                        <div class="col-md-5">
                            <label class="fw-semibold text-dark mb-1">Package Name</label>
                            <input type="text" name="pkgName" class="form-control" value="{{ old('pkgName', $pkgData->pkg_name) }}">
                            @error('pkgName')
                                <p class="text-danger small mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="fw-semibold text-dark mb-1">Price</label>
                            <input type="text" name="pkgPrice" class="form-control" value="{{ old('pkgPrice', $pkgData->pkg_price) }}">
                            @error('pkgPrice')
                                <p class="text-danger small mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- Add or Remove Item/Equipment --}}
                        <div class="col-md-4">
                            <div class="row justify-content-end">
                                <div class="col-auto">
                                    <label for="" class="form-label">Add/Remove</label>
                                    <a href="{{ route('Package.addRemItem', $pkgData->id) }}" class="cust-btn cust-btn-primary">Add/Remove Equipment</a>
                                </div>
                            </div>
                            
                        </div>

                        
                    </div>


                    <div class="row h-65 mt-2">

                        {{-- Stock --}}
                        <div class="col col-6 h-100 overflow-auto">

                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="cust-sub-title">Items:</h5>
                                </div>
                                <div class="col-md-12">
                                    @if($pkgStoData->isEmpty())
                                        <div class="row">
                                            <div class="col-md-12 text-center text-secondary">No Items Included.</div>
                                        </div>
                                    @else
                                        @foreach($pkgStoData as $row)
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

                            <!--
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-success text-secondary" >
                                    <tr>
                                        <th class="fw-semibold">Item</th>
                                        <th class="fw-semibold">Size</th>
                                        <th class="fw-semibold">Utilize</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($pkgStoData->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center text-secondary py-3">No Items Included Found.</td>
                                        </tr>
                                    @else
                                        {{-- Get stock --}}
                                        @foreach ($pkgStoData as $row)
                                            <tr>
                                                <td>{{ $row->pkgStoToSto->item_name }}</td>
                                                <td>{{ $row->pkgStoToSto->item_size }}</td>
                                                <td>
                                                     <input type="text" name="pkgStoId[]" value="{{ $row->id }}" hidden>
                                                    <input type="number" class="form-control w-75" name="stoUtil[]" value="{{ old('stoUtil.'. $loop->index, $row->stock_used) }}">
                                                    @error('stoUtil.'. $loop->index)
                                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                                    @enderror
                                                    
                                                </td>
                                                
                                            </tr>
                                        @endforeach
                                        
                                    @endif
                                </tbody>
                            </table>
                            -->
                        </div>


                        {{-- Equipment --}}
                        <div class="col col-6 h-100 overflow-auto">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="cust-sub-title">Equipment:</h5>
                                </div>
                                <div class="col-md-12">
                                    @if($pkgEqData->isEmpty())
                                        <div class="row">
                                            <div class="col-md-12 text-center text-secondary">No Items Included.</div>
                                        </div>
                                    @else
                                        @foreach($pkgEqData as $row)
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
                            <!--
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-success text-secondary" >
                                    <tr>
                                        <th class="fw-semibold">Equipment</th>
                                        <th class="fw-semibold">Size</th>
                                        <th class="fw-semibold">Utilize</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($pkgEqData->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center text-secondary py-3">No Items Included Found.</td>
                                        </tr>
                                    @else
                                        @foreach ($pkgEqData as $row)

                                            <tr>
                                                <td>{{ $row->pkgEqToEq->eq_name }}</td>
                                                <td>{{ $row->pkgEqToEq->eq_size }}</td>
                                                <td>
                                                    <input type="text" name="pkgEqId[]" value="{{ $row->id }}" hidden>
                                                    <input type="number" class="form-control w-75" name="eqUtil[]" value="{{ old('eqUtil.'. $loop->index, $row->eq_used) }}">
                                                    @error('eqUtil.'. $loop->index)
                                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                                    @enderror
                                                    
                                                </td>
                                                
                                            </tr>
                                        @endforeach
                                        
                                    @endif
                                        
                                </tbody>
                            </table>
                            -->

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
        </div>
    </div>

@endsection
