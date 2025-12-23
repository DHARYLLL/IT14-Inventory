@extends('layouts.layout')
@section('title', 'Add or Remove Items')

@section('content')
    @section('head', 'Add or Remove Items')

    <div class="cust-add-form">

        <div class="h-100">
            <div class="row">
                <div class="col col-auto">
                    <h4 class="form-title">Add or Remove Inclusions</h4>
                </div>
            </div>

            {{-- Stock inclusion --}}
            <div class="row mt-4 cust-white-bg">
                <div class="col-md-12">
                    <h5 class="cust-sub-title">Assigned Stock:</h5>
                </div>

                <div class="col-md-12 mt-3">
                    <form action="{{ route('Embalmer.addItem') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label for="stoAdd" class="form-label">Add New Item</label>
                                <select name="stoAdd" id="stoAdd" class="form-select" >
                                    <option value="">Select Item</option>
                                    @foreach ($stoData as $data)
                                        <option value="{{ $data->id }}" {{ old('stoAdd') == $data->id ? 'selected' : '' }}>
                                            {{ $data->item_name }} | size: {{ $data->item_size }} | In Stock: {{ $data->item_qty }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('stoAdd')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                @session('promt-f-sto')
                                    <div class="text-danger small mt-1">{{ $value }}</div>
                                @endsession
                            </div>
                            <div class="col-md-2">
                                <label for="qty" class="form-label">Qty. <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="qty" value="{{ old('qty') }}">
                                <input type="text" name="embId" value="{{ $embId }}" hidden>
                                @error('qty')
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

                <div class="col-md-12 mt-3">
                    <div class="row cust-table-header cust-table-shadow">
                        <div class="col-md-6">Name</div>
                        <div class="col-md-2">Size</div>
                        <div class="col-md-2">Assigned Qty.</div>
                        <div class="col-md-2">Remove</div>
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
                                </div>
                                <div class="col-md-2">
                                    <p>{{ $row->pkgStoToSto->item_size }}</p>
                                </div>
                                <div class="col-md-2">
                                    <p>{{ $row->stock_used }}</p>
                                </div>
                                <div class="col-md-2">
                                    <form action="{{ route('Embalmer.removeItem', $row->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="cust-btn cust-btn-danger-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove"><i class="bi bi-x-circle"></i></button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>


            </div>

            {{-- Equipment inclusion --}}
            <div class="row mt-4 cust-white-bg">
                <div class="col-md-12">
                    <h5 class="cust-sub-title">Assigned Equipemnt:</h5>
                </div>

                <div class="col-md-12 mt-3">
                    <form action="{{ route('Embalmer.addEq') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label for="eqAdd" class="form-label">Add New Equipment</label>
                                <select name="eqAdd" id="eqAdd" class="form-select">
                                    <option value="">Select Equipment</option>
                                    @foreach ($eqData as $data)
                                        <option value="{{ $data->id }}" {{ old('eqAdd') == $data->id ? 'selected' : '' }}>
                                            {{ $data->eq_name }} | size: {{ $data->eq_size }} | Available: {{ $data->eq_available }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('eqAdd')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                @session('promt-f-eq')
                                    <div class="text-danger small mt-1">{{ $value }}</div>
                                @endsession
                            </div>

                            <div class="col-md-2">
                                <label for="eqQty" class="form-label">Qty. <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="eqQty" value="{{ old('eqQty') }}">
                                <input type="text" name="embId" value="{{ $embId }}" hidden>
                                @error('eqQty')
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

                <div class="col-md-12 mt-3">
                    <div class="row cust-table-header cust-table-shadow">
                        <div class="col-md-6">Name</div>
                        <div class="col-md-2">Size</div>
                        <div class="col-md-2">Assigned Qty.</div>
                        <div class="col-md-2">Remove</div>
                    </div>
                </div>

                <div class="col-md-12 cust-max-300 cust-table-shadow">
                    @if($leEqData->isEmpty())
                        <div class="row cust-table-content py-2">
                            <div class="col-md-12 text-center text-secondary">No Items Included.</div>
                        </div>
                    @else
                        @foreach($leEqData as $row)
                            <div class="row cust-table-content py-2">
                                <div class="col-md-6">
                                    <p>{{ $row->pkgEqToEq->eq_name }}</p>
                                </div>
                                <div class="col-md-2">
                                    <p>{{ $row->pkgEqToEq->eq_size }}</p>
                                </div>
                                <div class="col-md-2">
                                    <p>{{ $row->eq_used }}</p>
                                </div>
                                <div class="col-md-2">
                                    <form action="{{ route('Embalmer.removeEq', $row->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="cust-btn cust-btn-danger-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove"><i class="bi bi-x-circle"></i></button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endif
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

@endsection
