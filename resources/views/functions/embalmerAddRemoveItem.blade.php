@extends('layouts.layout')
@section('title', 'Add or Remove Items')

@section('content')
    @section('head', 'Add or Remove Items')

    <div class="cust-h-content-func">
        <div class="card bg-white border-0 rounded-3 h-100">
            <div class="card-body h-100">
                
                <form action="{{ route('Embalmer.addItem') }}" method="POST" class="h-100">
                    @csrf

                    <div class="row h-65">

                        <div class="col-md-6 h-100 overflow-auto">
                            {{-- Stock --}}
                            <table class="table table-hover align-middle mb-0">
                            <thead class="table-success text-secondary" >
                                <tr>
                                    <th class="fw-semibold">Item</th>
                                    <th class="fw-semibold">Size</th>
                                    <th class="fw-semibold">Qty.</th>
                                    <th class="fw-semibold">Utilize</th>
                                    <th class="fw-semibold">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @session('promt')
                                    <tr>
                                        <td colspan="5" class="text-center" style="font-style: normal;"><div class="text-success small mt-1">{{ $value }}</div></td>
                                    </tr>
                                @endsession
                                {{-- Add new stock --}}
                                <tr>
                                    <form action="{{ route('Embalmer.addItem') }}" method="POST">
                                        @csrf
                                        <td colspan="3" style="font-style: normal;">
                                            <label for="stoAdd" class="form-label">Add New Item</label>
                                            <select name="stoAdd" id="stoAdd" class="form-select" >
                                                <option value="">Select Item</option>
                                                @foreach ($stoData as $data)
                                                    <option value="{{ $data->id }}" {{ old('stoAdd') == $data->id ? 'selected' : '' }}>
                                                        {{ $data->item_name }} | size: {{ $data->item_size }} | Unit: {{ $data->item_unit }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('stoAdd')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            <label for="utilQty" class="form-label w-75">Utlize Qty.</label>
                                            <input type="number" class="form-control w-75" name="utilQty" value="{{ old('utilQty') }}">
                                            <input type="text" name="embId" value="{{ $embId }}" hidden>
                                            @error('utilQty')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                            
                                        </td>
                                        <td>
                                            <label for="" class="form-label">Add</label>
                                            <button type="submit" onclick="checkSto()" class="cust-btn cust-btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Item"><i class="bi bi-plus-lg"></i></button>
                                        </td>
                                    </form>
                                </tr>
                                {{-- Get stock --}}
                                @foreach ($leStoData as $row)
                                    <tr>
                                        <td>{{ $row->pkgStoToSto->item_name }}</td>
                                        <td>{{ $row->pkgStoToSto->item_size }}</td>
                                        <td>{{ $row->pkgStoToSto->item_qty }}</td>
                                        <td>{{ $row->stock_used }}</td> 
                                        <td>
                                            <form action="{{ route('Embalmer.removeItem', $row->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="cust-btn cust-btn-danger-secondary mt-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                
                            </tbody>
                        </table>

                        </div>

                        <div class="col-md-6 h-100 overflow-auto">

                            {{-- Equipment --}}
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-success text-secondary" >
                                    <tr>
                                        <th class="fw-semibold">Equipment</th>
                                        <th class="fw-semibold">Size</th>
                                        <th class="fw-semibold">Qty.</th>
                                        <th class="fw-semibold">Utilize</th>
                                        <th class="fw-semibold text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @session('promt')
                                        <tr>
                                            <td colspan="5" class="text-center" style="font-style: normal;"><div class="text-success small mt-1">{{ $value }}</div></td>
                                        </tr>
                                    @endsession
                                    {{-- Add new equipment --}}    
                                    <tr>
                                        <form action="{{ route('Embalmer.addEq') }}" method="POST">
                                            @csrf
                                            <td colspan="3" style="font-style: normal;">
                                                <label for="eqAdd" class="form-label">Add New Equipment</label>
                                                <select name="eqAdd" id="eqAdd" class="form-select" >
                                                    <option value="">Select Item</option>
                                                    @foreach ($eqData as $data)
                                                        <option value="{{ $data->id }}" {{ old('eqAdd') == $data->id ? 'selected' : '' }}>
                                                            {{ $data->eq_name }} | size: {{ $data->eq_size }} | Unit: {{ $data->eq_unit }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('eqAdd')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                <label for="eqUtilQty" class="form-label w-75">Utlize Qty.</label>
                                                <input type="number" class="form-control w-75" name="eqUtilQty" value="{{ old('eqUtilQty') }}">
                                                <input type="text" name="embId" value="{{ $embId }}" hidden>
                                                @error('eqUtilQty')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                               
                                            </td>
                                            <td>
                                                <button type="submit" class="cust-btn cust-btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Equipment"><i class="bi bi-plus-lg"></i></button>
                                            </td>
                                        </form>
                                    </tr>
                                    @foreach ($leEqData as $row)
                                        <tr>
                                            <td>{{ $row->pkgEqToEq->eq_name }}</td>
                                            <td>{{ $row->pkgEqToEq->eq_size }}</td>
                                            <td>{{ $row->pkgEqToEq->eq_available }}</td>
                                            <td>{{ $row->eq_used }}</td>
                                            <td>
                                                <form action="{{ route('Embalmer.removeEq', $row->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="cust-btn cust-btn-danger-secondary mt-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                    
                                        
                                </tbody>
                            </table>

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
                            <a href="{{ route('Embalmer.edit', $embId) }}" class="cust-btn cust-btn-secondary"><i
                                class="bi bi-arrow-left"></i>
                                <span>Back</span>
                            </a>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

@endsection
