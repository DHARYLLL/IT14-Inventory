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
                            <table class="table table-hover align-middle mb-0">
                            <thead class="table-success text-secondary" >
                                <tr>
                                    <th class="fw-semibold">Item</th>
                                    <th class="fw-semibold">Size</th>
                                    <th class="fw-semibold">Qty.</th>
                                    <th class="fw-semibold">Utilize</th>
                                </tr>
                            </thead>
                            <tbody>
                                @session('promt')
                                    <tr>
                                        <td colspan="5" class="text-center" style="font-style: normal;"><div class="text-success small mt-1">{{ $value }}</div></td>
                                    </tr>
                                @endsession
                                @if ($leStoData->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center text-secondary py-3">No Items Included.</td>
                                    </tr>
                                @else
                                    {{-- Get stock --}}
                                    @foreach ($leStoData as $row)
                                        <tr>
                                            <td>{{ $row->pkgStoToSto->item_name }}</td>
                                            <td>{{ $row->pkgStoToSto->item_size }}</td>
                                            <td>{{ $row->pkgStoToSto->item_qty }}</td>
                                            <td>
                                                <input type="text" name="stoId[]" value="{{ $row->id }}" hidden>
                                                <input type="number" class="form-control w-75" name="util[]" value="{{ $row->stock_used }}">
                                                @error('util.' . $loop->index)
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @session('promt')
                                        <tr>
                                            <td colspan="5" class="text-center" style="font-style: normal;"><div class="text-success small mt-1">{{ $value }}</div></td>
                                        </tr>
                                    @endsession
                                    @if ($leEqData->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center text-secondary py-3">No Equipment Included.</td>
                                        </tr>
                                    @else
                                        @foreach ($leEqData as $row)
                                            <tr>
                                                <td>{{ $row->pkgEqToEq->eq_name }}</td>
                                                <td>{{ $row->pkgEqToEq->eq_size }}</td>
                                                <td>{{ $row->pkgEqToEq->eq_available }}</td>
                                                <td>
                                                    <input type="text" name="eqId[]" value="{{ $row->id }}" hidden>
                                                    <input type="number" class="form-control w-75" name="eqUtil[]" value="{{ $row->eq_used }}">
                                                    @error('eqUtil.' . $loop->index)
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                                    
                                                </td>
                                                
                                            </tr>
                                        @endforeach
                                    @endif
                                        
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
