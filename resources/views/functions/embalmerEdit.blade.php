@extends('layouts.layout')
@section('title', 'Embalmer')

@section('content')
    @section('head', 'Embalmer')

    <div class="cust-add-form">

        <form action="{{ route('Embalmer.update', $leData->id) }}" method="post" class="h-100">
            @csrf
            @method('put')

            <div class="row">
                <div class="col col-auto">
                    <h4 class="form-title">Edit Embalmer</h4>
                </div>
            </div>

            <div class="row mt-4 cust-white-bg">
                <div class="col-md-12">
                    <h5 class="cust-sub-title">Emablmer details:</h5>
                </div>

                <div class="col-md-5">
                    <label for="embalmName" class="form-label">Name: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="embalmName" placeholder="Embalmer name" value="{{ old('embalmName') ? old('embalmName') : $leData->embalmer_name }}">
                    @error('embalmName')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="embalmPrice" class="form-label">Price <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">₱</span>
                        <input type="text" class="form-control" name="embalmPrice" placeholder="Price" value="{{ old('embalmPrice') ? old('embalmPrice') : $leData->prep_price }}">
                    </div>
                    @error('embalmPrice')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <div class="row justify-content-end">
                        <div class="col col-auto">
                            <label for="" class="form-label">Add/Remove</label>
                            <a href="{{ route('Embalmer.addRemItem', $leData->id) }}" class="cust-btn cust-btn-primary">Add/Remove Inclusions</a>
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
                    @if($leStoData->isEmpty())
                        <div class="row cust-table-content py-2">
                            <div class="col-md-12 text-center text-secondary">No Items Included.</div>
                        </div>
                    @else
                        @foreach($leStoData as $row)
                            <div class="row cust-table-content py-2">

                                <div class="col-md-6">
                                    <p>{{ $row->pkgStoToSto->item_name }}</p>
                                    <input type="text" name="stoId[]" value="{{ $row->id }}" hidden>
                                </div>

                                <div class="col-md-2">
                                    <p>{{ $row->pkgStoToSto->item_size }}</p>
                                </div>

                                <div class="col-md-2">
                                    <p>{{ $row->pkgStoToSto->item_qty }}</p>
                                </div>

                                <div class="col-md-2">
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

            {{-- Assigned equipment --}}
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
                    @if($leEqData->isEmpty())
                        <div class="row cust-table-content py-2">
                            <div class="col-md-12 text-center text-secondary">No Equipment Included.</div>
                        </div>
                    @else
                        @foreach($leEqData as $row)
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

            {{-- Submit --}}
            <div class="row justify-content-end mt-4">
                {{-- Display Error --}}
                <div class="col col-auto">
                        @session('promt')
                        <div class="text-success small mt-1">{{ $value }}</div>
                    @endsession
                </div>

                <div class="col col-auto">
                    <a href="{{ route('Personnel.index') }}" class="cust-btn cust-btn-secondary"><i
                        class="bi bi-arrow-left"></i>
                        <span>Cancel</span>
                    </a>
                </div>

                {{-- Submit Button --}}
                @if( session("empRole") != 'staff' )
                    <div class="col col-auto ">
                    <button type="submit" class="cust-btn cust-btn-primary"><i class="bi bi-floppy px-2"></i>
                        Save
                    </button>      
                </div>
                @endif
                
            </div>
            
        </form>

    </div>

@endsection
