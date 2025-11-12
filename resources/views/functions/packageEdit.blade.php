@extends('layouts.layout')
@section('title', 'Packages')

@section('content')
    @section('head', 'Edit Packages')
    @section('name', 'Staff')


    <div class="cust-h-content-func">
        <div class="card h-100">
            <div class="card-body h-100">

                <form action="{{ route('Package.update', $pkgData->id) }}" method="POST" class="h-25">
                    @csrf
                    @method('put')
                    <div class="row justify-content-between align-items-end">
                        <div class="col-md-8">
                            <label class="fw-semibold text-dark mb-1">Package Name</label>
                            <input type="text" name="pkgName" class="form-control" value="{{ $pkgData->pkg_name }}">
                            @error('pkgName')
                                <p class="text-danger small mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col col-auto">
                            <div class="row">
                                <div class="col col-auto">
                                    <a href="{{ route('Package.index') }}" class="btn btn-outline-success d-flex align-items-center gap-2 px-3">
                                        <i class="bi bi-arrow-left"></i> <span>Back</span>
                                    </a>
                                </div>
                                <div class="col col-auto">
                                    <button class="cust-btn cust-btn-primary"><i class="bi bi-floppy px-2"></i>Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                

                <div class="row h-75">

                    {{-- Stock --}}
                    <div class="col col-6 h-100 overflow-auto">

                        
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-success text-secondary" >
                                <tr>
                                    <th class="fw-semibold">Item</th>
                                    <th class="fw-semibold">Size</th>
                                    <th class="fw-semibold">Unit</th>
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
                                @if ($pkgStoData->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center text-secondary py-3">No Items Included Found.</td>
                                    </tr>
                                @else
                                    {{-- Get stock --}}
                                    @foreach ($pkgStoData as $row)
                                        <tr>
                                            <td>{{ $row->pkgStoToSto->item_name }}</td>
                                            <td>{{ $row->pkgStoToSto->item_size }}</td>
                                            <td>{{ $row->pkgStoToSto->item_unit }}</td>
                                        <form action="{{ route('Pkg-Stock.update', $row->id) }}" method="POST">
                                            @csrf
                                            @method('put')
                                            <td>
                                                <input type="number" class="form-control w-75" name="util" value="{{ $row->stock_used }}">
                                                @error('util')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                                
                                            </td>
                                            <td class="text-center">
                                                <button type="submit" class="cust-btn cust-btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Update/Save"><i class="bi bi-floppy"></i></button>
                                        </form>
                                                <form action="{{ route('Pkg-Stock.destroy', $row->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="cust-btn cust-btn-danger-secondary mt-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                    {{-- Add new stock --}}
                                    <tr>
                                        <form action="{{ route('Pkg-Stock.store') }}" method="POST">
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
                                                @error('utilQty')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                                <input type="text" name="pkgId" value="{{ $pkgData->id }}" hidden>
                                            </td>
                                            <td>
                                                <button type="submit" class="cust-btn cust-btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Item"><i class="bi bi-plus-lg"></i></button>
                                            </td>
                                        </form>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                      


                    </div>


                    {{-- Equipment --}}
                    <div class="col col-6 h-100 overflow-auto">

                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-success text-secondary" >
                                <tr>
                                    <th class="fw-semibold">Equipment</th>
                                    <th class="fw-semibold">Size</th>
                                    <th class="fw-semibold">Unit</th>
                                    <th class="fw-semibold">Utilize</th>
                                    <th class="fw-semibold text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @session('promt-eq')
                                    <tr>
                                        <td colspan="5" class="text-center" style="font-style: normal;"><div class="text-success small mt-1">{{ $value }}</div></td>
                                    </tr>
                                @endsession
                                @if ($pkgStoData->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center text-secondary py-3">No Items Included Found.</td>
                                    </tr>
                                @else
                                    @foreach ($pkgEqData as $row)

                                        <tr>
                                            <td>{{ $row->pkgEqToEq->eq_name }}</td>
                                            <td>{{ $row->pkgEqToEq->eq_size }}</td>
                                            <td>{{ $row->pkgEqToEq->eq_unit }}</td>
                                        <form action="{{ route('Pkg-Equipment.update', $row->id) }}" method="POST">
                                            @csrf
                                            @method('put')
                                            <td>
                                                <input type="number" class="form-control w-75" name="eqUtil" value="{{ $row->eq_used }}">
                                                @error('eqUtil')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                                
                                            </td>
                                            <td class="text-center">
                                                <button type="submit" class="cust-btn cust-btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Update/Save"><i class="bi bi-floppy"></i></button>
                                        </form>
                                                <form action="{{ route('Pkg-Equipment.destroy', $row->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="cust-btn cust-btn-danger-secondary mt-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                    {{-- Add new equipment --}}
                                    <tr>
                                        <form action="{{ route('Pkg-Equipment.store') }}" method="POST">
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
                                                @error('eqUtilQty')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                                <input type="text" name="pkgId" value="{{ $pkgData->id }}" hidden>
                                            </td>
                                            <td>
                                                <button type="submit" class="cust-btn cust-btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Equipment"><i class="bi bi-plus-lg"></i></button>
                                            </td>
                                        </form>
                                    </tr>
                                @endif
                                    
                            </tbody>
                        </table>


                    </div>

                </div>
                

                <div class="mt-4">
                    @yield('package-edit')
                </div>
            </div>
        </div>
    </div>


@endsection
