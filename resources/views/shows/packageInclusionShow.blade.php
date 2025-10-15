@extends('layouts.layout')
@section('title', 'Packages')

@section('content')
    @section('head', 'Show Packages')
    @section('name', 'Staff')

    <div class="d-flex align-items-center justify-content-end cust-h-heading">
        <a href="{{ route('Package.index') }}" class="btn btn-outline-success d-flex align-items-center gap-2 px-3">
            <i class="bi bi-arrow-left"></i> <span>Back</span>
        </a>
    </div>

    <div class="cust-h-content">
        <div class="card h-100">
            <div class="card-body h-100">
                
                    <form action="{{ route('Package.update', $pkgData->id) }}" method="POST" class="mb-2">
                        @csrf
                        @method('put')
                        <div class="row g-3 align-items-end">
                            <div class="col-md-8">
                                <label class="fw-semibold text-dark mb-1">Package Name</label>
                                <input type="text" name="pkgName" class="form-control" value="{{ $pkgData->pkg_name }}">
                                @error('pkgName')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-green w-50"><i class="bi bi-floppy px-2"></i>Update</button>
                            </div>
                        </div>
                    </form>
                

                
                    <div class="table-responsive rounded-3 shadow-sm h-50">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-success text-secondary" >
                                <tr>
                                    <th class="fw-semibold">Inclusion</th>
                                    <th class="fw-semibold text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($pckIncData->isEmpty())
                                    <tr>
                                        <td colspan="2" class="text-center text-secondary py-3">No Package Inclusions Found.</td>
                                    </tr>
                                @else
                                    @foreach ($pckIncData as $row)
                                        <tr>
                                            <td>{{ $row->pkg_inclusion }}</td>
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
                

                <div class="mt-4">
                    @yield('package-edit')
                </div>
            </div>
        </div>
    </div>


@endsection
