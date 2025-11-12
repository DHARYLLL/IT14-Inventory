@extends('layouts.layout')
@section('title', 'Packages')

@section('content')
    @section('head', 'Show Packages')
    @section('name', 'Staff')


    <div class="cust-h-content-func">
        <div class="card h-100">
            <div class="card-body h-100">

                <form action="" method="post" class="h-75 test-outline">

                    <div class="row h-100">

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
                                    @if ($pkgStoData->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center text-secondary py-3">No Items Included Found.</td>
                                        </tr>
                                    @else
                                        @foreach ($pkgStoData as $row)
                                            <tr>
                                                <td>{{ $row->pkgStoToSto->item_name }}</td>
                                                <td>{{ $row->pkgStoToSto->item_size }}</td>
                                                <td>{{ $row->pkgStoToSto->item_unit }}</td>
                                                <td>{{ $row->stock_used }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('Package-Inclusion.edit', $row->id) }}"
                                                        class="btn btn-outline-success btn-md px-3"><i class="bi bi-pencil-square"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
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
                                                <td>{{ $row->stock_used }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('Package-Inclusion.edit', $row->id) }}"
                                                        class="btn btn-outline-success btn-md px-3"><i class="bi bi-pencil-square"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>


                        </div>

                    </div>

                </form>

                <form action="{{ route('Package.update', $pkgData->id) }}" method="POST" class="h-25 test-outline">
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

                <div class="mt-4">
                    @yield('package-edit')
                </div>
            </div>
        </div>
    </div>


@endsection
